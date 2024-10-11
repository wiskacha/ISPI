<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recinto;
use App\Models\Movimiento;
use App\Models\Almacene;
use App\Models\User;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\Empresa;
use Dompdf\Dompdf;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    // Mostrar lista de recintos
    public function index()
    {
        $almacenes = Almacene::all();

        //Todas las personas con users
        $operadores = Persona::has('usuario')->get();

        $productos = Producto::all();
        $empresas = Empresa::all();
        $clientes = Persona::all();
        $recintos = Recinto::all();
        $proveedores = Persona::has('contactos')->get();
        return view('pages.reportes.vistaReportes', compact('almacenes', 'operadores', 'productos', 'empresas', 'clientes', 'recintos', 'proveedores'));
    }

    public function generarReporte(Request $request)
    {
        // Initialize the query for Movimiento
        $movimientosQuery = Movimiento::query();

        // Get the 'tipo' from the request
        $tipo = $request->input('tipo');

        // Apply filters common to all report types (almacen, operador, criterio, date range, etc.)
        $this->applyCommonFilters($request, $movimientosQuery);

        // Apply 'tipo'-specific logic
        switch ($tipo) {
            case 'Existencias':
                // For Existencias, ignore the 'tipo' column (both ENTRADA and SALIDA)
                break;

            case 'Ventas':
                // For Ventas, only select 'SALIDA'
                $movimientosQuery->where('tipo', 'SALIDA');

                // Apply specific filters for Ventas (cliente, recinto, etc.)
                if ($request->clienteOption === 'specific' && $request->filled('cliente')) {
                    $movimientosQuery->where('id_cliente', $request->cliente);
                }
                if ($request->recintoOption === 'specific' && $request->filled('recinto')) {
                    $movimientosQuery->where('id_recinto', $request->recinto);
                }
                break;

            case 'Adquisiciones':
                // For Adquisiciones, only select 'ENTRADA'
                $movimientosQuery->where('tipo', 'ENTRADA');

                // Apply specific filters for Adquisiciones (proveedor)
                if ($request->proveedorOption === 'specific' && $request->filled('proveedor')) {
                    $movimientosQuery->where('id_proveedor', $request->proveedor);
                }
                break;

            default:
                // Handle invalid 'tipo' input (optional)
                return redirect()->back()->withErrors(['tipo' => 'Tipo de reporte no válido']);
        }

        // Execute the query
        $movimientos = $movimientosQuery->get();

        // Return the correct view based on 'tipo'
        if ($tipo === 'Existencias') {
            return view('pages.reportes.existencias', compact('movimientos'));
        } elseif ($tipo === 'Ventas') {
            return view('pages.reportes.ventas', compact('movimientos'));
        } elseif ($tipo === 'Adquisiciones') {
            return view('pages.reportes.adquisiciones', compact('movimientos'));
        }
    }

    protected function applyCommonFilters(Request $request, &$movimientosQuery)
    {
        // Filter by almacen
        if ($request->almacenOption === 'specific' && $request->filled('almacen')) {
            $movimientosQuery->where('id_almacen', $request->almacen);
        }

        // Filter by operador
        if ($request->operadorOption === 'specific' && $request->filled('operador')) {
            $movimientosQuery->where('id_operador', $request->operador);
        }

        // Filter by criterio: producto or empresa
        if ($request->criterioOption === 'specificP' && $request->filled('producto')) {
            $movimientosQuery->whereHas('detalles', function ($query) use ($request) {
                $query->where('id_producto', $request->producto);
            });
        } elseif ($request->criterioOption === 'specificE' && $request->filled('empresa')) {
            $movimientosQuery->whereHas('detalles.producto', function ($query) use ($request) {
                $query->where('id_empresa', $request->empresa);
            });
        }

        // Filter by date range
        if ($request->filled('desde')) {
            $movimientosQuery->where('fecha', '>=', $request->desde);
        }
        if ($request->filled('hasta')) {
            $movimientosQuery->where('fecha', '<=', $request->hasta);
        }
    }

    public function imprimirDesglose(Request $request)
    {
        // Decode the JSON-encoded movimiento IDs
        $movimientoIds = json_decode($request->input('movimiento_ids'), true);

        // Fetch the movimientos based on the IDs
        $movimientos = Movimiento::whereIn('id_movimiento', $movimientoIds)->get();


        // Generate the PDF using the fetched movimientos
        $pdf = PDF::loadView('pages.reportes.pdf.desglose', compact('movimientos'))
            ->setPaper('a4', 'landscape'); // Set paper size and orientation

        return $pdf->stream('reporte_movimientos.pdf');
    }
}
