<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Producto;
use App\Http\Requests\RegisterRequestProducto;
use App\Http\Requests\UpdateRequestProducto;
use App\Models\Adjunto;
use App\Models\Empresa;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function destroy($id)
    {
        $producto = Producto::find($id);
        if ($producto) {
            // Check if the producto has a related detalles record
            $hasDetalles = $producto->detalles()->exists();
            // if it does prevent deletion and return an error message
            if ($hasDetalles) {
                Log::info('Attempted to delete producto with id: ' . $id . ' but it has related detalles records.');
                return redirect()->route('productos.vista')->with('error', 'No se puede eliminar el producto porque tiene detalles asociados.');
                // If it doesn't, proceed with the deletion
            } else {

                $producto->delete(); // Soft delete
            }
            return redirect()->route('productos.vista')->with('success', 'Producto eliminado correctamente.');
        } else {
            return redirect()->route('productos.vista')->with('error', 'Producto no encontrado.');
        }
    }
    // Show the form for registering a new product
    public function register()
    {
        $empresas = Empresa::all(); // Fetch all products

        return view('pages.productos.registrarProductos', compact('empresas'));
    }

    // Show the form for editing a product
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);

        // Derive folder name
        $folderName = substr($producto->nombre, 0, 4) . '_' . $producto->created_at->format('YmdHis');
        $imagePath = 'storage/productos/' . $folderName . '/main/main.jpeg';

        // Pass the derived image path and product data to the view
        return view('pages.productos.editarProductos', [
            'producto' => $producto,
            'imagePath' => $imagePath,
            'empresas' => Empresa::all(), // Assuming you're passing 'empresas' to select from
        ]);
    }


    // Show the list of products
    public function index()
    {
        $productos = Producto::all();

        foreach ($productos as $producto) {
            Log::info('Producto: ', [
                'nombre' => $producto->nombre,
                'image_base64' => $producto->image_base64 ? 'Image exists' : 'No Image'
            ]);
            $imagePath = 'public/productos/' . substr($producto->nombre, 0, 4) . '_' . $producto->created_at->format('YmdHis') . '/main/main.jpeg';

            if (Storage::exists($imagePath)) {
                // Cargar la imagen y codificarla en Base64
                $producto->image_base64 = base64_encode(Storage::get($imagePath));
            } else {
                $producto->image_base64 = null;
            }
        }

        return view('pages.productos.vistaProductos', compact('productos'));
    }
    public function store(RegisterRequestProducto $request)
    {
        // Start by initializing the folderName at the beginning
        $folderName = null;

        DB::beginTransaction(); // Start the transaction

        try {
            $validatedData = $request->validated();

            // Convert tags from comma-separated string to JSON array
            if (isset($validatedData['tags'])) {
                $validatedData['tags'] = json_encode(array_map('trim', explode(',', $validatedData['tags'])));
            }

            // Create the product
            $producto = Producto::create($validatedData);

            // Generate a unique folder name based on the product name and created_at date
            $folderName = substr($producto->nombre, 0, 4) . '_' . $producto->created_at->format('YmdHis');
            $mainFolderPath = 'public/productos/' . $folderName . '/main';  // Using 'public' disk
            $photosFolderPath = 'public/productos/' . $folderName . '/photos';
            $documentsFolderPath = 'public/productos/' . $folderName . '/documents';

            // Create the folders
            Storage::makeDirectory($mainFolderPath);
            Storage::makeDirectory($photosFolderPath);
            Storage::makeDirectory($documentsFolderPath);

            // Handle file uploads for attachments
            if ($request->hasFile('adjuntos')) {
                foreach ($request->file('adjuntos') as $file) {
                    // Validate file type
                    if ($file->isValid() && in_array($file->extension(), ['png', 'jpg', 'jpeg'])) {
                        // Log the file details before attempting to store
                        Log::info('Processing file: ', ['name' => $file->getClientOriginalName()]);

                        // Create an image instance from the uploaded file using Intervention Image
                        $image = Image::read($file);

                        // Resize the image
                        $image->resize(512, 512);

                        // Store the processed image in the main folder with the name 'main.png'
                        $image->save(storage_path('app/' . $mainFolderPath . '/main.jpeg'));

                        // Log the URI and product ID before creating the Adjunto
                        Log::info('Creating Adjunto entry: ', [
                            'uri' => 'storage/productos/' . $folderName . '/main/main.jpeg',  // Correct URL for serving via /storage
                            'descripcion' => 'main.jpeg',
                            'id_producto' => $producto->id_producto,
                        ]);

                        // Create the Adjunto
                        Adjunto::create([
                            'uri' => 'storage/productos/' . $folderName . '/main/main.jpeg',  // Correct path for the Adjunto
                            'descripcion' => 'main.jpeg',
                            'id_producto' => $producto->id_producto,
                        ]);
                    } else {
                        // Log invalid file type
                        Log::warning('Invalid file type for file: ', ['name' => $file->getClientOriginalName()]);
                    }
                }
            }

            DB::commit(); // Commit the transaction if everything is successful

            return redirect()->route('productos.vista')->with('success', 'Producto registrado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction in case of any failure

            // Log the error
            Log::error('Error during product creation: ', ['error' => $e->getMessage()]);

            // If the folderName is set (i.e., product was created), delete directories
            if ($folderName) {
                Storage::deleteDirectory('public/productos/' . $folderName);
            }

            return redirect()->back()->withErrors('There was an error registering the product. Please try again.');
        }
    }




    // Update the specified product in storage
    public function update(UpdateRequestProducto $request, $id_producto)
    {
        $producto = Producto::findOrFail($id_producto);

        DB::beginTransaction();
        $folderName = null;

        try {

            $validatedData = $request->validated();
            // Handle tags conversion to JSON
            if (isset($validatedData['tags'])) {
                $validatedData['tags'] = json_encode(array_map('trim', explode(',', $validatedData['tags'])));
            }

            // Update the product with validated data
            $producto->update($validatedData);

            // Create folder structure for images and documents
            $folderName = substr($producto->nombre, 0, 4) . '_' . $producto->created_at->format('YmdHis');
            $mainFolderPath = 'public/productos/' . $folderName . '/main';
            $photosFolderPath = 'public/productos/' . $folderName . '/photos';
            $documentsFolderPath = 'public/productos/' . $folderName . '/documents';

            Storage::makeDirectory($mainFolderPath);
            Storage::makeDirectory($photosFolderPath);
            Storage::makeDirectory($documentsFolderPath);

            // Handle main image update
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $tempImagePath = $request->file('image')->store('temp');
                $image = Image::read(storage_path('app/' . $tempImagePath));

                $width = $image->width();
                $height = $image->height();
                $aspectRatio = $width / $height;

                // Calculate new dimensions
                if ($width > $height) {
                    // Landscape
                    $newWidth = min($width, 512);
                    $newHeight = $newWidth / $aspectRatio;
                } else {
                    // Portrait
                    $newHeight = min($height, 512);
                    $newWidth = $newHeight * $aspectRatio;
                }

                // Resize and save the main image
                $image->resize($newWidth, $newHeight, function ($constraint) {
                    $constraint->upsize();
                });

                $image->save(storage_path('app/' . $mainFolderPath . '/main.jpeg'));
                Storage::delete($tempImagePath);

                Adjunto::updateOrCreate(
                    ['id_producto' => $producto->id_producto, 'descripcion' => 'main.jpeg'],
                    ['uri' => 'storage/productos/' . $folderName . '/main/main.jpeg']
                );
            }

            // Handle deletion of the main image if requested
            if ($request->has('delete_image')) {
                $mainImagePath = $mainFolderPath . '/main.jpeg'; // Specify the main image path
                Log::info('Attempting to delete main file at: ' . $mainImagePath);
                if (Storage::exists($mainImagePath)) {
                    Storage::delete($mainImagePath); // Delete the main image file
                }
                Adjunto::where('id_producto', $producto->id_producto)->where('descripcion', 'main.jpeg')->delete();
            }
            // Check for deleted images
            if ($request->has('deleted_images')) {
                $deletedImages = explode(',', rtrim($request->input('deleted_images'), ','));
                foreach ($deletedImages as $imageId) {
                    $adjunto = Adjunto::find($imageId);
                    if ($adjunto) {
                        // Construct the file path correctly
                        $filePath = 'productos/' . $folderName . '/photos/' . basename($adjunto->uri); // Use basename to get the filename
                        Log::info('Attempting to delete file at: ' . $filePath);

                        // Log the full physical path for debugging
                        $fullPhysicalPath = storage_path('app/public/' . $filePath);
                        Log::info('Full physical path to the image: ' . $fullPhysicalPath);

                        // Check for existence using the public disk
                        if (Storage::disk('public')->exists($filePath)) {
                            Storage::disk('public')->delete($filePath); // Delete the file
                            Log::info('Deleted file at: ' . $filePath);
                        } else {
                            Log::warning('File not found for deletion: ' . $filePath); // Log the warning
                        }

                        // Delete the record from the database
                        $adjunto->delete();
                    }
                }
            }

            Log::info($request);
            // Handle multiple images
            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $key => $photo) {
                    $imageCount = $key; // The key should correspond to the image input number
                    Log::info("Processing image input number: {$imageCount}");

                    if ($imageCount <= 3 && $photo->isValid()) {
                        Log::info("Image {$imageCount} is valid. Proceeding with upload.");

                        // Store temporary image file
                        $tempPhotoPath = $photo->store('temp');
                        Log::info("Stored temp image at: {$tempPhotoPath}");

                        // Read the image using Intervention Image
                        $photoImage = Image::read(storage_path('app/' . $tempPhotoPath));
                        Log::info("Read image from temp path: " . storage_path('app/' . $tempPhotoPath));

                        $width = $photoImage->width();
                        $height = $photoImage->height();
                        $aspectRatio = $width / $height;

                        Log::info("Original Image Dimensions: Width = {$width}, Height = {$height}");

                        // Calculate new dimensions
                        if ($width > $height) {
                            $newWidth = min($width, 1920);
                            $newHeight = $newWidth / $aspectRatio;
                        } else {
                            $newHeight = min($height, 1920);
                            $newWidth = $newHeight * $aspectRatio;
                        }

                        Log::info("Resized Image Dimensions: New Width = {$newWidth}, New Height = {$newHeight}");

                        // Resize and save the photo
                        $photoImage->resize($newWidth, $newHeight, function ($constraint) {
                            $constraint->upsize();
                        });

                        $photoPath = $photosFolderPath . '/img' . $imageCount . '.jpeg'; // Respect the image input number (img1, img2, img3)
                        $photoImage->save(storage_path('app/' . $photoPath));

                        Log::info("Saved resized image to: " . storage_path('app/' . $photoPath));

                        // Delete the temporary file
                        Storage::delete($tempPhotoPath);
                        Log::info("Deleted temp image at: {$tempPhotoPath}");

                        // Update or create the adjunto record for the specific image
                        $adjunto = Adjunto::updateOrCreate(
                            ['id_producto' => $producto->id_producto, 'descripcion' => 'img' . $imageCount . '.jpeg'],
                            ['uri' => 'storage/productos/' . $folderName . '/photos/img' . $imageCount . '.jpeg']
                        );

                        Log::info("Updated or created Adjunto record for image {$imageCount}, Adjunto ID: {$adjunto->id_adjunto}");
                    } else {
                        Log::error("Image {$key} is invalid or failed to upload.");
                        return redirect()->back()->withErrors("Error: Image {$key} failed to upload.");
                    }
                }
            }



            // Handle document uploads (PDFs)
            if ($request->hasFile('documentos')) {
                foreach ($request->file('documentos') as $key => $document) {
                    $documentCount = $key; // The key should correspond to the document input number (doc1, doc2)
                    if ($documentCount <= 2 && $document->isValid() && $document->extension() == 'pdf') {
                        $documentPath = $documentsFolderPath . '/doc' . $documentCount . '.pdf';
                        $document->storeAs('public/productos/' . $folderName . '/documents', 'doc' . $documentCount . '.pdf');

                        Adjunto::updateOrCreate(
                            ['id_producto' => $producto->id_producto, 'descripcion' => 'doc' . $documentCount . '.pdf'],
                            ['uri' => 'storage/productos/' . $folderName . '/documents/doc' . $documentCount . '.pdf']
                        );
                    }
                }
            }

            // Handle deleted documents
            if ($request->has('deleted_documents')) {
                $deletedDocuments = explode(',', rtrim($request->input('deleted_documents'), ','));
                foreach ($deletedDocuments as $documentId) {
                    $adjunto = Adjunto::find($documentId);
                    if ($adjunto) {
                        $filePath = $adjunto->uri;
                        if (Storage::disk('public')->exists($filePath)) {
                            Storage::disk('public')->delete($filePath);
                        }
                        $adjunto->delete();
                    }
                }
            }

            DB::commit(); // Commit the transaction
            return redirect()->route('productos.vista')->with('success', 'Producto actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction in case of error

            // Log the error
            Log::error('Error during product update: ', ['error' => $e->getMessage()]);

            // If the folder was created, delete the directory
            if ($folderName) {
                Storage::deleteDirectory('public/productos/' . $folderName);
            }

            return redirect()->back()->withErrors('Error al actualizar el producto.');
        }
    }
}
