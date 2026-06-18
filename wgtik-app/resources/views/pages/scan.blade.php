@extends('layouts.app')

@section('title', 'Live Camera Scan')

@push('styles')
<style>
    .scanned-box { border: 2px solid #22c55e; box-shadow: 0 0 15px rgba(34, 197, 94, 0.5); transition: all 0.3s ease; }
    .glass-effect { backdrop-filter: blur(8px); background: rgba(255, 255, 255, 0.7); }
    #webcam-container { position: absolute; inset: 0; width: 100%; height: 100%; z-index: 0; background-color: #1a202c; }
    #webcam-container canvas { width: 100% !important; height: 100% !important; object-fit: cover; position: absolute; top: 0; left: 0; }
    #uploaded-image-preview { width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; }
</style>
@endpush

@section('header-actions')
<button id="start-scan-btn" onclick="toggleScanner()" class="bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold tracking-widest hover:bg-on-primary-container transition-colors shadow flex items-center gap-2">
    <span class="material-symbols-outlined text-[18px]">power_settings_new</span>
    START SYSTEM
</button>
@endsection

@section('content')
<section class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
    <div class="lg:col-span-8 bg-surface-container-lowest rounded-xl shadow-[0px_4px_20px_rgba(30,41,59,0.05)] overflow-hidden relative border border-surface-container aspect-video lg:aspect-auto min-h-[400px]">
        <div id="webcam-container">
            <div id="placeholder-feed" class="w-full h-full flex flex-col items-center justify-center text-on-surface-variant bg-surface-container-highest z-0">
                <span class="material-symbols-outlined text-6xl mb-4">videocam_off</span>
                <span class="text-xl font-bold">Sensor Offline</span>
                <span class="text-sm mt-2">Click "START SYSTEM" at the top right to begin scanning</span>
            </div>
            <img id="uploaded-image-preview" class="hidden z-0" src="" alt="Uploaded Scan">
        </div>

        <div class="absolute inset-0 p-stack-md flex flex-col justify-between pointer-events-none z-10">
            <div class="flex justify-between items-start">
                <div class="glass-effect px-4 py-2 rounded-lg border border-primary/20 flex items-center gap-2">
                    <div id="status-indicator" class="w-2 h-2 rounded-full bg-gray-400"></div>
                    <span id="status-text" class="text-xs font-bold tracking-widest text-gray-500">SYSTEM OFFLINE</span>
                </div>
            </div>
            
            <div id="target-box" class="self-center w-64 h-64 border-2 border-gray-400 rounded-lg relative flex items-center justify-center transition-colors">
                <div class="absolute -top-10 glass-effect px-4 py-2 rounded-lg border border-gray-400 transition-colors" id="overlay-border">
                    <span id="overlay-detected" class="text-xl text-gray-600 font-bold uppercase">WAITING...</span>
                </div>
                <div class="text-gray-400 opacity-20" id="center-icon">
                    <span class="material-symbols-outlined text-9xl">qr_code_scanner</span>
                </div>
            </div>
            <div></div>
        </div>
    </div>

    <div class="lg:col-span-4 bg-surface-container-lowest rounded-xl shadow-[0px_4px_20px_rgba(30,41,59,0.05)] border border-surface-container p-card-padding flex flex-col gap-stack-lg">
        <h3 class="text-xl text-on-surface font-bold">Scan Result</h3>
        
        <div class="relative flex items-center justify-center py-4">
            <svg class="w-48 h-48 transform -rotate-90" viewBox="0 0 100 100">
                <circle class="text-outline-variant" cx="50" cy="50" fill="transparent" r="40" stroke="currentColor" stroke-width="8"></circle>
                <circle id="conf-ring" class="text-gray-300 transition-all duration-200" cx="50" cy="50" fill="transparent" r="40" stroke="currentColor" stroke-dasharray="251.2" stroke-dashoffset="251.2" stroke-linecap="round" stroke-width="8"></circle>
            </svg>
            <div class="absolute flex flex-col items-center justify-center text-center">
                <span id="main-conf" class="text-5xl font-bold text-gray-400">0%</span>
                <span class="text-xs font-bold tracking-widest text-on-surface-variant uppercase mt-1">Confidence</span>
            </div>
        </div>
        
        <div class="flex flex-col gap-base">
            <div class="flex justify-between items-center bg-surface-container-low px-4 py-4 rounded-lg">
                <span class="text-sm text-on-surface-variant">Jenis Buah</span>
                <span id="detail-type" class="text-xl text-on-surface font-bold">-</span>
            </div>
            <div class="flex justify-between items-center bg-surface-container-low px-4 py-4 rounded-lg">
                <span class="text-sm text-on-surface-variant">Kondisi</span>
                <span id="detail-status" class="text-xl text-gray-500 font-bold">Offline</span>
            </div>
        </div>
        
        <button onclick="saveScanData()" class="mt-auto w-full bg-surface-container-highest text-on-surface-variant text-lg py-4 px-4 rounded-lg flex items-center justify-center gap-2 cursor-not-allowed" id="log-btn">
            <span class="material-symbols-outlined">send</span>
            <span class="font-bold">Log Scan Details</span>
        </button>
    </div>
</section>

<section class="bg-surface-container-lowest rounded-xl shadow-[0px_4px_20px_rgba(30,41,59,0.05)] border border-surface-container p-card-padding flex flex-col sm:flex-row items-center justify-between gap-4">
    <div>
        <h3 class="text-xl text-on-surface font-bold">Scan tidak optimal?</h3>
        <p class="text-sm text-on-surface-variant">Foto buahnya dan upload di sini untuk analisis gambar statis.</p>
    </div>
    <div class="relative">
        <input type="file" id="image-upload" accept="image/*" class="hidden" onchange="handleImageUpload(event)">
        <label id="upload-label" for="image-upload" class="bg-primary-container text-on-primary-container px-6 py-3 rounded-lg text-xs font-bold tracking-widest hover:bg-[#16a34a] transition-colors shadow flex items-center gap-2 cursor-pointer">
            <span class="material-symbols-outlined text-[18px]">upload_file</span>
            UPLOAD FOTO
        </label>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.3.1/dist/tf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@0.8/dist/teachablemachine-image.min.js"></script>
<script type="text/javascript">
    const URL = "{{ asset('my_model') }}/";
    let model, webcam, maxPredictions;
    let isScanning = false;
    let currentScanData = null;

    async function saveScanData() {
        if(!currentScanData) return;
        const btn = document.getElementById("log-btn");
        const originalText = btn.innerHTML;
        btn.innerHTML = `<span class="material-symbols-outlined animate-spin">refresh</span> Menyimpan...`;
        btn.classList.add("cursor-wait", "opacity-70");

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch('/api/history', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify(currentScanData)
            });

            if(response.ok) {
                alert("Data berhasil disimpan ke riwayat!");
                btn.innerHTML = `<span class="material-symbols-outlined">check_circle</span> Berhasil Disimpan`;
                setTimeout(() => { btn.innerHTML = originalText; }, 2000);
            } else { throw new Error("Gagal"); }
        } catch (error) {
            console.error("Gagal:", error);
            btn.innerHTML = originalText;
        } finally {
            btn.classList.remove("cursor-wait", "opacity-70");
        }
    }

    async function loadModelIfNotLoaded() {
        if (!model) {
            const modelURL = URL + "model.json";
            const metadataURL = URL + "metadata.json";
            model = await tmImage.load(modelURL, metadataURL);
            maxPredictions = model.getTotalClasses();
        }
    }

    async function toggleScanner() {
        const btn = document.getElementById("start-scan-btn");

        if (isScanning) {
            isScanning = false; 
            if (webcam) webcam.stop();
            const container = document.getElementById("webcam-container");
            const canvas = container.querySelector("canvas");
            if (canvas) container.removeChild(canvas);

            document.getElementById("placeholder-feed").style.display = "flex";
            document.getElementById("uploaded-image-preview").classList.add("hidden");

            btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">power_settings_new</span> START SYSTEM`;
            btn.className = "bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold tracking-widest hover:bg-on-primary-container transition-colors shadow flex items-center gap-2";

            document.getElementById("status-indicator").classList.replace("bg-primary", "bg-gray-400");
            document.getElementById("status-text").innerText = "SYSTEM OFFLINE";
            document.getElementById("status-text").classList.replace("text-primary", "text-gray-500");
            document.getElementById("log-btn").className = "mt-auto w-full bg-surface-container-highest text-on-surface-variant text-lg py-4 px-4 rounded-lg flex items-center justify-center gap-2 cursor-not-allowed";
            currentScanData = null;
        } else {
            btn.innerHTML = `<span class="material-symbols-outlined animate-spin text-[18px]">refresh</span> INITIALIZING...`;
            btn.classList.add("opacity-70", "cursor-wait");

            await loadModelIfNotLoaded();
            webcam = new tmImage.Webcam(400, 400, true); 
            await webcam.setup(); 
            await webcam.play();
            
            isScanning = true;
            window.requestAnimationFrame(loop); 

            document.getElementById("placeholder-feed").style.display = "none";
            document.getElementById("uploaded-image-preview").classList.add("hidden");
            document.getElementById("webcam-container").appendChild(webcam.canvas);
            
            btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">stop_circle</span> STOP SCANNING`;
            btn.className = "bg-error text-white px-4 py-2 rounded-lg text-xs font-bold tracking-widest hover:bg-[#93000a] transition-colors shadow flex items-center gap-2";

            document.getElementById("status-indicator").classList.replace("bg-gray-400", "bg-primary");
            document.getElementById("status-text").innerText = "LIVE SCAN: ACTIVE";
            document.getElementById("status-text").classList.replace("text-gray-500", "text-primary");
        }
    }

    async function loop() {
        if (!isScanning) return; 
        webcam.update(); 
        const prediction = await model.predict(webcam.canvas);
        if (isScanning) {
            processPredictionData(prediction);
            window.requestAnimationFrame(loop); 
        }
    }

    async function handleImageUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        const uploadLabel = document.getElementById("upload-label");
        const originalHtml = uploadLabel.innerHTML;
        uploadLabel.innerHTML = `<span class="material-symbols-outlined animate-spin text-[18px]">refresh</span> MEMPROSES...`;
        
        if (isScanning) await toggleScanner(); 
        await loadModelIfNotLoaded();

        const img = new Image();
        const reader = new FileReader();

        img.onload = async function() {
            const prediction = await model.predict(img);
            processPredictionData(prediction);
            document.getElementById("status-text").innerText = "STATIC SCAN: COMPLETE";
            document.getElementById("status-text").classList.replace("text-gray-500", "text-secondary");
            document.getElementById("status-indicator").classList.replace("bg-gray-400", "bg-secondary");
            uploadLabel.innerHTML = originalHtml;
        }

        reader.onload = function(e) {
            img.src = e.target.result;
            const previewImg = document.getElementById("uploaded-image-preview");
            previewImg.src = e.target.result;
            previewImg.classList.remove("hidden");
            document.getElementById("placeholder-feed").style.display = "none";
        }
        reader.readAsDataURL(file);
    }

    function processPredictionData(prediction) {
        let highestProb = -1;
        let highestClassName = "";

        for (let i = 0; i < maxPredictions; i++) {
            if (prediction[i].probability > highestProb) {
                highestProb = prediction[i].probability;
                highestClassName = prediction[i].className;
            }
        }

        document.getElementById("target-box").classList.add("scanned-box");
        document.getElementById("target-box").classList.replace("border-gray-400", "border-primary");
        document.getElementById("overlay-border").classList.replace("border-gray-400", "border-primary");
        document.getElementById("overlay-detected").classList.replace("text-gray-600", "text-on-primary-container");
        document.getElementById("center-icon").classList.replace("text-gray-400", "text-primary");
        document.getElementById("conf-ring").classList.replace("text-gray-300", "text-primary");
        document.getElementById("main-conf").classList.replace("text-gray-400", "text-primary");
        
        document.getElementById("log-btn").className = "mt-auto w-full bg-primary text-white text-lg py-4 px-4 rounded-lg flex items-center justify-center gap-2 cursor-pointer hover:bg-on-primary-fixed-variant transition-colors shadow-lg";

        const offset = 251.2 - (highestProb * 251.2);
        document.getElementById("conf-ring").style.strokeDashoffset = offset;

        const percentVal = (highestProb * 100).toFixed(1);
        document.getElementById("main-conf").innerText = Math.round(highestProb * 100) + "%";

        if (highestProb > 0.6) {
            document.getElementById("overlay-detected").innerText = highestClassName.toUpperCase();
            let words = highestClassName.split(" ");
            let kondisinya = words.length > 1 ? words[0] : "Terdeteksi";
            let buahType = words.length > 1 ? words.slice(1).join(" ") : highestClassName;

            document.getElementById("detail-status").innerText = kondisinya;
            document.getElementById("detail-type").innerText = buahType;
            
            if(kondisinya.toLowerCase() === "rotten") {
                document.getElementById("detail-status").className = "text-xl font-bold text-error"; 
            } else if(kondisinya.toLowerCase() === "fresh") {
                document.getElementById("detail-status").className = "text-xl font-bold text-primary"; 
            } else {
                document.getElementById("detail-status").className = "text-xl font-bold text-secondary"; 
            }

            currentScanData = { fruit_type: buahType, ripeness_status: kondisinya, confidence_score: percentVal };
        } else {
            document.getElementById("overlay-detected").innerText = "TIDAK DIKENAL";
            document.getElementById("detail-status").innerText = "Akurasi Rendah";
            document.getElementById("detail-status").className = "text-xl font-bold text-error";
            document.getElementById("detail-type").innerText = "-";
            currentScanData = null;
            document.getElementById("log-btn").className = "mt-auto w-full bg-surface-container-highest text-on-surface-variant text-lg py-4 px-4 rounded-lg flex items-center justify-center gap-2 cursor-not-allowed";
        }
    }
</script>
@endpush