@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="space-y-6 pb-6">
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl p-5 text-white shadow-md shadow-emerald-600/10">
        <h2 class="text-lg font-semibold opacity-90">Halo, Selamat Datang!</h2>
        <p class="text-2xl font-bold mt-1 tracking-tight">Deteksi Kematangan Buah</p>
        <p class="text-xs mt-3 opacity-75 font-light">Pantau hasil pemindaian dan statistik deteksi kematangan buah Anda secara real-time.</p>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Pindai</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-bold text-gray-900">{{ $totalScans ?? 0 }}</span>
                <span class="text-xs text-gray-500 font-medium">kali</span>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Rata-rata Akurasi</span>
            <div class="flex items-baseline gap-1 mt-2">
                <span class="text-3xl font-bold text-emerald-600">{{ $avgConfidence ?? '0' }}%</span>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-sm font-bold text-gray-800 mb-4">Aktivitas Pemindaian (7 Hari)</h3>
        <div class="relative w-full h-48">
            <canvas id="weeklyChart"></canvas>
        </div>
    </div>

    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-sm font-bold text-gray-800 mb-4">Distribusi Jenis Buah</h3>
        <div class="relative w-full h-48 flex justify-center">
            <canvas id="fruitDistributionChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <h3 class="text-sm font-bold text-gray-800 mb-3">Menu Cepat</h3>
        <div class="space-y-2">
            <a href="{{ url('/scan') }}" class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-emerald-50 active:bg-emerald-100 transition-colors group">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-md bg-emerald-100 text-emerald-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Mulai Pemindaian Baru</span>
                </div>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Persiapan Data dari Backend Laravel
    // Data Grafik Mingguan
    const weeklyDataRaw = @json($weeklyLogData ?? []);
    const weeklyLabels = Object.keys(weeklyDataRaw);
    const weeklyValues = Object.values(weeklyDataRaw);

    // Data Grafik Distribusi Buah
    const fruitDataRaw = @json($classDistributionData ?? []);
    const fruitLabels = Object.keys(fruitDataRaw);
    const fruitValues = Object.values(fruitDataRaw);

    // 2. Render Grafik Aktivitas Mingguan (Line Chart)
    const ctxWeekly = document.getElementById('weeklyChart').getContext('2d');
    new Chart(ctxWeekly, {
        type: 'line',
        data: {
            labels: weeklyLabels.length > 0 ? weeklyLabels : ['Tidak ada data'],
            datasets: [{
                label: 'Jumlah Pindai',
                data: weeklyValues.length > 0 ? weeklyValues : [0],
                borderColor: '#059669', // Emerald 600
                backgroundColor: 'rgba(5, 150, 105, 0.1)',
                borderWidth: 2,
                pointBackgroundColor: '#059669',
                pointRadius: 3,
                fill: true,
                tension: 0.3 // Membuat garis agak melengkung (smooth)
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false } // Sembunyikan legend agar tidak makan tempat di layar HP
            },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } },
                x: { grid: { display: false } } // Sembunyikan garis grid vertikal biar bersih
            }
        }
    });

    // 3. Render Grafik Distribusi Buah (Doughnut Chart)
    const ctxFruit = document.getElementById('fruitDistributionChart').getContext('2d');
    new Chart(ctxFruit, {
        type: 'doughnut',
        data: {
            labels: fruitLabels.length > 0 ? fruitLabels : ['Belum ada data'],
            datasets: [{
                data: fruitValues.length > 0 ? fruitValues : [1],
                backgroundColor: [
                    '#059669', // Emerald
                    '#d97706', // Amber
                    '#dc2626', // Red
                    '#2563eb', // Blue
                    '#9333ea'  // Purple
                ],
                borderWidth: 2,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom', // Letakkan keterangan di bawah grafik agar muat di HP
                    labels: { boxWidth: 12, font: { size: 10 } }
                }
            },
            cutout: '65%' // Membuat lubang tengah doughnut lebih besar
        }
    });
});
</script>
@endsection