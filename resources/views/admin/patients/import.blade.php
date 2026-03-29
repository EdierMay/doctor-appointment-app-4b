<x-admin-layout
    title="Importar Pacientes | Healthify"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Pacientes',
            'href' => route('admin.patients.index'),
        ],
        [
            'name' => 'Importar Masivamente',
        ],
    ]"
>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        
        <div class="lg:flex lg:justify-between lg:items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    <i class="fa-solid fa-file-arrow-up text-indigo-500 mr-2"></i>
                    Importación Masiva de Pacientes
                </h1>
                <p class="text-gray-500 text-sm mt-1">
                    Sube un archivo CSV con la información de múltiples pacientes. El procesamiento
                    se realizará en <strong>segundo plano</strong> para no bloquear el sistema.
                </p>
            </div>
            <div class="mt-4 lg:mt-0 flex space-x-3">
                <a href="{{ route('admin.patients.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Volver
                </a>
                <a href="{{ route('admin.patients.import-template') }}" class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fa-solid fa-download mr-2"></i>
                    Descargar plantilla CSV
                </a>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-base font-semibold text-gray-800 mb-3">
                <i class="fa-solid fa-circle-info text-indigo-400 mr-1"></i>
                Formato requerido del archivo CSV
            </h2>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full text-xs text-left text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 uppercase">
                        <tr>
                            <th class="px-4 py-2">Columna</th>
                            <th class="px-4 py-2">Descripción</th>
                            <th class="px-4 py-2">Obligatorio</th>
                            <th class="px-4 py-2">Ejemplo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ([
                            ['nombre_completo',        'Nombre completo del paciente',            true,  'Juan Pérez'],
                            ['correo',                 'Correo electrónico (único)',              true,  'juan@ejemplo.com'],
                            ['telefono',               'Teléfono de contacto',                    false, '9998887766'],
                            ['fecha_nacimiento',       'Fecha de Nacimiento (YYYY-MM-DD)',        false, '1990-05-15'],
                            ['tipo_sangre',            'Tipo de sangre (debe existir en el sistema)', false, 'O+'],
                            ['alergias',               'Alergias conocidas',                      false, 'Polen, polvo'],
                        ] as [$col, $desc, $req, $ej])
                        <tr>
                            <td class="px-4 py-2 font-mono font-semibold text-indigo-700">{{ $col }}</td>
                            <td class="px-4 py-2">{{ $desc }}</td>
                            <td class="px-4 py-2">
                                @if($req)
                                    <span class="inline-block bg-red-100 text-red-700 text-xs font-semibold px-2 py-0.5 rounded-full">Sí</span>
                                @else
                                    <span class="inline-block bg-gray-100 text-gray-500 text-xs px-2 py-0.5 rounded-full">No</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-gray-500 italic">{{ $ej }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="text-xs text-gray-400 mt-3">
                <i class="fa-solid fa-triangle-exclamation text-amber-400 mr-1"></i>
                La primera fila debe ser el encabezado exacto. El sistema generará una contraseña o identificador automáticamente de ser necesario.
            </p>
        </div>

        <form action="{{ route('admin.patients.import.store') }}" method="POST" enctype="multipart/form-data" x-data="{ loading: false, fileName: '' }" @submit="if(fileName){ setTimeout(() => { loading = true }, 50); }">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Archivo a importar (.csv, .xlsx)</label>
                
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md relative cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition-colors" onclick="document.getElementById('file-upload').click()">
                    <div class="space-y-1 text-center">
                        <i x-show="!fileName" class="fa-solid fa-cloud-arrow-up text-4xl text-gray-400 mb-3"></i>
                        <i x-show="fileName" class="fa-solid fa-file-excel text-4xl text-green-500 mb-3" style="display: none;"></i>
                        
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500" onclick="event.stopPropagation()">
                                <span x-text="fileName ? 'Archivo seleccionado' : 'Sube un archivo'">Sube un archivo</span>
                                <input id="file-upload" name="file" type="file" class="sr-only" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required @change="fileName = $event.target.files[0].name">
                            </label>
                            <p class="pl-1" x-show="!fileName">o arrastra y suelta aquí</p>
                        </div>
                        <p class="text-xs text-gray-500" x-show="!fileName">CSV o Excel hasta 10MB</p>
                        <p class="text-sm font-semibold text-indigo-600 mt-2" x-show="fileName" x-text="fileName" style="display: none;"></p>
                    </div>
                </div>

                @error('file')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('admin.patients.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                    Cancelar
                </a>
                <button type="submit" :class="{ 'opacity-75 cursor-not-allowed pointer-events-none': loading }" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <span x-show="!loading"><i class="fa-solid fa-paper-plane mr-2"></i> Procesar en Segundo Plano</span>
                    <span x-show="loading" style="display: none;" x-cloak>
                        <i class="fa-solid fa-circle-notch fa-spin mr-2"></i> Cargando y procesando...
                    </span>
                </button>
            </div>
        </form>
    </div>

</x-admin-layout>
