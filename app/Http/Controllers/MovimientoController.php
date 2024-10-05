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
use App\Models\Detalle;
use App\Models\Cuota;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Http\Requests\RegisterCuotasRequest;


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

            // Redirect based on the tipo of the movimiento
            if ($movimiento->tipo === 'SALIDA') {
                return $this->asignarCuotas($movimiento->id_movimiento);
            }

            // If tipo is not SALIDA, redirect to the normal view
            return redirect()->route('movimientos.vista')->with('success', 'Movimiento registrado satisfactoriamente en el código: ' . $movimiento->codigo);
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();
            Log::error('Error registering movimiento: ' . $e->getMessage());
            return back()->withErrors(['error' => 'There was a problem registering the movimiento.']);
        }
    }

    public function asignarCuotas($id_movimiento)
    {

        // Retrieve the Movimiento details based on the ID
        $movimiento = Movimiento::findOrFail($id_movimiento);
        $detalles = $movimiento->detalles; // Assuming the relationship is defined
        $clientes = Persona::all();
        // dd($movimiento);
        // Calculate the total amount from Detalles
        $total = $detalles->sum('total');

        // Return the view with the necessary data
        return view('pages.movimientos.cuotas.asignarCuotas', [
            'movimiento' => $movimiento,
            'total' => $total,
            'clientes' => $clientes,
        ]);
    }

    public function storeCuotas(RegisterCuotasRequest $request)
    {
        // Retrieve the Movimiento to which the cuotas will be related
        $movimiento = Movimiento::findOrFail($request->id_movimiento);
    
        // Check if there are existing cuotas for this movimiento
        if ($movimiento->cuotas()->exists()) {
            return redirect()->route('movimientos.vista')->withErrors(['error' => 'Ya existen cuotas asignadas para este movimiento.']);
        }
    
        // Retrieve detalles related to the movimiento
        $detalles = $movimiento->detalles; // Assuming the relationship is defined
    
        // Calculate the total amount from Detalles
        $total = $detalles->sum('total');
        $codigoBase = 'CT0-' . now()->timestamp;
    
        if ($request->tipo_pago === 'CONTADO') {
            // Handle CONTADO payment type
            $descuento = $request->descuento ?? 0;
            $montoPagar = $total - $descuento;
    
            // Create the cuota for CONTADO
            Cuota::create([
                'numero' => 1,
                'codigo' => $codigoBase,
                'concepto' => 'Pago único',
                'fecha_venc' => now(),
                'monto_pagar' => $montoPagar,
                'monto_pagado' => $montoPagar,
                'monto_adeudado' => 0,
                'condicion' => 'PAGADA',
                'id_movimiento' => $movimiento->id_movimiento,
            ]);
        } elseif ($request->tipo_pago === 'CRÉDITO') {
            // Handle CRÉDITO payment type
            $aditivo = $request->aditivo ?? 0;
            $cantidadCuotas = $request->cantidad_cuotas;
            $primerPago = $request->primer_pago;
            $totalConAditivo = $total + $aditivo;
            $montoPagar = ceil($totalConAditivo / $cantidadCuotas); // Calculate amount per cuota
    
            // Initialize remaining payment
            $montoPagado = $primerPago;
    
            for ($i = 1; $i <= $cantidadCuotas; $i++) {
                $montoAdeudado = $montoPagar; // Initial amount due for this cuota
                $estado = 'PENDIENTE'; // Default condition
    
                // If there is enough payment to cover this cuota
                if ($montoPagado >= $montoPagar) {
                    $montoPagado -= $montoPagar; // Deduct the cuota amount from primer_pago
                    $montoPagadoCuota = $montoPagar; // Full cuota is paid
                    $montoAdeudado = 0; // No amount due
                    $estado = 'PAGADA'; // Mark cuota as paid
                } else {
                    // Not enough to cover the full cuota
                    $montoPagadoCuota = $montoPagado; // Use the remaining amount for this cuota
                    $montoAdeudado = $montoPagar - $montoPagado; // Remaining amount after payment
                    $montoPagado = 0; // All remaining payment is used
                }
                $codigoBase = 'CT'. $i .'-' . now()->timestamp;
                // Create each cuota
                Cuota::create([
                    'numero' => $i,
                    'codigo' => $codigoBase,
                    'concepto' => 'Cuota #' . $i,
                    'fecha_venc' => now()->addMonths($i - 1),
                    'monto_pagar' => $montoPagar,
                    'monto_pagado' => $montoPagadoCuota,
                    'monto_adeudado' => $montoAdeudado,
                    'condicion' => $estado,
                    'id_movimiento' => $movimiento->id_movimiento,
                ]);
    
                // If the cuota was fully paid, there's no need to continue
                if ($estado === 'PAGADA' && $montoAdeudado === 0) {
                    continue; // Move to the next cuota
                }
            }
        }
    
        return redirect()->route('movimientos.vista')->with('success', 'Cuotas asignadas exitosamente.');
    }
    
    
}
