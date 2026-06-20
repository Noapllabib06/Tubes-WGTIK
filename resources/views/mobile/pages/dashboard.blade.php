@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl p-5 text-white shadow-md shadow-emerald-600/10">
        <h2 class="text-lg font-semibold opacity-90">Halo, Selamat Datang!</h2>
        <p class="text-2xl font-bold mt-1 tracking-tight">Deteksi Kematangan Buah</p>
        <p class="text-xs mt-3 opacity-75 font-light">Gunakan fitur pemindaian kamera secara real-time untuk mengetahui tingkat kematangan buah dengan instan.</p>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Pindai</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-bold text-gray-900">{{ $totalScans ?? 0 }}</span>
                <span class="text-xs text-gray-500">kali</span>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Akurasi Rata-rata</span>
            <div class="flex items-baseline gap-1 mt-2">
                <span class="text-3xl font-bold text-emerald-600">{{ $avgAccuracy ?? '0%' }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <h3 class="text-sm font-semibold text-gray-900 mb-3">Menu Cepat</h3>
        <div class="space-y-2">
            <a href="{{ url('/scan') }}" class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-emerald-50 active:bg-emerald-100 transition-colors group">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-md bg-emerald-100 text-emerald-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-emerald-900">Mulai Pemindaian Baru</span>
                </div>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
            
            <a href="{{ url('/history') }}" class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-emerald-50 active:bg-emerald-100 transition-colors group">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-md bg-amber-100 text-amber-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-emerald-900">Lihat Riwayat Data</span>
                </div>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection