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
        // Inicializamos el query para Movimiento
        $movimientosQuery = Movimiento::query();

        // Inicializamos la variable para almacenar los criterios de búsqueda
        $criteriosB = [];

        // Obtener el 'tipo' del request
        $tipo = $request->input('tipo');
        $criteriosB['tipo'] = $tipo;

        // Aplicar filtros comunes a todos los tipos de reportes
        $this->applyCommonFilters($request, $movimientosQuery, $criteriosB);

        // Aplicar lógica específica del 'tipo'
        switch ($tipo) {
            case 'Existencias':
                $criteriosB['filtro_tipo'] = 'Ignorado (Existencias)';
                break;

            case 'Ventas':
                $movimientosQuery->where('tipo', 'SALIDA');
                $criteriosB['filtro_tipo'] = 'SALIDA';

                // Filtros específicos para Ventas
                if ($request->clienteOption === 'specific' && $request->filled('cliente')) {
                    $cliente = Persona::find($request->cliente);
                    $movimientosQuery->where('id_cliente', $request->cliente);
                    $criteriosB['cliente'] = $cliente ? $cliente->carnet : null;
                }
                if ($request->recintoOption === 'specific' && $request->filled('recinto')) {
                    $recinto = Recinto::find($request->recinto);
                    $movimientosQuery->where('id_recinto', $request->recinto);
                    $criteriosB['recinto'] = $recinto ? $recinto->nombre : null;
                }
                break;

            case 'Adquisiciones':
                $movimientosQuery->where('tipo', 'ENTRADA');
                $criteriosB['filtro_tipo'] = 'ENTRADA';

                if ($request->proveedorOption === 'specific' && $request->filled('proveedor')) {
                    $proveedor = Persona::find($request->proveedor);
                    $movimientosQuery->where('id_proveedor', $request->proveedor);
                    $criteriosB['proveedor'] = $proveedor ? $proveedor->carnet : null;
                }
                break;

            default:
                return redirect()->back()->withErrors(['tipo' => 'Tipo de reporte no válido']);
        }

        // Convertir $criteriosB a un objeto de tipo stdClass
        $criteriosB = (object) $criteriosB;

        // Ejecutar el query
        $movimientos = $movimientosQuery->get();

        // Retornar la vista correcta basada en el 'tipo'
        if ($tipo === 'Existencias') {
            return view('pages.reportes.existencias', compact('movimientos', 'criteriosB'));
        } elseif ($tipo === 'Ventas') {
            return view('pages.reportes.ventas', compact('movimientos', 'criteriosB'));
        } elseif ($tipo === 'Adquisiciones') {
            return view('pages.reportes.adquisiciones', compact('movimientos', 'criteriosB'));
        }
    }

    protected function applyCommonFilters(Request $request, &$movimientosQuery, &$criteriosB)
    {
        // Filtro por almacen
        if ($request->almacenOption === 'specific' && $request->filled('almacen')) {
            $almacen = Almacene::find($request->almacen);
            $movimientosQuery->where('id_almacen', $request->almacen);
            $criteriosB['almacen'] = $almacen ? $almacen->nombre : null;
        }

        // Filtro por operador
        if ($request->operadorOption === 'specific' && $request->filled('operador')) {
            $operador = Persona::find($request->operador);
            $movimientosQuery->where('id_operador', $request->operador);
            $criteriosB['operador'] = $operador ? $operador->carnet : null;
        }

        // Filtro por criterio: producto o empresa
        if ($request->criterioOption === 'specificP' && $request->filled('producto')) {
            $producto = Producto::find($request->producto);
            $movimientosQuery->whereHas('detalles', function ($query) use ($request) {
                $query->where('id_producto', $request->producto);
            });
            $criteriosB['producto'] = $producto ? $producto->codigo : null;
        } elseif ($request->criterioOption === 'specificE' && $request->filled('empresa')) {
            $empresa = Empresa::find($request->empresa);
            $movimientosQuery->whereHas('detalles.producto', function ($query) use ($request) {
                $query->where('id_empresa', $request->empresa);
            });
            $criteriosB['empresa'] = $empresa ? $empresa->nombre : null;
        }

        if ($request->fechaOption === 'create') {
            $criteriosB['criterio_fecha'] = 'Creados entre: ';
            // Filtro por rango de fechas
            if ($request->filled('desde')) {
                $movimientosQuery->where('fecha', '>=', $request->desde);
                $criteriosB['desde'] = $request->desde;
            }
            if ($request->filled('hasta')) {
                $movimientosQuery->where('fecha', '<=', $request->hasta);
                $criteriosB['hasta'] = $request->hasta;
            }
        } elseif ($request->fechaOption === 'final') {
            $criteriosB['criterio_fecha'] = 'Finalizados entre: ';
            if ($request->filled('desde')) {
                $movimientosQuery->where('fecha_f', '>=', $request->desde);
                $criteriosB['desde'] = $request->desde;
            }
            if ($request->filled('hasta')) {
                $movimientosQuery->where('fecha_f', '<=', $request->hasta);
                $criteriosB['hasta'] = $request->hasta;
            }
        }
    }

    public function imprimirDesglose(Request $request)
    {
        // Decodificar los IDs de los movimientos
        $movimientoIds = json_decode($request->input('movimiento_ids'), true);

        // Decodificar los criterios de búsqueda
        $criteriosB = json_decode($request->input('criteriosB'), true);
        // Fetch los movimientos basados en los IDs
        $movimientos = Movimiento::whereIn('id_movimiento', $movimientoIds)->get();

        $view = $request->has('cn_cuotas')
            ? 'pages.reportes.pdf.desglose'
            : 'pages.reportes.pdf.desgloseSCuotas';

        if ($request->input('action') == 'pdf') {
            // Generate the PDF and stream it
            $pdf = PDF::loadView($view, compact('movimientos', 'criteriosB'))
                ->setPaper('a4', 'landscape');
            return $pdf->stream('reporte_movimientos.pdf');
        } elseif ($request->input('action') == 'preview') {
            // Return the HTML preview
            return view($view, compact('movimientos', 'criteriosB'));
        } elseif ($request->input('action') == 'download') {
            // Generate and download the PDF
            $pdf = PDF::loadView($view, compact('movimientos', 'criteriosB'))
                ->setPaper('a4', 'landscape');
            return $pdf->download('reporte_movimientos.pdf');
        }
    }

    public function imprimirDesglosePorProducto(Request $request)
    {
        // Decodificar los IDs de los movimientos
        $movimientoIds = json_decode($request->input('movimiento_ids'), true);
        // Decodificar los criterios de búsqueda
        $criteriosB = json_decode($request->input('criteriosB'), true);
        // Fetch los movimientos basados en los IDs
        $movimientos = Movimiento::whereIn('id_movimiento', $movimientoIds)->get();
        $view = $request->has('cn_cuotas')
            ? 'pages.reportes.pdf.desgloseP'
            : 'pages.reportes.pdf.desgloseP';

        if ($request->input('action') == 'pdf') {
            // Generate the PDF and stream it
            $pdf = PDF::loadView($view, compact('movimientos', 'criteriosB'))
                ->setPaper('a4', 'landscape');
            return $pdf->stream('reporte_movimientos.pdf');
        } elseif ($request->input('action') == 'preview') {
            // Return the HTML preview
            return view($view, compact('movimientos', 'criteriosB'));
        } elseif ($request->input('action') == 'download') {
            // Generate and download the PDF
            $pdf = PDF::loadView($view, compact('movimientos', 'criteriosB'))
                ->setPaper('a4', 'landscape');
            return $pdf->download('reporte_movimientos.pdf');
        }
    }
}
