<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detection_histories', function (Blueprint $table) {
            $table->id();
            // Opsional: Jika aplikasi menggunakan sistem login pengguna
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); 
            
            // Menyimpan jenis buah (misal: Pisang, Apel, Jeruk)
            $table->string('fruit_type'); 
            
            // Menyimpan status kematangan (misal: Matang, Mentah)
            $table->string('ripeness_status'); 
            
            // Menyimpan persentase keyakinan model Teachable Machine (misal: 98.50)
            $table->decimal('confidence_score', 5, 2); 
            
            // Opsional: Menyimpan path gambar jika kamu mengizinkan user mengupload/menyimpan foto bukti deteksi
            $table->string('image_path')->nullable(); 
            
            $table->timestamps(); // Otomatis membuat kolom created_at (waktu deteksi) dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detection_histories');
    }
};