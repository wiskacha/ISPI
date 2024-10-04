<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Almacene;
use App\Models\Recinto;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\Contacto;
use App\Models\Detalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movimientos = Movimiento::all();
        return view('pages.movimientos.vistaMovimientos', compact('movimientos')); // Mostrar lista de Movimientos
    }

    // Pagina para registro de movimiento
    public function register()
    {
        $almacenes = Almacene::all();
        $clientes = Persona::all();
        $recintos = Recinto::all();
        $productos = Producto::all();
        $proveedores = Persona::whereHas('contactos')->get();

        return view('pages.movimientos.registroMovimiento', compact('almacenes', 'clientes', 'recintos', 'productos', 'proveedores')); // Página para seleccionar el tipo de Movimiento
    }

    //Registro de Movimiento
    public function store(Request $request)
    {
        Log::info(request()->all());

        // Validate the request
        $request->validate([
            'almacene' => 'required|exists:almacenes,id_almacen',
            'tipo' => 'required|in:ENTRADA,SALIDA',
            'proveedor' => 'required_if:tipo,ENTRADA|nullable|exists:personas,id_persona',
            'cliente' => 'nullable|exists:personas,id_persona',
            'recinto' => 'nullable|exists:recintos,id_recinto',
            'glose' => 'nullable|string',
            // 'productos.*' => 'required|string',  // Ensure it's a string
            // 'cantidad.*' => 'required|integer|min:1',
            // 'precio.*' => 'required|numeric|min:0',
            // 'subtotal.*' => 'required|numeric|min:0',
        ]);

        // Decode the product data
        $productos = json_decode($request->productos[0], true); // Decode the first (and only) array element
        $cantidades = json_decode($request->cantidad[0], true);
        $precios = json_decode($request->precio[0], true);
        $subtotales = json_decode($request->subtotal[0], true);

        // Start a transaction
        DB::beginTransaction();

        try {
            // Generate codigo from carnet and current timestamp
            $carnet = Auth::user()->persona->carnet;
            $timestamp = now()->timestamp; // Get the current timestamp
            $codigo = $carnet . '_' . $timestamp; // Concatenate carnet and timestamp

            // Create the Movimiento
            $movimiento = Movimiento::create([
                'id_operador' => Auth::user()->id,
                'id_almacen' => $request->almacene,
                'tipo' => $request->tipo,
                'id_proveedor' => $request->tipo === 'ENTRADA' ? $request->proveedor : null,
                'id_cliente' => $request->tipo === 'SALIDA' ? $request->cliente : null,
                'id_recinto' => $request->tipo === 'SALIDA' ? $request->recinto : null,
                'glose' => $request->glose,
                'codigo' => $codigo, // Include the codigo here
            ]);

            // Prepare to create DetalleMovimiento entries
            $detalles = [];
            foreach ($productos as $index => $productoNombre) {
                // Look up the product ID based on the product name
                $producto = Producto::where('nombre', $productoNombre)->first();

                if (!$producto) {
                    // Handle the case where the product doesn't exist
                    Log::error('Product not found: ' . $productoNombre);
                    DB::rollBack();
                    return back()->withErrors(['error' => 'Product not found: ' . $productoNombre]);
                }

                // Group entries if the same product appears more than once
                if (isset($detalles[$producto->id_producto])) {
                    // Update existing detalle with new quantities and totals
                    $detalles[$producto->id_producto]['cantidad'] += $cantidades[$index];
                    $detalles[$producto->id_producto]['total'] += $subtotales[$index];
                } else {
                    // Create a new entry for the detalle
                    $detalles[$producto->id_producto] = [
                        'id_movimiento' => $movimiento->id_movimiento,
                        'id_producto' => $producto->id_producto,
                        'cantidad' => $cantidades[$index],
                        'precio' => $precios[$index],
                        'total' => $subtotales[$index],
                    ];
                }
            }

            // Insert all DetalleMovimiento entries at once
            foreach ($detalles as $detalle) {
                Detalle::create($detalle);
            }

            // Commit the transaction
            DB::commit();

            // Redirect or return a response
            return redirect()->route('movimientos.vista')->with('success', 'Movimiento registrado satisfactoriamente en el código: ' . $movimiento->codigo);
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();
            Log::error('Error registering movimiento: ' . $e->getMessage());
            return back()->withErrors(['error' => 'There was a problem registering the movimiento.']);
        }
    }
}
