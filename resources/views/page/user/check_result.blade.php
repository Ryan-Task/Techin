<!DOCTYPE html>
<html lang="id" x-data="{
    ratingModal: false,
    selectedRating: 0,
    hasRated: {{ $service->rating ? 'true' : 'false' }},
    userRating: {{ $service->rating ?? 0 }},
    userReview: '{{ $service->ulasan ?? '' }}'
}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hasil Cek Servis - {{ $service->service_id }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-in {
            animation: slideIn 0.4s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .star-rating label {
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .star-rating label:hover {
            transform: scale(1.2);
        }

        .timeline-dot {
            position: absolute;
            left: -6px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 0 0 2px #e5e7eb;
        }

        .timeline-dot.active {
            box-shadow: 0 0 0 2px #10b981;
        }

        .timeline-dot.completed {
            box-shadow: 0 0 0 2px #10b981;
            background: #10b981;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans min-h-screen lg:mr-20">
    @include('komponen.sidebar')

    <div class="lg:ml-30 p-6">
        <div class="max-w-6xl mx-auto space-y-6 fade-in">

            <!-- Status Header -->
            <div x-data="{ status: '{{ $service->status }}' }" class="slide-in">
                <template x-if="status === 'ditolak'">
                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
                        <div class="flex items-center gap-4">
                            <div class="p-3 rounded-full bg-red-100 text-red-500">
                                <i class="fas fa-times-circle text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-red-600">Servis Ditolak</h2>
                                <p class="text-gray-600 mt-1">
                                    Catatan: <span class="font-medium">{{ $service->catatan ?? '-' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="status !== 'ditolak'">
                    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                        <div class="flex items-center gap-4">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                                <i class="fas fa-tools text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-gray-800 capitalize">
                                    {{ $service->proses ?? 'Menunggu Proses' }}</h2>
                                @php
                                    $descriptions = [
                                        'barang diterima' =>
                                            'Nantikan informasi selanjutnya melalui WhatsApp atau notifikasi ketika barang sudah selesai diperbaiki.',
                                        'barang sedang diperbaiki' =>
                                            'Teknisi sedang melakukan perbaikan. Anda akan mendapat notifikasi ketika proses selesai.',
                                        'barang sudah selesai diperbaiki' =>
                                            'Silakan mengambil barang di lokasi kami. Hubungi teknisi jika membutuhkan bantuan lokasi.',
                                        'barang sudah selesai dan terbayar' =>
                                            'Terima kasih telah menggunakan layanan kami. Berikan rating untuk pengalaman Anda.',
                                    ];
                                    $currentProses = strtolower($service->proses ?? '');
                                    $deskripsiProses =
                                        $descriptions[$currentProses] ??
                                        'Antarkan barang elektronik ke tempat kami untuk mulai proses servis.';
                                @endphp
                                <p class="text-gray-600 mt-2">{{ $deskripsiProses }}</p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Column - Service Details -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Service Information Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 fade-in">
                        <div class="flex items-center mb-4">
                            <div class="p-2 rounded-lg bg-blue-100 text-blue-600 mr-3">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Informasi Servis</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">ID Servis</p>
                                    <p class="font-medium text-gray-800">{{ $service->service_id }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tanggal Diterima</p>
                                    <p class="font-medium text-gray-800">
                                        {{ \Carbon\Carbon::parse($service->created_at)->translatedFormat('d M Y, H:i') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Nama Pelanggan</p>
                                    <p class="font-medium text-gray-800">{{ $service->nama_pelanggan }}</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">Jenis Barang</p>
                                    <p class="font-medium text-gray-800">{{ $service->jenis_barang }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Nama Barang</p>
                                    <p class="font-medium text-gray-800">{{ $service->nama_barang }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Kerusakan</p>
                                    <p class="font-medium text-gray-800">{{ $service->kerusakan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Technician Information Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 fade-in">
                        <div class="flex items-center mb-4">
                            <div class="p-2 rounded-lg bg-green-100 text-green-600 mr-3">
                                <i class="fas fa-user-cog"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Informasi Teknisi</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500">Nama Teknisi</p>
                                    <p class="font-medium text-gray-800">
                                        {{ optional($service->handledBy)->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">No. WhatsApp</p>
                                    <p class="font-medium text-gray-800">
                                        {{ optional($service->handledBy)->no_wa ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500">Rating Teknisi</p>
                                    <div class="flex items-center gap-2">
                                        @php
                                            $techRating = optional($service->handledBy)->rating ?? 0;
                                        @endphp
                                        <div class="flex text-yellow-400">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star{{ $i <= $techRating ? '' : '-empty' }} text-sm"></i>
                                            @endfor
                                        </div>
                                        <span
                                            class="text-sm text-gray-600">{{ number_format($techRating, 1) }}/5</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total Servis</p>
                                    <p class="font-medium text-gray-800">
                                        {{ optional($service->handledBy)->total_servis ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Rating Section -->
                        <template
                            x-if="{{ $service->proses === 'barang sudah selesai dan terbayar' ? 'true' : 'false' }}">
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <template x-if="!hasRated">
                                    <div class="text-center">
                                        <h4 class="font-semibold text-gray-700 mb-3">Beri Rating Teknisi</h4>
                                        <button @click="ratingModal = true"
                                            class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-medium">
                                            <i class="fas fa-star mr-2"></i>Beri Rating
                                        </button>
                                    </div>
                                </template>

                                <template x-if="hasRated">
                                    <div class="text-center">
                                        <h4 class="font-semibold text-gray-700 mb-3">Rating Anda</h4>
                                        <div class="flex items-center justify-center gap-2 mb-2">
                                            <template x-for="i in 5">
                                                <i :class="i <= userRating ? 'fas fa-star text-yellow-400' :
                                                    'far fa-star text-gray-300'"
                                                    class="text-lg"></i>
                                            </template>
                                        </div>
                                        <p class="text-sm text-gray-600" x-text="'Rating: ' + userRating + '/5'"></p>
                                        <template x-if="userReview">
                                            <p class="text-sm text-gray-600 mt-2" x-text="'Ulasan: ' + userReview"></p>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Right Column - Cost & Timeline -->
                <div class="space-y-6">

                    <!-- Cost Details Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 fade-in">
                        <div class="flex items-center mb-4">
                            <div class="p-2 rounded-lg bg-purple-100 text-purple-600 mr-3">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Detail Biaya</h3>
                        </div>

                        @if ($detail)
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Sparepart</span>
                                    <span class="font-medium text-gray-800">{{ $detail->nama_sparepart ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Harga Sparepart</span>
                                    <span class="font-medium text-gray-800">Rp
                                        {{ number_format($detail->harga_sparepart ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Biaya Jasa</span>
                                    <span class="font-medium text-gray-800">Rp
                                        {{ number_format($detail->harga_jasa ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div class="border-t border-gray-200 pt-3 mt-2">
                                    <div class="flex justify-between items-center font-bold text-lg">
                                        <span class="text-gray-800">Total Biaya</span>
                                        <span class="text-blue-600">Rp
                                            {{ number_format($detail->total_biaya ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">Detail biaya belum tersedia</p>
                        @endif
                    </div>

                    <!-- Timeline Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 fade-in">
                        <div class="flex items-center mb-4">
                            <div class="p-2 rounded-lg bg-orange-100 text-orange-600 mr-3">
                                <i class="fas fa-history"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Progress Servis</h3>
                        </div>

                        @php
                            $steps = [
                                'barang diterima' => 'Barang Diterima',
                                'barang sedang diperbaiki' => 'Sedang Diperbaiki',
                                'barang sudah selesai diperbaiki' => 'Selesai Diperbaiki',
                                'barang sudah selesai dan terbayar' => 'Selesai & Terbayar',
                            ];
                            $currentStep = strtolower($service->proses ?? '');
                        @endphp

                        <div class="relative">
                            @foreach ($steps as $key => $label)
                                @php
                                    $isCompleted =
                                        array_search($key, array_keys($steps)) <
                                        array_search($currentStep, array_keys($steps));
                                    $isActive = $key === $currentStep;
                                @endphp
                                <div class="flex items-start mb-4 last:mb-0">
                                    <div class="relative mr-4">
                                        <div
                                            class="timeline-dot {{ $isCompleted ? 'completed' : ($isActive ? 'active' : '') }}">
                                        </div>
                                        @if (!$loop->last)
                                            <div class="absolute left-0 top-4 w-0.5 h-8 bg-gray-200 ml-[5px]"></div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p
                                            class="font-medium {{ $isCompleted ? 'text-green-600' : ($isActive ? 'text-blue-600' : 'text-gray-400') }}">
                                            {{ $label }}
                                        </p>
                                        @if ($isActive)
                                            <p class="text-xs text-gray-500 mt-1">Status saat ini</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                            <p class="text-sm text-blue-700">
                                <i class="fas fa-clock mr-2"></i>
                                Perkiraan selesai:
                                <span class="font-medium">
                                    {{ \Carbon\Carbon::parse($service->created_at)->addDays(3)->translatedFormat('d M Y') }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center pt-6">
                <a href="{{ route('service.check.form') }}"
                    class="inline-flex items-center px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    <i class="fas fa-search mr-2"></i>Cek Servis Lainnya
                </a>
            </div>
        </div>
    </div>

    <!-- Rating Modal -->
    <div x-show="ratingModal" x-cloak
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full slide-in" @click.outside="ratingModal = false">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Beri Rating Teknisi</h3>
                    <button @click="ratingModal = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('service.giveRating', $service->id) }}" method="POST">
                    @csrf
                    <div class="text-center mb-6">
                        <div class="star-rating flex justify-center gap-1 mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                <label>
                                    <input type="radio" name="rating" value="{{ $i }}" class="hidden"
                                        x-model="selectedRating" required>
                                    <i class="fas fa-star text-3xl cursor-pointer transition-colors"
                                        :class="selectedRating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'"></i>
                                </label>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-600"
                            x-text="selectedRating ? 'Rating: ' + selectedRating + '/5' : 'Pilih rating'"></p>
                    </div>

                    <div class="mb-4">
                        <textarea name="ulasan" rows="3" placeholder="Tulis ulasan Anda (opsional)"
                            class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 resize-none"
                            x-model="userReview"></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" @click="ratingModal = false"
                            class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-medium"
                            :disabled="selectedRating === 0"
                            :class="selectedRating === 0 ? 'opacity-50 cursor-not-allowed' : ''">
                            Kirim Rating
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Star rating interaction
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-rating input');
            stars.forEach(star => {
                star.addEventListener('change', function() {
                    const rating = this.value;
                    // Update visual state is handled by Alpine.js
                });
            });
        });
    </script>
</body>

</html>
