<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    use HasFactory;

    protected $table = 'service_details';

    protected $fillable = [
    'service_id',
    'nama_sparepart',
    'harga_sparepart',
    'harga_jasa',
    'total_biaya',
    ];

    // Relasi ke ServiceRequest
    public function service()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_id', 'service_id');
    }
}