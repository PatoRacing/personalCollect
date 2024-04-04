<?php

namespace App\Http\Livewire;

use App\Imports\AcuerdosTemporalesImport;
use App\Models\Acuerdo as ModelsAcuerdo;
use App\Models\AcuerdoTemporal;
use App\Models\Pago;
use App\Models\Propuesta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class Acuerdo extends Component
{
    public $modalImportacion = true;

    public function quitarModal()
    {
        $this->modalImportacion = false;
    }

    public function render()
    {
        return view('livewire.acuerdo');
    }
}
