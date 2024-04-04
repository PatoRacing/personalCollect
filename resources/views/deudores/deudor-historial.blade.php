@section('titulo')
    Historial de Gestiones
@endsection

<x-app-layout>
    <div class="container mx-auto ">
        <div class="overflow-x-auto">
            <div class="p-4 sticky left-0">
                <h1 class="font-extrabold text-2xl bg-white p-4 text-gray-900 text-center mb-5">{{ucwords(strtolower($deudorNombre))}} (historial): </h1>
                <a href="{{route('deudor.perfil', ['deudor' => $deudorId])}}" class="text-white bg-blue-800 hover:bg-blue-900 px-5 py-3 rounded">Volver</a>
                <a href="{{route('deudor.nueva.gestion', ['deudor' => $deudorId])}}" class="text-white bg-green-700 hover:bg-green-800 px-5 py-3 rounded">Nueva</a>
                @if(session('message'))
                    <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold mt-3 p-3 ">
                        {{ session('message') }}
                    </div>
                @endif        
            </div>
            @if($historiales->count())
                <table class="table-auto overflow-x-auto min-w-full bg-white shadow-md rounded text-sm">
                    <thead>
                        <tr class="bg-blue-800 text-white font-bold sticky-left-0">
                            <th class="px-4 py-2 bg-blue-800 sticky left-0">Accion</th>
                            <th class="px-4 py-2">Resultado</th>
                            <th class="px-4 py-2">Observaciones</th>
                            <th class="px-4 py-2">Usuario Ult. Modif.</th>
                            <th class="px-4 py-2">Fecha Ult. Modif.</th>
                            <th class="px-4 py-2">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historiales as $index => $historial)
                            <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-blue-100' }}">
                                <td class="border hover:text-blue-900 px-4 py-4 text-center sticky left-0
                                {{ $index % 2 === 0 ? 'bg-white' : 'bg-blue-100' }}">
                                    {{$historial->accion}}
                                </td>
                                
                                <td class="border px-4 py-4 text-center align-middle">
                                    {{$historial->resultado}}
                                </td>

                                <td class="border px-4 py-4 text-center align-middle">
                                    {{$historial->observaciones}}
                                </td>

                                <td class="border px-4 py-4 text-center align-middle">
                                    {{ \App\Models\User::find($historial->usuario_ultima_modificacion_id)->name }}
                                    {{ \App\Models\User::find($historial->usuario_ultima_modificacion_id)->apellido }}
                                </td>

                                <td class="border px-4 py-4 text-center align-middle">
                                    {{ \Carbon\Carbon::parse($historial->updated_at)->format('d/m/Y - H:i:s') }}
                                </td>

                                <td class="border px-4 py-4 text-center align-middle">
                                    <a href="{{route('deudor.actualizar.gestion', ['gestionesDeudores' => $historial->id])}}"
                                        class=" text-white w-28 h-10 rounded bg-indigo-500 px-4 py-3 hover:bg-indigo-800">
                                        Editar
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-800 p-2 text-center font-bold">
                    El deudor no tiene gestiones realizadas
                </p>
            @endif 
        </div>
    </div>
</x-app-layout>