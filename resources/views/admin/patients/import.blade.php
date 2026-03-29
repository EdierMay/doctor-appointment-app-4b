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
        <h2 class="text-lg font-medium text-gray-900 mb-4">
            Importar Pacientes desde Excel / CSV
        </h2>
        
        <p class="text-sm text-gray-600 mb-6">
            Sube un archivo con los campos: <strong>nombre_completo, correo, telefono, fecha_nacimiento, tipo_sangre, alergias</strong>. 
            El procesamiento se realizará en segundo plano.
        </p>

        <form action="{{ route('admin.patients.import.store') }}" method="POST" enctype="multipart/form-data" x-data="{ loading: false, fileName: '' }" @submit="if(fileName){ loading = true }">
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
                <button type="submit" :disabled="loading" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-75 cursor-pointer">
                    <span x-show="!loading"><i class="fa-solid fa-paper-plane mr-2"></i> Procesar en Segundo Plano</span>
                    <span x-show="loading" style="display: none;">
                        <i class="fa-solid fa-circle-notch fa-spin mr-2"></i> Cargando y procesando...
                    </span>
                </button>
            </div>
        </form>
    </div>

</x-admin-layout>
