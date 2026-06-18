<!DOCTYPE html>
<html class="light" lang="en" style="">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>FruitPulse AI - Precision Sorting Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#006e2f",
                        "surface-container-high": "#dee8ff",
                        "on-primary-container": "#004b1e",
                        "on-background": "#111c2d",
                        "tertiary-fixed": "#ffdad7",
                        "on-primary-fixed-variant": "#005321",
                        "primary-container": "#22c55e",
                        "on-primary": "#ffffff",
                        "on-surface-variant": "#3d4a3d",
                        "tertiary": "#b91a24",
                        "inverse-surface": "#263143",
                        "error": "#ba1a1a",
                        "surface": "#f9f9ff",
                        "surface-tint": "#006e2f",
                        "surface-variant": "#d8e3fb",
                        "on-secondary-fixed-variant": "#653e00",
                        "on-tertiary-fixed-variant": "#930013",
                        "on-error": "#ffffff",
                        "primary-fixed": "#6bff8f",
                        "on-secondary": "#ffffff",
                        "secondary-container": "#fea619",
                        "secondary": "#855300",
                        "inverse-on-surface": "#ecf1ff",
                        "on-primary-fixed": "#002109",
                        "outline-variant": "#bccbb9",
                        "primary-fixed-dim": "#4ae176",
                        "error-container": "#ffdad6",
                        "background": "#f9f9ff",
                        "surface-container": "#e7eeff",
                        "surface-dim": "#cfdaf2",
                        "on-secondary-fixed": "#2a1700",
                        "outline": "#6d7b6c",
                        "surface-container-highest": "#d8e3fb",
                        "tertiary-fixed-dim": "#ffb3ad",
                        "inverse-primary": "#4ae176",
                        "on-tertiary-fixed": "#410004",
                        "secondary-fixed": "#ffddb8",
                        "on-surface": "#111c2d",
                        "surface-container-low": "#f0f3ff",
                        "on-tertiary": "#ffffff",
                        "on-error-container": "#93000a",
                        "surface-bright": "#f9f9ff",
                        "secondary-fixed-dim": "#ffb95f",
                        "on-secondary-container": "#684000",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-container": "#ff8a83",
                        "on-tertiary-container": "#860011"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "card-padding": "24px",
                        "base": "8px",
                        "container-margin": "24px",
                        "stack-sm": "8px",
                        "stack-md": "16px",
                        "gutter": "16px",
                        "stack-lg": "32px"
                    },
                    "fontFamily": {
                        "display-lg": ["Inter"],
                        "body-sm": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-lg": ["Inter"],
                        "label-caps": ["Inter"],
                        "stats-number": ["Inter"],
                        "title-md": ["Inter"],
                        "headline-lg-mobile": ["Inter"]
                    },
                    "fontSize": {
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "label-caps": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "700"}],
                        "stats-number": ["36px", {"lineHeight": "44px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "title-md": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                        "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "600"}]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .scanned-box {
            border: 2px solid #22c55e;
            box-shadow: 0 0 15px rgba(34, 197, 94, 0.5);
            transition: all 0.3s ease;
        }
        .glass-effect {
            backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.7);
        }
        
        #webcam-container {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 0; 
            background-color: #1a202c; 
        }
        
        #webcam-container canvas {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        #uploaded-image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body-lg">
    <aside class="hidden md:flex h-screen w-64 flex-col fixed left-0 top-0 bg-surface-container border-r border-outline-variant p-stack-md z-50">
        <div class="mb-stack-lg">
            <h1 class="font-headline-lg text-headline-lg font-black text-on-primary-container">Fruit Grader</h1>
            <p class="font-label-caps text-label-caps text-on-surface-variant">Precision Grading</p>
        </div>
        <nav class="flex-grow space-y-base">
            <a class="flex items-center gap-4 px-4 py-3 text-on-surface-variant hover:text-primary hover:bg-surface-container-highest transition-all duration-200 cursor-pointer" onclick="switchView('dashboard')">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span class="font-label-caps text-label-caps">Dashboard</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-3 bg-primary-container text-on-primary-container rounded-lg transition-transform duration-150 active:scale-95 cursor-pointer" onclick="switchView('dashboard')">
                <span class="material-symbols-outlined" data-icon="videocam">videocam</span>
                <span class="font-label-caps text-label-caps">Live Scan</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-3 text-on-surface-variant hover:text-primary hover:bg-surface-container-highest transition-all duration-200 cursor-pointer" onclick="switchView('history')">
                <span class="material-symbols-outlined" data-icon="history">history</span>
                <span class="font-label-caps text-label-caps">History</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-3 text-on-surface-variant hover:text-primary hover:bg-surface-container-highest transition-all duration-200" href="#">
                <span class="material-symbols-outlined" data-icon="assessment">assessment</span>
                <span class="font-label-caps text-label-caps">Reports</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-3 text-on-surface-variant hover:text-primary hover:bg-surface-container-highest transition-all duration-200" href="#">
                <span class="material-symbols-outlined" data-icon="settings">settings</span>
                <span class="font-label-caps text-label-caps">Settings</span>
            </a>
        </nav>
        <div class="pt-stack-md border-t border-outline-variant mt-auto">
            <a class="flex items-center gap-4 px-4 py-3 text-on-surface-variant hover:text-primary transition-all" href="#">
                <span class="material-symbols-outlined" data-icon="help">help</span>
                <span class="font-label-caps text-label-caps">Help</span>
            </a>
        </div>
    </aside>

    <main class="md:ml-64 min-h-screen">
        <header class="bg-surface shadow-sm sticky top-0 z-40">
            <div class="flex justify-between items-center w-full px-container-margin py-base max-w-[1280px] mx-auto">
                <div class="flex items-center gap-base md:hidden">
                    <span class="material-symbols-outlined text-primary" data-icon="menu">menu</span>
                    <span class="font-headline-lg-mobile text-headline-lg-mobile font-bold text-primary">FruitPulse</span>
                </div>
                <div class="hidden md:block">
                    <h2 id="header-title" class="font-title-md text-title-md text-on-surface">System Overview</h2>
                </div>
                <div class="flex items-center gap-stack-md">
                    <button id="start-scan-btn" onclick="toggleScanner()" class="bg-primary text-white px-4 py-2 rounded-lg font-label-caps text-label-caps hover:bg-on-primary-container transition-colors shadow flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">power_settings_new</span>
                        START SYSTEM
                    </button>
                    <button class="p-2 rounded-full hover:bg-surface-container-low transition-colors">
                        <span class="material-symbols-outlined text-on-surface-variant" data-icon="settings">settings</span>
                    </button>
                </div>
            </div>
        </header>

        <div id="dashboard-section" class="max-w-[1280px] mx-auto p-container-margin space-y-stack-lg">
            <section class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                <div class="bg-surface-container-lowest p-card-padding rounded-xl shadow-[0px_4px_20px_rgba(30,41,59,0.05)] border border-surface-container">
                    <p class="font-label-caps text-label-caps text-on-surface-variant mb-base uppercase">Rata-rata Akurasi</p>
                    <div class="flex items-end justify-between">
                        <span id="avg-conf-stat" class="font-stats-number text-stats-number text-on-surface">0.0%</span>
                        <div class="w-24 h-2 bg-outline-variant rounded-full overflow-hidden mb-3">
                            <div id="avg-conf-bar" class="bg-primary h-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                <div class="bg-surface-container-lowest p-card-padding rounded-xl shadow-[0px_4px_20px_rgba(30,41,59,0.05)] border border-surface-container">
                    <p class="font-label-caps text-label-caps text-on-surface-variant mb-base uppercase">Total Dipindai</p>
                    <div class="flex items-end justify-between">
                        <span id="total-scan-stat" class="font-stats-number text-stats-number text-on-surface">0</span>
                        <span class="material-symbols-outlined text-4xl text-outline-variant mb-1">inventory_2</span>
                    </div>
                </div>

                <div class="bg-surface-container-lowest p-card-padding rounded-xl shadow-[0px_4px_20px_rgba(30,41,59,0.05)] border border-surface-container">
                    <p class="font-label-caps text-label-caps text-on-surface-variant mb-base uppercase">Kualitas Dominan</p>
                    <div class="flex items-end justify-between">
                        <span id="dominant-stat" class="font-title-md text-title-md text-primary font-bold mt-2">-</span>
                        <span class="material-symbols-outlined text-4xl text-outline-variant mb-1">monitoring</span>
                    </div>
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
                <div class="lg:col-span-8 bg-surface-container-lowest rounded-xl shadow-[0px_4px_20px_rgba(30,41,59,0.05)] overflow-hidden relative border border-surface-container aspect-video lg:aspect-auto min-h-[400px]">
                    <div id="webcam-container">
                        <div id="placeholder-feed" class="w-full h-full flex flex-col items-center justify-center text-on-surface-variant bg-surface-container-highest z-0">
                            <span class="material-symbols-outlined text-6xl mb-4">videocam_off</span>
                            <span class="font-title-md">Sensor Offline</span>
                            <span class="font-body-sm mt-2">Click "START SYSTEM" to begin scanning</span>
                        </div>
                        <img id="uploaded-image-preview" class="hidden z-0" src="" alt="Uploaded Scan">
                    </div>

                    <div class="absolute inset-0 p-stack-md flex flex-col justify-between pointer-events-none z-10">
                        <div class="flex justify-between items-start">
                            <div class="glass-effect px-4 py-2 rounded-lg border border-primary/20 flex items-center gap-2">
                                <div id="status-indicator" class="w-2 h-2 rounded-full bg-gray-400"></div>
                                <span id="status-text" class="font-label-caps text-label-caps text-gray-500">SYSTEM OFFLINE</span>
                            </div>
                            <div class="glass-effect px-4 py-2 rounded-lg border border-on-surface/10">
                                <span class="font-body-sm text-body-sm text-on-surface">Camera Utama</span>
                            </div>
                        </div>
                        
                        <div id="target-box" class="self-center w-64 h-64 border-2 border-gray-400 rounded-lg relative flex items-center justify-center transition-colors">
                            <div class="absolute -top-10 glass-effect px-4 py-2 rounded-lg border border-gray-400 transition-colors" id="overlay-border">
                                <span id="overlay-detected" class="font-title-md text-title-md text-gray-600 font-bold uppercase">WAITING...</span>
                            </div>
                            <div class="text-gray-400 opacity-20" id="center-icon">
                                <span class="material-symbols-outlined text-9xl" data-icon="qr_code_scanner">qr_code_scanner</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-end">
                            <div class="glass-effect px-4 py-2 rounded-lg border border-on-surface/10 text-center">
                                <span class="font-body-sm text-body-sm text-on-surface font-semibold">Engine:</span>
                                <span class="font-body-sm text-body-sm text-on-surface-variant ml-2">TensorFlow.js (Teachable Machine)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 bg-surface-container-lowest rounded-xl shadow-[0px_4px_20px_rgba(30,41,59,0.05)] border border-surface-container p-card-padding flex flex-col gap-stack-lg">
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Scan Result</h3>
                    
                    <div class="relative flex items-center justify-center py-4">
                        <svg class="w-48 h-48 transform -rotate-90" viewBox="0 0 100 100">
                            <circle class="text-outline-variant" cx="50" cy="50" fill="transparent" r="40" stroke="currentColor" stroke-width="8"></circle>
                            <circle id="conf-ring" class="text-gray-300 transition-all duration-200" cx="50" cy="50" fill="transparent" r="40" stroke="currentColor" stroke-dasharray="251.2" stroke-dashoffset="251.2" stroke-linecap="round" stroke-width="8"></circle>
                        </svg>
                        <div class="absolute flex flex-col items-center justify-center text-center">
                            <span id="main-conf" class="text-display-lg font-display-lg font-bold text-gray-400">0%</span>
                            <span class="text-label-caps font-label-caps text-on-surface-variant uppercase mt-1">Confidence</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-base">
                        <div class="flex justify-between items-center bg-surface-container-low px-4 py-4 rounded-lg">
                            <span class="text-body-sm font-body-sm text-on-surface-variant">Jenis Buah</span>
                            <span id="detail-type" class="text-title-md font-title-md text-on-surface font-bold">-</span>
                        </div>
                        <div class="flex justify-between items-center bg-surface-container-low px-4 py-4 rounded-lg">
                            <span class="text-body-sm font-body-sm text-on-surface-variant">Kondisi</span>
                            <span id="detail-status" class="text-title-md font-title-md text-gray-500 font-bold">Offline</span>
                        </div>
                        <div class="flex justify-between items-center bg-surface-container-low px-4 py-4 rounded-lg">
                            <span class="text-body-sm font-body-sm text-on-surface-variant">Akurasi</span>
                            <span id="detail-conf-text" class="text-title-md font-title-md text-on-surface font-bold">0.0%</span>
                        </div>
                    </div>
                    
                    <button onclick="saveScanData()" class="mt-auto w-full bg-surface-container-highest text-on-surface-variant font-title-md text-title-md py-4 px-4 rounded-lg flex items-center justify-center gap-2 cursor-not-allowed" id="log-btn">
                        <span class="material-symbols-outlined" data-icon="send">send</span>
                        <span class="font-bold">Log Scan Details</span>
                    </button>
                </div>
            </section>

            <section class="bg-surface-container-lowest rounded-xl shadow-[0px_4px_20px_rgba(30,41,59,0.05)] border border-surface-container p-card-padding flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">scan tidak optimal ?</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">foto buahnya dan upload disini untuk analisis gambar statis.</p>
                </div>
                <div class="relative">
                    <input type="file" id="image-upload" accept="image/*" class="hidden" onchange="handleImageUpload(event)">
                    <label id="upload-label" for="image-upload" class="bg-primary-container text-on-primary-container px-6 py-3 rounded-lg font-label-caps text-label-caps hover:bg-[#16a34a] transition-colors shadow flex items-center gap-2 cursor-pointer font-bold">
                        <span class="material-symbols-outlined text-[18px]">upload_file</span>
                        UPLOAD FOTO
                    </label>
                </div>
            </section>
        </div>

        <div id="history-section" style="display: none;" class="max-w-[1280px] mx-auto p-container-margin space-y-stack-lg">
            <div class="bg-surface-container-lowest rounded-xl shadow-[0px_4px_20px_rgba(30,41,59,0.05)] border border-surface-container p-card-padding">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Riwayat Klasifikasi Penuh</h3>
                    <button onclick="loadHistoryData()" class="text-primary flex items-center gap-1 hover:underline font-label-caps text-label-caps">
                        <span class="material-symbols-outlined text-[16px]">refresh</span> Refresh
                    </button>
                </div>
                
                <div class="overflow-x-auto border border-outline-variant rounded-lg">
                    <table class="w-full text-left border-collapse min-w-[600px]">
                        <thead>
                            <tr class="bg-surface-container-high text-on-surface-variant font-label-caps text-label-caps uppercase">
                                <th class="p-4 border-b border-outline-variant">Waktu Deteksi</th>
                                <th class="p-4 border-b border-outline-variant">Jenis Buah</th>
                                <th class="p-4 border-b border-outline-variant">Status Kematangan</th>
                                <th class="p-4 border-b border-outline-variant">Akurasi (Confidence)</th>
                            </tr>
                        </thead>
                        <tbody id="history-tbody">
                            <tr>
                                <td colspan="4" class="p-4 text-center text-body-sm text-on-surface-variant">Memuat data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.3.1/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@0.8/dist/teachablemachine-image.min.js"></script>
    
    <script type="text/javascript">
        const URL = "{{ asset('my_model') }}/";
        let model, webcam, maxPredictions;
        let isScanning = false;
        
        // Variabel global untuk menyimpan data sementara sebelum dikirim ke Database
        let currentScanData = null;

        // FUNGSI GANTI HALAMAN (SPA - Single Page Application Style)
        function switchView(viewName) {
            const dashboard = document.getElementById('dashboard-section');
            const history = document.getElementById('history-section');
            const headerTitle = document.getElementById('header-title');

            if (viewName === 'dashboard') {
                dashboard.style.display = 'block';
                history.style.display = 'none';
                headerTitle.innerText = "System Overview";
            } else if (viewName === 'history') {
                dashboard.style.display = 'none';
                history.style.display = 'block';
                headerTitle.innerText = "Scan History";
                loadHistoryData(); // Ambil data saat halaman history dibuka
            }
        }

        // FUNGSI LOAD DATA DARI DATABASE (Route Laravel)
        async function loadHistoryData() {
            const tbody = document.getElementById('history-tbody');
            tbody.innerHTML = '<tr><td colspan="4" class="p-4 text-center">Memuat data...</td></tr>';

            try {
                // Pastikan route '/api/history' (Metode GET) ini sudah kamu buat di web.php
                const response = await fetch('/api/history');
                if(!response.ok) throw new Error("Gagal mengambil data");
                
                const data = await response.json();
                tbody.innerHTML = ''; 
                
                if(data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="p-4 text-center text-on-surface-variant">Belum ada riwayat deteksi.</td></tr>';
                    return;
                }

                data.forEach(item => {
                    let date = new Date(item.created_at).toLocaleString('id-ID');
                    let row = `
                    <tr class="hover:bg-surface-container-highest transition-colors">
                        <td class="p-4 border-b border-outline-variant text-body-sm text-on-surface">${date}</td>
                        <td class="p-4 border-b border-outline-variant text-body-sm text-on-surface font-semibold">${item.fruit_type}</td>
                        <td class="p-4 border-b border-outline-variant text-body-sm text-on-surface">${item.ripeness_status}</td>
                        <td class="p-4 border-b border-outline-variant text-body-sm text-on-surface">${item.confidence_score}%</td>
                    </tr>`;
                    tbody.innerHTML += row;
                });
            } catch (error) {
                console.error('Error fetching history:', error);
                tbody.innerHTML = '<tr><td colspan="4" class="p-4 text-center text-error">Terjadi kesalahan. Pastikan database/tabel sudah dibuat.</td></tr>';
            }
        }

        // FUNGSI SIMPAN DATA KE DATABASE (Lewat Tombol Log Scan)
        async function saveScanData() {
            if(!currentScanData) return;

            const btn = document.getElementById("log-btn");
            const originalText = btn.innerHTML;
            btn.innerHTML = `<span class="material-symbols-outlined animate-spin" data-icon="refresh">refresh</span> Menyimpan...`;
            btn.classList.add("cursor-wait", "opacity-70");

            try {
                // Mengambil CSRF token untuk keamanan form submission Laravel
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Memanggil route '/api/history' (Metode POST) untuk menyimpan ke DB
                const response = await fetch('/api/history', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(currentScanData)
                });

                if(response.ok) {
                    alert("Data berhasil disimpan ke riwayat!");
                    // Reset tombol agar user tahu berhasil
                    btn.innerHTML = `<span class="material-symbols-outlined" data-icon="check_circle">check_circle</span> Berhasil Disimpan`;
                    setTimeout(() => { btn.innerHTML = originalText; }, 2000);
                } else {
                    throw new Error("Gagal menyimpan data");
                }
            } catch (error) {
                console.error("Gagal menyimpan:", error);
                alert("Gagal menyimpan data ke database. Cek console browser.");
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
                btn.className = "bg-primary text-white px-4 py-2 rounded-lg font-label-caps text-label-caps hover:bg-on-primary-container transition-colors shadow flex items-center gap-2";

                document.getElementById("status-indicator").classList.replace("bg-primary", "bg-gray-400");
                document.getElementById("status-indicator").classList.remove("animate-pulse");
                document.getElementById("status-text").innerText = "SYSTEM OFFLINE";
                document.getElementById("status-text").classList.replace("text-primary", "text-gray-500");

                // Reset tombol save log
                document.getElementById("log-btn").className = "mt-auto w-full bg-surface-container-highest text-on-surface-variant font-title-md text-title-md py-4 px-4 rounded-lg flex items-center justify-center gap-2 cursor-not-allowed";
                currentScanData = null;

            } else {
                btn.innerHTML = `<span class="material-symbols-outlined animate-spin text-[18px]">refresh</span> INITIALIZING...`;
                btn.classList.add("opacity-70", "cursor-wait");

                await loadModelIfNotLoaded();

                const flip = true; 
                webcam = new tmImage.Webcam(400, 400, flip); 
                await webcam.setup(); 
                await webcam.play();
                
                isScanning = true;
                window.requestAnimationFrame(loop); 

                document.getElementById("placeholder-feed").style.display = "none";
                document.getElementById("uploaded-image-preview").classList.add("hidden");
                document.getElementById("webcam-container").appendChild(webcam.canvas);
                
                btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">stop_circle</span> STOP SCANNING`;
                btn.className = "bg-error text-white px-4 py-2 rounded-lg font-label-caps text-label-caps hover:bg-[#93000a] transition-colors shadow flex items-center gap-2";

                document.getElementById("status-indicator").classList.replace("bg-gray-400", "bg-primary");
                document.getElementById("status-indicator").classList.add("animate-pulse");
                document.getElementById("status-text").innerText = "LIVE SCAN: ACTIVE";
                document.getElementById("status-text").classList.replace("text-gray-500", "text-primary");
            }
        }

        async function loop() {
            if (!isScanning) return; 
            try {
                webcam.update(); 
                const prediction = await model.predict(webcam.canvas);
                if (!isScanning) return; 
                
                processPredictionData(prediction);
                window.requestAnimationFrame(loop); 
            } catch (error) {
                console.warn("Loop interrupted.");
            }
        }

        async function handleImageUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            const uploadLabel = document.getElementById("upload-label");
            const originalHtml = uploadLabel.innerHTML;
            
            uploadLabel.innerHTML = `<span class="material-symbols-outlined animate-spin text-[18px]">refresh</span> MEMPROSES...`;
            uploadLabel.classList.add("opacity-70", "cursor-wait");

            if (isScanning) await toggleScanner(); 

            await loadModelIfNotLoaded();

            const img = new Image();
            const reader = new FileReader();

            img.onload = async function() {
                const prediction = await model.predict(img);
                if (isScanning) return;

                processPredictionData(prediction);
                
                document.getElementById("status-text").innerText = "STATIC SCAN: COMPLETE";
                document.getElementById("status-text").classList.replace("text-gray-500", "text-secondary");
                document.getElementById("status-indicator").classList.replace("bg-gray-400", "bg-secondary");

                uploadLabel.innerHTML = originalHtml;
                uploadLabel.classList.remove("opacity-70", "cursor-wait");
                event.target.value = '';
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
            
            // Mengaktifkan Tombol Simpan
            document.getElementById("log-btn").className = "mt-auto w-full bg-primary text-white font-title-md text-title-md py-4 px-4 rounded-lg flex items-center justify-center gap-2 cursor-pointer hover:bg-on-primary-fixed-variant transition-colors shadow-lg";

            const confRing = document.getElementById("conf-ring");
            const circumference = 251.2;
            const offset = circumference - (highestProb * circumference);
            confRing.style.strokeDashoffset = offset;

            const percentVal = (highestProb * 100).toFixed(1);
            document.getElementById("main-conf").innerText = Math.round(highestProb * 100) + "%";
            document.getElementById("detail-conf-text").innerText = percentVal + "%";
            document.getElementById("avg-conf-stat").innerText = percentVal + "%";
            document.getElementById("avg-conf-bar").style.width = percentVal + "%";

            const threshold = 0.6; 
            if (highestProb > threshold) {
                document.getElementById("overlay-detected").innerText = highestClassName.toUpperCase();
                
                let words = highestClassName.split(" ");
                let buahType = highestClassName;
                let kondisinya = "Terdeteksi";

                if(words.length > 1) {
                    kondisinya = words[0]; 
                    buahType = words.slice(1).join(" "); 
                    
                    document.getElementById("detail-status").innerText = kondisinya;
                    document.getElementById("detail-type").innerText = buahType;
                    
                    let statusElement = document.getElementById("detail-status");
                    if(kondisinya.toLowerCase() === "rotten") {
                        statusElement.className = "text-title-md font-title-md font-bold text-error"; 
                    } else if(kondisinya.toLowerCase() === "fresh") {
                        statusElement.className = "text-title-md font-title-md font-bold text-primary"; 
                    } else {
                        statusElement.className = "text-title-md font-title-md font-bold text-secondary"; 
                    }
                } else {
                    document.getElementById("detail-status").innerText = "Terdeteksi";
                    document.getElementById("detail-status").className = "text-title-md font-title-md font-bold text-primary";
                    document.getElementById("detail-type").innerText = highestClassName;
                }

                // SIAPKAN DATA UNTUK DISIMPAN KE DB (Global Variable)
                currentScanData = {
                    fruit_type: buahType,
                    ripeness_status: kondisinya,
                    confidence_score: percentVal
                };

            } else {
                document.getElementById("overlay-detected").innerText = "OBJEK TIDAK DIKENAL";
                document.getElementById("detail-status").innerText = "Akurasi Rendah";
                document.getElementById("detail-status").className = "text-title-md font-title-md font-bold text-error";
                document.getElementById("detail-type").innerText = "-";
                
                currentScanData = null; // Batalkan opsi simpan karena prediksi jelek
                document.getElementById("log-btn").className = "mt-auto w-full bg-surface-container-highest text-on-surface-variant font-title-md text-title-md py-4 px-4 rounded-lg flex items-center justify-center gap-2 cursor-not-allowed";
            }
        }
    </script>
</body>
</html>