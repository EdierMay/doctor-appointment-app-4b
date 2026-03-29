<div wire:poll.2s>
    @if($histories->count() > 0)
    <div class="mb-8 bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
        <div class="p-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">
                <i class="fa-solid fa-list-check mr-2"></i> Historial de Importaciones Recientes
            </h3>
        </div>
        
        <ul class="divide-y divide-gray-200">
            @foreach($histories as $history)
                @php
                    $percentage = $history->total_rows > 0 
                        ? round(($history->processed_rows / $history->total_rows) * 100) 
                        : ($history->status === 'Completado' ? 100 : 0);
                        
                    if($percentage > 100) $percentage = 100;

                    $statusColors = [
                        'Pendiente' => 'bg-gray-100 text-gray-800',
                        'Procesando' => 'bg-blue-100 text-blue-800',
                        'Completado' => 'bg-green-100 text-green-800',
                        'Fallido' => 'bg-red-100 text-red-800',
                    ];
                    
                    $barColors = [
                        'Pendiente' => 'bg-gray-300',
                        'Procesando' => 'bg-blue-600',
                        'Completado' => 'bg-green-500',
                        'Fallido' => 'bg-red-500',
                    ];
                @endphp
                <li class="p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-900 truncate" style="max-width: 300px;">
                                <i class="fa-solid fa-file-csv mr-1 text-gray-400"></i> {{ $history->file_name }}
                            </span>
                            <span class="text-xs text-gray-500 mt-1">{{ $history->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm font-semibold text-gray-700">
                                {{ $history->processed_rows }} / {{ $history->total_rows }} filas
                            </span>
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$history->status] ?? 'bg-gray-100 text-gray-800' }}">
                                @if($history->status === 'Procesando')
                                    <i class="fa-solid fa-circle-notch fa-spin mr-1"></i>
                                @endif
                                {{ $history->status }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-200 mt-2">
                        <div class="{{ $barColors[$history->status] ?? 'bg-gray-400' }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
