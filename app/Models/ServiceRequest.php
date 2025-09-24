<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
    'service_id',
    'nama_pelanggan',
    'no_wa',
    'email',
    'jenis_barang',
    'nama_barang',
    'kerusakan',
    'proses',
    'status',
    'catatan',
    'handled_by',
    'rating',
    'ulasan',
];


    // Relasi ke detail biaya
    public function detail()
    {
        return $this->hasOne(ServiceDetail::class, 'service_id', 'service_id');
    }

    // Relasi ke teknisi/user_id (jika ada kolom user_id)
    public function teknisi()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi: service request milik satu user (berdasarkan email)
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    // Relasi: siapa yang menangani (menerima/menolak)
    public function handledBy()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}