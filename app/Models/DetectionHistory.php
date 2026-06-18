<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetectionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fruit_type',
        'ripeness_status',
        'confidence_score',
        'image_path'
    ];

    // Relasi ke tabel User (jika kamu menggunakan sistem login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}