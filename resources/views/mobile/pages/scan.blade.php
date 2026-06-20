@extends('layouts.app')

@section('title', 'Pindai Buah')

@section('content')
<div class="space-y-5 pb-6">
    <div class="w-full bg-black rounded-2xl overflow-hidden shadow-md aspect-square border border-gray-800 relative group">
        
        <video id="webcam-video" autoplay playsinline class="w-full h-full object-cover hidden"></video>
        
        <img id="image-preview" class="w-full h-full object-cover hidden" alt="Preview Gambar">

        <div id="loading-indicator" class="absolute inset-0 flex flex-col items-center justify-center bg-black/50 text-white z-10">
            <svg class="animate-spin h-8 w-8 mb-2 text-emerald-500" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-xs font-medium tracking-wider">Memuat Model...</span>
        </div>

        <div id="mode-badge" class="absolute top-3 left-3 bg-black/60 backdrop-blur-md text-white text-[10px] px-2.5 py-1 rounded-full font-medium tracking-wide flex items-center gap-1.5 z-20">
            <span id="mode-dot" class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span id="mode-text">Kamera Aktif</span>
        </div>

        <div id="torch-container" class="absolute top-3 right-3 z-20 hidden items-center gap-2 bg-black/60 backdrop-blur-md px-3 py-1.5 rounded-full shadow-lg border border-white/20 transition-all">
    
            <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.82 1.508-2.316a7.5 7.5 0 10-7.516 0c.85.496 1.508 1.333 1.508 2.316V18"></path>
            </svg>
            
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="torch-toggle" class="sr-only peer">
                <div class="w-9 h-5 bg-gray-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
            </label>

        </div>

        <div class="absolute bottom-3 right-3 flex gap-2 z-20">
            <button type="button" id="btn-upload" class="bg-black/60 backdrop-blur-md p-2.5 rounded-full text-white shadow-lg border border-white/20 active:scale-95 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
                </svg>
            </button>
            <input type="file" id="file-input" class="hidden" accept="image/*">

            <button type="button" id="btn-flip" class="bg-emerald-600/90 backdrop-blur-md p-2.5 rounded-full text-white shadow-lg border border-white/20 active:scale-95 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <h3 class="text-sm font-bold text-gray-900 tracking-wide mb-4 uppercase">Hasil Klasifikasi</h3>
        
        <div id="label-container" class="space-y-3">
            <div class="text-sm text-center text-gray-400 py-2">Menunggu deteksi...</div>
        </div>

        <form id="save-history-form" action="{{ route('history.store') }}" method="POST" class="mt-6">
            @csrf
            <input type="hidden" name="fruit_type" id="input-fruit-type">
            <input type="hidden" name="ripeness_status" id="input-ripeness-status">
            <input type="hidden" name="confidence_score" id="input-confidence-score">
            
            <button type="submit" id="btn-save" disabled class="w-full bg-gray-300 text-gray-500 font-semibold py-3.5 rounded-xl text-sm transition shadow-sm cursor-not-allowed">
                Simpan Hasil Pemeriksaan
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>

