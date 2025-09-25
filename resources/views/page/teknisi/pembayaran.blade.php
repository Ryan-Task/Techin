<!DOCTYPE html>
<html lang="id" x-data="{ paymentMethod: 'cod' }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
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

        .payment-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .payment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .payment-card.selected {
            border-color: #3b82f6;
            background-color: #f0f9ff;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans min-h-screen">
    @include('komponen.sidebar')

    <div class="lg:ml-30 p-6">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8 fade-in">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Detail Pembayaran</h1>
                <p class="text-gray-600">Selesaikan pembayaran untuk servis yang telah dilakukan</p>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Customer & Service Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Customer Information Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 fade-in">
                        <div class="flex items-center mb-4">
                            <div class="p-2 rounded-lg bg-blue-100 text-blue-600 mr-3">
                                <i class="fas fa-user text-lg"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Informasi Pelanggan</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500">ID Servis</p>
                                    <p class="font-medium text-gray-800">{{ $service->service->service_id ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Nama Pelanggan</p>
                                    <p class="font-medium text-gray-800">{{ $service->service->nama_pelanggan ?? '-' }}
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500">No WA Pelanggan</p>
                                    <p class="font-medium text-gray-800">{{ $service->service->no_wa ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Teknisi</p>
                                    <p class="font-medium text-gray-800">
                                        {{ $service->service->handledBy ? $service->service->handledBy->name : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cost Details Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 fade-in">
                        <div class="flex items-center mb-4">
                            <div class="p-2 rounded-lg bg-green-100 text-green-600 mr-3">
                                <i class="fas fa-receipt text-lg"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Rincian Biaya</h3>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <div>
                                    <p class="text-gray-600">Sparepart</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $service->nama_sparepart ?? 'Tidak ada sparepart' }}</p>
                                </div>
                                <span class="font-medium text-gray-800">
                                    Rp {{ number_format($service->harga_sparepart ?? 0, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <p class="text-gray-600">Biaya Jasa</p>
                                <span class="font-medium text-gray-800">
                                    Rp {{ number_format($service->harga_jasa ?? 0, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center pt-2">
                                <p class="text-lg font-semibold text-gray-800">Total Biaya</p>
                                <span class="text-xl font-bold text-blue-600">
                                    Rp {{ number_format($service->total_biaya ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Payment Method -->
                <div class="space-y-6">
                    <!-- Payment Method Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 fade-in">
                        <div class="flex items-center mb-6">
                            <div class="p-2 rounded-lg bg-purple-100 text-purple-600 mr-3">
                                <i class="fas fa-credit-card text-lg"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Metode Pembayaran</h3>
                        </div>

                        <div class="space-y-4">
                            <!-- COD Option -->
                            <div class="payment-card cursor-pointer p-4 rounded-lg"
                                :class="{ 'selected': paymentMethod === 'cod' }" @click="paymentMethod = 'cod'">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-money-bill-wave text-gray-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">Cash on Delivery</p>
                                            <p class="text-sm text-gray-500">Bayar saat servis selesai</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center"
                                            :class="{ 'bg-blue-500 border-blue-500': paymentMethod === 'cod' }">
                                            <i x-show="paymentMethod === 'cod'"
                                                class="fas fa-check text-white text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- E-Wallet Option -->
                            <div class="payment-card cursor-pointer p-4 rounded-lg"
                                :class="{ 'selected': paymentMethod === 'ewallet' }"
                                @click="paymentMethod = 'ewallet'">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                            <i class="fas fa-wallet text-green-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">E-Wallet</p>
                                            <p class="text-sm text-gray-500">Bayar sekarang secara online</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center"
                                            :class="{ 'bg-blue-500 border-blue-500': paymentMethod === 'ewallet' }">
                                            <i x-show="paymentMethod === 'ewallet'"
                                                class="fas fa-check text-white text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Buttons -->
                        <div class="mt-8 space-y-3">
                            <!-- COD Button -->
                            <form method="POST" action="{{ route('pembayaran.cod') }}"
                                x-show="paymentMethod === 'cod'">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->service->service_id }}">
                                <button type="submit"
                                    class="w-full bg-gray-700 hover:bg-gray-800 text-white py-3 px-4 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Konfirmasi COD</span>
                                </button>
                            </form>

                            <!-- E-Wallet Button -->
                            <button x-show="paymentMethod === 'ewallet'" id="ewallet-button"
                                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                                <i class="fas fa-credit-card"></i>
                                <span>Bayar Sekarang</span>
                            </button>

                            <p x-show="paymentMethod === 'cod'" class="text-xs text-gray-500 text-center mt-2">
                                Teknisi akan menerima pembayaran secara langsung setelah servis selesai
                            </p>
                            <p x-show="paymentMethod === 'ewallet'" class="text-xs text-gray-500 text-center mt-2">
                                Pembayaran aman melalui Midtrans
                            </p>
                        </div>
                    </div>

                    <!-- Status Indicator -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 fade-in">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-full bg-blue-100">
                                <i class="fas fa-info-circle text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-blue-800">Status Servis</p>
                                <p class="text-sm text-blue-600">Menunggu konfirmasi pembayaran</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('payment', () => ({
                init() {
                    // Initialize payment method from localStorage or default to 'cod'
                    const savedMethod = localStorage.getItem('selectedPaymentMethod');
                    if (savedMethod) {
                        this.paymentMethod = savedMethod;
                    }
                },

                paymentMethod: 'cod',

                watchPaymentMethod() {
                    // Save selected payment method to localStorage
                    localStorage.setItem('selectedPaymentMethod', this.paymentMethod);
                }
            }));
        });

        // E-Wallet Payment Handler
        document.getElementById('ewallet-button')?.addEventListener('click', function() {
            const button = this;
            const originalText = button.innerHTML;

            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Memproses...</span>';
            button.disabled = true;

            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    console.log('Payment success:', result);
                    button.innerHTML = '<i class="fas fa-check"></i><span>Berhasil!</span>';
                    setTimeout(() => {
                        window.location.href =
                            "{{ route('pembayaran.success', $service->service->service_id) }}";
                    }, 1000);
                },
                onPending: function(result) {
                    console.log('Payment pending:', result);
                    button.innerHTML = originalText;
                    button.disabled = false;
                    showNotification('Pembayaran menunggu konfirmasi', 'warning');
                },
                onError: function(result) {
                    console.log('Payment error:', result);
                    button.innerHTML = originalText;
                    button.disabled = false;
                    showNotification('Terjadi kesalahan saat pembayaran', 'error');
                },
                onClose: function() {
                    console.log('Payment popup closed');
                    button.innerHTML = originalText;
                    button.disabled = false;
                    showNotification('Pembayaran dibatalkan', 'info');
                }
            });
        });

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg text-white z-50 transform transition-transform duration-300 ${
                type === 'error' ? 'bg-red-500' : 
                type === 'warning' ? 'bg-yellow-500' : 
                type === 'success' ? 'bg-green-500' : 'bg-blue-500'
            }`;
            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : type === 'warning' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Add fade-in animation to elements as they come into view
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.fade-in');

            const fadeInObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            fadeElements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                fadeInObserver.observe(element);
            });
        });
    </script>
</body>

</html>
