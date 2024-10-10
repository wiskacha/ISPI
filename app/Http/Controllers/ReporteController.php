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
        return view('pages.reportes.vistaReportes', compact('almacenes', 'operadores', 'productos', 'empresas', 'clientes', 'recintos','proveedores' ));
    }

}