<script type="text/javascript">
    const URL = "{{ asset('my_model/') }}/";
    
    let activeVideoTrack = null; 

    let model, maxPredictions;
    let isWebcamActive = false;
    let currentFacingMode = "environment";

    const videoElement = document.getElementById('webcam-video');
    const imagePreview = document.getElementById('image-preview');
    const loadingIndicator = document.getElementById('loading-indicator');
    const labelContainer = document.getElementById('label-container');
    const modeText = document.getElementById('mode-text');
    const modeDot = document.getElementById('mode-dot');
    const btnSave = document.getElementById('btn-save');
    
    // Elemen Senter
    const torchContainer = document.getElementById('torch-container');
    const torchToggle = document.getElementById('torch-toggle');

    async function init() {
        try {
            const modelURL = URL + "model.json";
            const metadataURL = URL + "metadata.json";
            
            model = await tmImage.load(modelURL, metadataURL);
            maxPredictions = model.getTotalClasses();
            
            loadingIndicator.style.display = "none";
            startCamera(); 
        } catch (error) {
            console.error("Gagal memuat model:", error);
            labelContainer.innerHTML = '<div class="text-red-500 text-sm text-center">Gagal memuat model AI.</div>';
        }
    }

    async function startCamera() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            try {
                if (videoElement.srcObject) {
                    videoElement.srcObject.getTracks().forEach(track => track.stop());
                }

                const stream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: currentFacingMode }
                });
                
                videoElement.srcObject = stream;
                videoElement.style.display = "block";
                imagePreview.style.display = "none";
                isWebcamActive = true;
                
                // Ambil Track Video untuk mengecek fitur senter
                activeVideoTrack = stream.getVideoTracks()[0];
                
                const capabilities = activeVideoTrack.getCapabilities ? activeVideoTrack.getCapabilities() : {};

                if (capabilities.torch) {
                    torchContainer.classList.remove("hidden");
                    torchContainer.classList.add("flex"); // Tampilkan tombol senter
                    torchToggle.checked = false; // Reset posisi slider ke Off
                } else {
                    torchContainer.classList.remove("flex");
                    torchContainer.classList.add("hidden"); // Sembunyikan jika tidak mendukung
                }

                modeText.innerText = "Kamera " + (currentFacingMode === "environment" ? "Belakang" : "Depan");
                modeDot.classList.add("animate-pulse", "bg-emerald-500");
                modeDot.classList.remove("bg-blue-500", "animate-none");

                videoElement.addEventListener('loadeddata', predictLoop);
            } catch (err) {
                console.error("Kamera tidak dapat diakses:", err);
                modeText.innerText = "Kamera Error";
                modeDot.classList.replace("bg-emerald-500", "bg-red-500");
                torchContainer.style.display = "none";
            }
        }
    }

    async function predictLoop() {
        if (isWebcamActive && videoElement.readyState === 4) {
            await predict(videoElement);
            requestAnimationFrame(predictLoop); 
        }
    }

    async function predict(sourceElement) {
        if (!model) return;

        const prediction = await model.predict(sourceElement);
        prediction.sort((a, b) => b.probability - a.probability);
        const bestResult = prediction[0];
        const confScore = (bestResult.probability * 100).toFixed(1);

        document.getElementById('input-fruit-type').value = bestResult.className; 
        document.getElementById('input-ripeness-status').value = bestResult.className; 
        document.getElementById('input-confidence-score').value = confScore;

        btnSave.disabled = false;
        btnSave.classList.remove("bg-gray-300", "text-gray-500", "cursor-not-allowed");
        btnSave.classList.add("bg-emerald-600", "hover:bg-emerald-700", "text-white", "active:scale-[0.98]");

        labelContainer.innerHTML = `
            <div class="flex justify-between items-center bg-gray-50 p-4 rounded-xl border border-gray-200 shadow-sm">
                <span class="font-bold text-gray-800 text-lg">${bestResult.className}</span>
                <span class="text-emerald-700 font-bold bg-emerald-100 px-3 py-1.5 rounded-lg text-sm border border-emerald-200 shadow-sm">
                    ${confScore}%
                </span>
            </div>
        `;
    }

    // --- EVENT LISTENER SENTER (TORCH) ---
    torchToggle.addEventListener('change', async (e) => {
        if (activeVideoTrack) {
            try {
                // Terapkan instruksi senter menyala/mati
                await activeVideoTrack.applyConstraints({
                    advanced: [{ torch: e.target.checked }]
                });
            } catch (err) {
                console.error('Gagal mengontrol senter:', err);
                alert('Senter gagal diaktifkan. Pastikan Anda mengakses web menggunakan HTTPS.');
                e.target.checked = !e.target.checked; // Kembalikan posisi slider jika gagal
            }
        }
    });

    document.getElementById('btn-flip').addEventListener('click', () => {
        currentFacingMode = currentFacingMode === "environment" ? "user" : "environment";
        startCamera(); 
    });

    document.getElementById('btn-upload').addEventListener('click', () => {
        document.getElementById('file-input').click(); 
    });

    document.getElementById('file-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                isWebcamActive = false;
                if (videoElement.srcObject) {
                    videoElement.srcObject.getTracks().forEach(track => track.stop());
                }
                videoElement.style.display = "none";
                torchContainer.style.display = "none"; // Sembunyikan tombol senter
                
                imagePreview.src = event.target.result;
                imagePreview.style.display = "block";
                
                modeText.innerText = "Mode Gambar";
                modeDot.classList.remove("animate-pulse", "bg-emerald-500");
                modeDot.classList.add("bg-blue-500");

                imagePreview.onload = async function() {
                    await predict(imagePreview);
                }
            }
            reader.readAsDataURL(file);
        }
    });

    document.addEventListener('DOMContentLoaded', init);
</script>
@endsection