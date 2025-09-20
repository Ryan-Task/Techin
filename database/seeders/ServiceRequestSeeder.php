<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ServiceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisBarangList = ['HP', 'Laptop', 'PC', 'Tablet', 'TV', 'Lainnya'];

        // 10 tanggal berbeda
        $dates = [];
        for ($i = 0; $i < 10; $i++) {
            $dates[] = Carbon::now()->subDays(rand(0, 30));
        }

        for ($i = 1; $i <= 30; $i++) {
            $date = $dates[array_rand($dates)];

            DB::table('service_requests')->insert([
                'service_id'      => 'SV-' . $date->format('Ymd') . '-' . strtoupper(Str::random(4)),
                'nama_pelanggan'  => 'Pelanggan ' . $i,
                'no_wa'           => '08' . rand(1000000000, 9999999999),
                'email'           => 'pelanggan' . $i . '@example.com',
                'jenis_barang'    => $jenisBarangList[array_rand($jenisBarangList)],
                'nama_barang'     => 'Barang ' . $i,
                'kerusakan'       => fake()->sentence(),
                'biaya'           => null,
                'catatan'         => null,
                'proses'          => null,
                'status'          => null,
                'created_at'      => $date,
                'updated_at'      => $date,
            ]);
        }
    }
}