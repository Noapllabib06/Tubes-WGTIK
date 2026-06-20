@extends('layouts.app')

@section('title', 'Scan History')

@section('content')
<div class="bg-surface-container-lowest rounded-xl shadow-[0px_4px_20px_rgba(30,41,59,0.05)] border border-surface-container p-card-padding">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl text-on-surface font-bold">Riwayat Klasifikasi Penuh</h3>
        
        <div class="flex items-center gap-6">
            <button onclick="resetHistory()" class="text-error flex items-center gap-1 hover:underline text-xs font-bold tracking-widest uppercase transition-all hover:opacity-70">
                <span class="material-symbols-outlined text-[18px]">delete_sweep</span> Reset History
            </button>
            
            <a href="{{ route('history') }}" class="text-primary flex items-center gap-1 hover:underline text-xs font-bold tracking-widest uppercase transition-all hover:opacity-70">
                <span class="material-symbols-outlined text-[18px]">refresh</span> Refresh
            </a>
        </div>
    </div>
    
    <div class="overflow-x-auto border border-outline-variant rounded-lg">
        <table class="w-full text-left border-collapse min-w-[600px]">
            <thead>
                <tr class="bg-surface-container-high text-on-surface-variant text-xs font-bold uppercase tracking-widest">
                    <th class="p-4 border-b border-outline-variant">Waktu Deteksi</th>
                    <th class="p-4 border-b border-outline-variant">Jenis Buah</th>
                    <th class="p-4 border-b border-outline-variant">Status Kematangan</th>
                    <th class="p-4 border-b border-outline-variant">Akurasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($histories as $history)
                <tr class="hover:bg-surface-container-highest transition-colors">
                    <td class="p-4 border-b border-outline-variant text-sm text-on-surface">{{ $history->created_at->format('d M Y, H:i') }}</td>
                    <td class="p-4 border-b border-outline-variant text-sm text-on-surface font-semibold">{{ $history->fruit_type }}</td>
                    <td class="p-4 border-b border-outline-variant text-sm text-on-surface">{{ $history->ripeness_status }}</td>
                    <td class="p-4 border-b border-outline-variant text-sm text-on-surface">{{ $history->confidence_score }}%</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-sm text-on-surface-variant py-8">Belum ada riwayat deteksi yang tersimpan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    async function resetHistory() {
        // Memunculkan Pop-up konfirmasi standar browser
        const isConfirmed = confirm("Apakah Anda yakin ingin menghapus SEMUA riwayat deteksi?\nData yang dihapus tidak dapat dikembalikan.");
        
        if (!isConfirmed) {
            return; // Batalkan proses jika user menekan 'Cancel'
        }

        try {
            // Ambil token keamanan Laravel dari tag <meta> di header
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Panggil API reset yang baru saja dibuat di web.php
            const response = await fetch('/api/history/reset', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (response.ok) {
                // Muat ulang (refresh) halaman secara otomatis setelah sukses
                window.location.reload(); 
            } else {
                throw new Error("Gagal mereset database");
            }
        } catch (error) {
            console.error("Kesalahan Reset:", error);
            alert("Terjadi kesalahan sistem saat mencoba menghapus riwayat.");
        }
    }
</script>
@endpush