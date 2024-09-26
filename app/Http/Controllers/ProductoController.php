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
    // Show the form for registering a new product
    public function register()
    {
        $empresas = Empresa::all(); // Fetch all products

        return view('pages.productos.registrarProductos', compact('empresas'));
    }

    // Show the form for editing a product
    public function edit(Producto $producto)
    {
        return view('pages.productos.editarProductos', compact('producto'));
    }

    // Show the list of products
    public function index()
    {
        $productos = Producto::all(); // Fetch all products
        return view('pages.productos.vistaProductos', compact('productos'));
    }


    public function store(RegisterRequestProducto $request)
    {
        // Start by initializing the folderName at the beginning
        $folderName = null;

        DB::beginTransaction(); // Start the transaction

        try {
            $validatedData = $request->validated();

            // Create the product
            $producto = Producto::create($validatedData);

            // Generate a unique folder name based on the product name and created_at date
            $folderName = substr($producto->nombre, 0, 4) . '_' . $producto->created_at->format('YmdHis');
            $mainFolderPath = 'productos/' . $folderName . '/main';
            $photosFolderPath = 'productos/' . $folderName . '/photos';
            $documentsFolderPath = 'productos/' . $folderName . '/documents';

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
                            'uri' => $mainFolderPath . '/main.png',
                            'descripcion' => 'main.png',
                            'id_producto' => $producto->id_producto,
                        ]);

                        // Create the Adjunto
                        Adjunto::create([
                            'uri' => $mainFolderPath . '/main.png',
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
                Storage::deleteDirectory('productos/' . $folderName);
            }

            return redirect()->back()->withErrors('There was an error registering the product. Please try again.');
        }
    }



    // Update the specified product in storage
    public function update(UpdateRequestProducto $request, Producto $producto)
    {
        $validatedData = $request->validated(); // Using the validated data from the request

        // Update the product
        $producto->update($validatedData);

        // Handle file uploads for attachments
        if ($request->hasFile('adjuntos')) {
            foreach ($request->file('adjuntos') as $file) {
                $uri = $file->store('adjuntos'); // Save the file
                Adjunto::create([
                    'uri' => $uri,
                    'descripcion' => $file->getClientOriginalName(),
                    'id_producto' => $producto->id_producto,
                ]);
            }
        }

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }
}
