@extends('layouts.app')

@section('title', 'Riwayat Pindai')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-bold text-gray-900">Riwayat Pemeriksaan</h2>
        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full font-medium">{{ count($histories ?? []) }} Data</span>
    </div>

    <div class="space-y-3">
        @forelse($histories ?? [] as $item)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex justify-between items-center active:bg-gray-50 transition-colors">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-sm text-gray-900">{{ $item->fruit_label ?? 'Tidak Diketahui' }}</span>
                        <span class="text-[10px] px-1.5 py-0.5 rounded-md font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                            {{ $item->accuracy ?? '0' }}% Akurasi
                        </span>
                    </div>
                    <p class="text-[11px] text-gray-400 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ $item->created_at ? $item->created_at->diffForHumans() : '-' }}
                    </p>
                </div>
                
                <div class="flex items-center gap-2">
                    <form action="{{ route('history.destroy', $item->id ?? 0) }}" method="POST" onsubmit="return confirm('Hapus riwayat ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-500 active:bg-red-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border border-dashed border-gray-200 p-8 text-center">
                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto text-gray-400 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.008 1.24l.885 1.77a2.25 2.25 0 0 0 2.007 1.24h1.98a2.25 2.25 0 0 0 2.007-1.24l.885-1.77a2.25 2.25 0 0 1 2.007-1.24h3.86m-18 0h18M2.25 13.5a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25h18a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25m-18 0V6.75A2.25 2.25 0 0 1 2.25 4.5h18a2.25 2.25 0 0 1 2.25 2.25v6.75m-18 0A2.25 2.25 0 0 0 2.25 13.5" />
                    </svg>
                </div>
                <p class="text-xs text-gray-500 font-medium">Belum ada riwayat hasil pemeriksaan buah.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection