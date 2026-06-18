@extends('layouts.app')

@section('title', 'System Overview')

@section('content')
<section class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
    <div class="bg-surface-container-lowest p-card-padding rounded-xl shadow-[0px_4px_20px_rgba(30,41,59,0.05)] border border-surface-container">
        <p class="text-xs font-bold tracking-widest text-on-surface-variant mb-base uppercase">Rata-rata Akurasi</p>
        <div class="flex items-end justify-between">
            <span class="text-4xl font-bold text-on-surface">{{ $avgConfidence }}%</span>
            <span class="material-symbols-outlined text-4xl text-outline-variant mb-1">donut_large</span>
        </div>
    </div>

    <div class="bg-surface-container-lowest p-card-padding rounded-xl shadow-[0px_4px_20px_rgba(30,41,59,0.05)] border border-surface-container">
        <p class="text-xs font-bold tracking-widest text-on-surface-variant mb-base uppercase">Total Dipindai</p>
        <div class="flex items-end justify-between">
            <span class="text-4xl font-bold text-on-surface">{{ number_format($totalScans) }}</span>
            <span class="material-symbols-outlined text-4xl text-outline-variant mb-1">inventory_2</span>
        </div>
    </div>

    <div class="bg-surface-container-lowest p-card-padding rounded-xl shadow-[0px_4px_20px_rgba(30,41,59,0.05)] border border-surface-container">
        <p class="text-xs font-bold tracking-widest text-on-surface-variant mb-base uppercase">Kualitas Dominan</p>
        <div class="flex items-end justify-between">
            <span class="text-xl text-primary font-bold mt-2 uppercase">{{ $dominantQuality }}</span>
            <span class="material-symbols-outlined text-4xl text-outline-variant mb-1">monitoring</span>
        </div>
    </div>
</section>

<section class="grid grid-cols-1 lg:grid-cols-2 gap-gutter mt-8">
    
    <div class="lg:col-span-2 bg-surface-container-lowest p-card-padding rounded-xl shadow border border-surface-container">
        <h3 class="text-lg font-bold text-on-surface mb-4">Aktivitas Pemindaian (7 Hari Terakhir)</h3>
        <div class="relative h-72 w-full">
            <canvas id="weeklyLogChart"></canvas>
        </div>
    </div>

    <div class="bg-surface-container-lowest p-card-padding rounded-xl shadow border border-surface-container flex flex-col items-center">
        <h3 class="text-lg font-bold text-on-surface mb-4 w-full text-left">Proporsi Class Terdeteksi</h3>
        <div class="relative h-64 w-full flex justify-center">
            <canvas id="classPieChart"></canvas>
        </div>
    </div>

    <div class="bg-surface-container-lowest p-card-padding rounded-xl shadow border border-surface-container">
        <h3 class="text-lg font-bold text-on-surface mb-4">Tingkat Keyakinan per Class</h3>
        <div class="relative h-64 w-full">
            <canvas id="confidenceBarChart"></canvas>
        </div>
    </div>

</section>
@endsection @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const weeklyLogData = @json($weeklyLogData);
    const classDistData = @json($classDistributionData);
    const confidenceData = @json($confidencePerClassData);

    const colors = ['#22c55e', '#006e2f', '#fea619', '#ba1a1a', '#855300', '#bccbb9'];

    // 1. Konfigurasi Chart Log Mingguan (Desain Bar Modern)
    const logCtx = document.getElementById('weeklyLogChart').getContext('2d');
    new Chart(logCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(weeklyLogData), 
            datasets: [{
                label: 'Total Scan',
                data: Object.values(weeklyLogData),
                backgroundColor: '#22c55e', // Hijau yang lebih cerah
                borderRadius: 8, // Membuat ujung atas batang membulat
                borderSkipped: false, // Membulatkan bagian bawah juga (opsional)
                barThickness: 24 // Menyesuaikan lebar batang agar lebih proporsional
            }]
        },
        options: {
            responsive: true, 
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#111c2d', // Warna gelap untuk tooltip
                    padding: 12,
                    cornerRadius: 8,
                }
            },
            scales: { 
                x: {
                    grid: { display: false }, // Menghilangkan garis vertikal di latar belakang
                    ticks: { color: '#6d7b6c', font: { family: 'Inter', weight: '600' } }
                },
                y: { 
                    beginAtZero: true, 
                    grid: { color: '#e7eeff', drawBorder: false }, // Garis horizontal tipis
                    ticks: { precision: 0, color: '#6d7b6c', font: { family: 'Inter' } },
                    border: { display: false } // Menghilangkan garis sumbu Y utama
                } 
            }
        }
    });

    // 2. Konfigurasi Chart Proporsi Class (Pie Chart)
    const pieCtx = document.getElementById('classPieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: Object.keys(classDistData), 
            datasets: [{
                data: Object.values(classDistData),
                backgroundColor: colors,
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right' }
            }
        }
    });

    // 3. Konfigurasi Chart Confidence per Class (Bar Chart)
    const confCtx = document.getElementById('confidenceBarChart').getContext('2d');
    new Chart(confCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(confidenceData), 
            datasets: [{
                label: 'Confidence (%)',
                data: Object.values(confidenceData).map(val => parseFloat(val).toFixed(2)), 
                backgroundColor: '#006e2f',
                borderRadius: 4,
                barThickness: 32
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    grid: { display: false }
                },
                y: { 
                    beginAtZero: true, 
                    max: 100, 
                    title: { display: true, text: 'Persentase Keyakinan (%)' },
                    grid: { color: '#e7eeff', drawBorder: false },
                    border: { display: false }
                }
            }
        }
    });
</script>
@endpush