@extends('layouts.app')

@section('title', 'Pindai Buah')

@section('content')
<div class="space-y-5">
    <div class="w-full bg-black rounded-2xl overflow-hidden shadow-md aspect-square border border-gray-800 relative">
        <div id="webcam-container" class="w-full h-full flex justify-center items-center object-cover">
            </div>
        <div class="absolute top-3 left-3 bg-black/60 backdrop-blur-md text-white text-[10px] px-2.5 py-1 rounded-full font-medium tracking-wide flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Kamera Aktif
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <h3 class="text-sm font-bold text-gray-900 tracking-wide mb-4 uppercase">Hasil Klasifikasi Real-time</h3>
        
        <div id="label-container" class="space-y-4">
            <div class="space-y-1">
                <div class="flex justify-between text-xs font-medium text-gray-400">
                    <span>Menunggu inisialisasi model...</span>
                    <span>0%</span>
                </div>
                <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                    <div class="bg-gray-300 h-full w-0 transition-all duration-300"></div>
                </div>
            </div>
        </div>

        <form id="save-history-form" action="{{ route('history.store') }}" method="POST" class="mt-6">
            @csrf
            <input type="hidden" name="fruit_label" id="input-fruit-label">
            <input type="hidden" name="accuracy" id="input-accuracy">
            
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3.5 rounded-xl text-sm transition shadow-sm active:scale-[0.98]">
                Simpan Hasil Pemeriksaan
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>

<script type="text/javascript">
    // Hubungkan kode inisialisasi init() Teachable Machine Anda di sini
    // Pastikan logika update UI memperbarui bar progres di dalam #label-container
</script>
@endsection