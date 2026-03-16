<div>
    @if($isOpen && $appointment)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto bg-gray-900/50 backdrop-blur-sm">
            <div class="relative w-full max-w-5xl p-4 mx-auto mt-10">
                <div class="relative bg-white rounded-xl shadow-2xl flex flex-col max-h-[90vh]">
                    
                    {{-- Header --}}
                    <div class="flex items-center justify-between p-5 border-b rounded-t-xl bg-gray-50">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">
                                Consulta
                            </h3>
                            <div class="mt-1">
                                <span class="text-lg font-bold text-gray-800">{{ $appointment->patient->user->name }}</span>
                                <span class="ml-2 text-sm text-gray-500">DNI: {{ $appointment->patient->cedula ?? $appointment->patient->user->id }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.patients.show', $appointment->patient_id) }}" target="_blank"
                               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-gray-200">
                                <i class="fa-solid fa-file-medical mr-1"></i> Ver Historia
                            </a>
                            <button type="button" wire:click="openHistoryModal"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-gray-200">
                                <i class="fa-solid fa-clock-rotate-left mr-1"></i> Consultas Anteriores
                            </button>
                            <button type="button" wire:click="close" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-2 inline-flex justify-center items-center">
                                <i class="fa-solid fa-times text-lg"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Body with Tabs --}}
                    <div class="p-6 overflow-y-auto">
                        <div class="border-b border-gray-200 mb-6">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                                <li class="me-4" role="presentation">
                                    <button wire:click="$set('activeTab', 'consulta')" class="inline-block px-1 py-4 border-b-2 {{ $activeTab === 'consulta' ? 'border-indigo-500 text-indigo-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300 text-gray-500' }}" type="button">
                                        <i class="fa-solid fa-list-check mr-2"></i> Consulta
                                    </button>
                                </li>
                                <li class="me-4" role="presentation">
                                    <button wire:click="$set('activeTab', 'receta')" class="inline-block px-1 py-4 border-b-2 {{ $activeTab === 'receta' ? 'border-indigo-500 text-indigo-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300 text-gray-500' }}" type="button">
                                        <i class="fa-solid fa-prescription-bottle mr-2"></i> Receta
                                    </button>
                                </li>
                            </ul>
                        </div>

                        {{-- Tab Consulta --}}
                        @if($activeTab === 'consulta')
                        <div class="space-y-6">
                            <div>
                                <label for="diagnosis" class="block mb-2 text-xs font-bold text-gray-700">Diagnóstico</label>
                                <textarea wire:model="diagnosis" id="diagnosis" rows="4" class="block p-4 w-full text-sm text-gray-900 bg-white rounded-lg border {{ $errors->has('diagnosis') ? 'border-red-500' : 'border-indigo-500' }} focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" placeholder="Describe el diagnóstico del paciente aquí..."></textarea>
                                @error('diagnosis') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="treatment" class="block mb-2 text-xs font-bold text-gray-700">Tratamiento</label>
                                <textarea wire:model="treatment" id="treatment" rows="4" class="block p-4 w-full text-sm text-gray-900 bg-white rounded-lg border {{ $errors->has('treatment') ? 'border-red-500' : 'border-gray-200' }} focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" placeholder="Describe el tratamiento recomendado aquí..."></textarea>
                                @error('treatment') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="notes" class="block mb-2 text-xs font-bold text-gray-700">Notas</label>
                                <textarea wire:model="notes" id="notes" rows="3" class="block p-4 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" placeholder="Agregue notas adicionales sobre la consulta..."></textarea>
                            </div>
                        </div>
                        @endif

                        {{-- Tab Receta --}}
                        @if($activeTab === 'receta')
                        <div class="space-y-4">
                            @foreach($medications as $index => $medication)
                            <div class="flex items-end gap-3 bg-gray-50/50 p-4 rounded-lg border border-gray-100">
                                <div class="flex-1">
                                    <label class="block mb-2 text-xs font-semibold text-gray-500">Medicamento</label>
                                    <input type="text" wire:model="medications.{{ $index }}.name" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-200 rounded-lg bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" placeholder="Amoxicilina 500mg">
                                    @error('medications.'.$index.'.name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="w-24">
                                    <label class="block mb-2 text-xs font-semibold text-gray-500">Dosis</label>
                                    <input type="text" wire:model="medications.{{ $index }}.dose" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-200 rounded-lg bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" placeholder="1 cada 8 horas">
                                </div>
                                <div class="flex-1">
                                    <label class="block mb-2 text-xs font-semibold text-gray-500">Frecuencia / Duración</label>
                                    <input type="text" wire:model="medications.{{ $index }}.frequency" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-200 rounded-lg bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" placeholder="Ej: cada 8 horas por 7 días">
                                </div>
                                <div>
                                    <button type="button" wire:click="removeMedication({{ $index }})" class="p-2.5 text-white bg-red-400 rounded-lg hover:bg-red-500 shadow-sm">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                            
                            <button type="button" wire:click="addMedication" class="px-4 py-2 mt-4 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 flex items-center gap-2">
                                <i class="fa-solid fa-plus"></i> Añadir Medicamento
                            </button>
                        </div>
                        @endif
                    </div>

                    {{-- Footer --}}
                    <div class="flex items-center justify-end p-5 border-t border-gray-100 rounded-b-xl bg-white">
                        <button type="button" wire:click="save" class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-500 rounded-lg shadow-sm hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 flex items-center gap-2">
                            <i class="fa-solid fa-lock"></i> Guardar Consulta
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endif

    {{-- History Modal --}}
    @if($isHistoryModalOpen && $appointment)
        <div class="fixed inset-0 z-[60] flex items-center justify-center overflow-x-hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm">
            <div class="relative w-full max-w-3xl p-4 mx-auto">
                <div class="relative bg-white rounded-xl shadow-2xl flex flex-col max-h-[85vh]">
                    
                    <div class="flex items-center justify-between p-4 border-b rounded-t-xl bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Consultas Anteriores - {{ $appointment->patient->user->name }}
                        </h3>
                        <button type="button" wire:click="closeHistoryModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>

                    <div class="p-6 overflow-y-auto space-y-4">
                        @forelse($pastConsultations as $past)
                            <div class="p-4 border border-gray-200 rounded-lg bg-gray-50 shadow-sm">
                                <div class="flex justify-between items-start mb-3 border-b pb-2">
                                    <div>
                                        <span class="font-bold text-gray-800">Fecha:</span> {{ \Carbon\Carbon::parse($past->date)->format('d/m/Y') }}
                                    </div>
                                    <div class="text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                        {{ $past->doctor->user->name }}
                                    </div>
                                </div>
                                <div class="text-sm text-gray-700 whitespace-pre-line">
                                    {{ $past->reason }}
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-gray-500">
                                <i class="fa-solid fa-folder-open text-3xl mb-2 text-gray-300"></i>
                                <p>No hay consultas anteriores registradas para este paciente.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="flex items-center justify-end p-4 border-t border-gray-200 rounded-b-xl bg-gray-50">
                        <button type="button" wire:click="closeHistoryModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
