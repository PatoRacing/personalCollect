<?php

namespace App\Http\Controllers;

use App\Exports\PropuestasExport;
use App\Models\Deudor;
use App\Models\Operacion;
use App\Models\Producto;
use App\Models\Propuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class PropuestaController extends Controller
{
    public function index(Propuesta $propuesta)
    {
        return view('propuestas.propuestas');
    }
    
}
