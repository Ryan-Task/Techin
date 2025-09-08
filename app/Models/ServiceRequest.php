<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    public function user()
{
    // Relasi: service request milik satu user (berdasarkan email)
    return $this->belongsTo(User::class, 'email', 'email');
}

    use HasFactory;

    protected $fillable = [
        'service_id',
        'nama_pelanggan',
        'no_wa',
        'email',
        'jenis_barang',
        'nama_barang',
        'kerusakan',
    ];
}