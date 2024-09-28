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
            $producto->delete(); // Soft delete
            return redirect()->route('productos.vista')->with('success', 'Persona eliminada correctamente.');
        } else {
            return redirect()->route('productos.vista')->with('error', 'Persona no encontrada.');
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
        $imagePath = 'storage/productos/' . $folderName . '/main/main.png';

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
            $imagePath = 'public/productos/' . substr($producto->nombre, 0, 4) . '_' . $producto->created_at->format('YmdHis') . '/main/main.png';

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
                        $image->save(storage_path('app/' . $mainFolderPath . '/main.png'));

                        // Log the URI and product ID before creating the Adjunto
                        Log::info('Creating Adjunto entry: ', [
                            'uri' => 'storage/productos/' . $folderName . '/main/main.png',  // Correct URL for serving via /storage
                            'descripcion' => 'main.png',
                            'id_producto' => $producto->id_producto,
                        ]);

                        // Create the Adjunto
                        Adjunto::create([
                            'uri' => 'storage/productos/' . $folderName . '/main/main.png',  // Correct path for the Adjunto
                            'descripcion' => 'main.png',
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

        try {
            $validatedData = $request->validated();

            // Convert tags from comma-separated string to JSON array
            if (isset($validatedData['tags'])) {
                $validatedData['tags'] = json_encode(array_map('trim', explode(',', $validatedData['tags'])));
            }

            // Update the product
            $producto->update($validatedData);

            // Generate the folder name again
            $folderName = substr($producto->nombre, 0, 4) . '_' . $producto->created_at->format('YmdHis');
            $mainFolderPath = 'public/productos/' . $folderName . '/main';

            // Handle image upload
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = Image::read($request->file('image'));
                $image->resize(512, 512);
                $image->save(storage_path('app/' . $mainFolderPath . '/main.png'));

                // Update or create the Adjunto entry
                Adjunto::updateOrCreate(
                    ['id_producto' => $producto->id_producto, 'descripcion' => 'main.png'],
                    ['uri' => 'storage/productos/' . $folderName . '/main/main.png']
                );
            }

            // Handle image deletion
            if ($request->has('delete_image')) {
                Storage::delete($mainFolderPath . '/main.png'); // Delete the main.png file
            }

            DB::commit();
            return redirect()->route('productos.vista')->with('success', 'Producto actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Error al actualizar el producto.');
        }
    }
}
