<!DOCTYPE html>
<html lang="id" x-data="app()">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        [x-cloak] {
            display: none !important;
        }

        .access-btn {
            padding: 0.35rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .access-btn.active {
            background-color: #10B981;
            color: white;
        }

        .access-btn.active:hover {
            background-color: #059669;
        }

        .access-btn.inactive {
            background-color: #EF4444;
            color: white;
        }

        .access-btn.inactive:hover {
            background-color: #DC2626;
        }

        .access-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .status-text {
            width: 70px;
            display: inline-block;
        }

        .spinner {
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3498db;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-left: 8px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="">
    @include('komponen.sidebar')
    <div class="bg-gray-100 font-sans">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-semibold mb-6">Manajemen Akun Teknisi/Owner</h1>

            <!-- Notifikasi -->
            <div x-show="notification.show" x-cloak
                :class="notification.type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' :
                    'bg-red-100 border border-red-400 text-red-700'"
                class="mb-4 p-4 rounded">
                <div class="flex justify-between items-center">
                    <span x-text="notification.message"></span>
                    <button @click="notification.show=false" class="text-lg font-semibold">&times;</button>
                </div>
            </div>

            <!-- Tombol Tambah Akun -->
            <button @click="showAddModal = true"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 flex items-center mb-4">
                <i class="fa fa-plus mr-2"></i> Tambah Akun
            </button>

            <!-- Tabel Akun -->
            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No WA
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($users as $index => $user)
                            <tr>
                                <td class="px-6 py-4">{{ $users->firstItem() + $index }}</td>
                                <td class="px-6 py-4">{{ $user->name }}</td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">{{ $user->no_wa }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role == 'owner' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <button :disabled="loadingUserId === {{ $user->id }}"
                                            data-user-id="{{ $user->id }}"
                                            @click="handleAccessClick({{ $user->id }}, '{{ $user->name }}', {{ $user->akses ? 'true' : 'false' }}, '{{ $user->email }}')"
                                            class="access-btn {{ $user->akses ? 'active' : 'inactive' }}"
                                            x-text="{{ $user->akses ? "'Nonaktifkan'" : "'Aktifkan'" }}">
                                        </button>
                                        <span class="status-text ml-2"
                                            x-text="userStatus[{{ $user->id }}] ?? '{{ $user->akses ? 'Aktif' : 'Nonaktif' }}'"></span>
                                        <span x-show="loadingUserId==={{ $user->id }}" class="spinner"></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <button @click="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                        class="text-red-600 hover:text-red-900">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">{{ $users->links() }}</div>
            </div>

            <!-- Modal Tambah Akun -->
            <div x-show="showAddModal" x-cloak class="fixed inset-0 flex items-center justify-center z-50">
                <div class="fixed inset-0 bg-black/50" @click="showAddModal=false"></div>
                <div class="bg-white rounded-lg w-full max-w-md shadow-lg z-50 p-6">
                    <h3 class="text-lg font-semibold mb-4">Tambah Akun Baru</h3>
                    <form @submit.prevent="submitAddUser">
                        <div class="mb-4">
                            <label>Nama</label>
                            <input type="text" x-model="formData.name" class="w-full border rounded px-3 py-2"
                                required>
                        </div>
                        <div class="mb-4">
                            <label>Email</label>
                            <input type="email" x-model="formData.email" class="w-full border rounded px-3 py-2"
                                required>
                        </div>
                        <div class="mb-4">
                            <label>No WA</label>
                            <input type="text" x-model="formData.no_wa" class="w-full border rounded px-3 py-2">
                        </div>
                        <div class="mb-4">
                            <label>Password</label>
                            <input type="password" x-model="formData.password" class="w-full border rounded px-3 py-2"
                                required minlength="6">
                        </div>
                        <div class="mb-4">
                            <label>Role</label>
                            <select x-model="formData.role" class="w-full border rounded px-3 py-2" required>
                                <option value="">Pilih Role</option>
                                <option value="teknisi">Teknisi</option>
                                <option value="owner">Owner</option>
                            </select>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="showAddModal=false"
                                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Verifikasi Akun -->
            <div x-show="showVerificationModal" x-cloak class="fixed inset-0 flex items-center justify-center z-50">
                <div class="fixed inset-0 bg-black/50"></div>
                <div class="bg-white rounded-lg w-full max-w-md shadow-lg z-50 p-6">
                    <h3 class="text-lg font-semibold mb-4">Verifikasi Akun</h3>
                    <p class="mb-4 text-gray-600">Masukkan kode verifikasi untuk email <span
                            x-text="verificationEmail"></span></p>
                    <input type="text" x-model="verificationCode" placeholder="Kode verifikasi"
                        class="w-full border rounded px-3 py-2 mb-4">
                    <div class="flex justify-end space-x-3">
                        <button @click="showVerificationModal=false"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</button>
                        <button @click="submitVerificationCode"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Verifikasi</button>
                    </div>
                </div>
            </div>

        </div>

        <script>
            function app() {
                return {
                    showAddModal: false,
                    showVerificationModal: false,
                    loadingUserId: null,
                    formData: {
                        name: '',
                        email: '',
                        no_wa: '',
                        password: '',
                        role: ''
                    },
                    verificationCode: '',
                    verificationEmail: '',
                    pendingAccessUserId: null,
                    notification: {
                        show: false,
                        type: 'success',
                        message: ''
                    },
                    userStatus: {},

                    showNotification(type, message) {
                        this.notification = {
                            show: true,
                            type,
                            message
                        };
                        setTimeout(() => this.notification.show = false, 5000);
                    },

                    async submitAddUser() {
                        try {
                            const res = await fetch("{{ route('pemilik.akun.store') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(this.formData)
                            });
                            const data = await res.json();
                            if (!res.ok) throw new Error(data.message || 'Gagal menambahkan akun');

                            this.showAddModal = false;
                            this.verificationEmail = this.formData.email;
                            this.verificationCode = '';
                            this.showVerificationModal = true;
                            this.pendingAccessUserId = null;
                            this.showNotification('success', 'Akun berhasil dibuat. Masukkan kode verifikasi.');
                        } catch (err) {
                            this.showNotification('error', err.message || 'Terjadi kesalahan.');
                        }
                    },

                    async submitVerificationCode() {
                        if (!this.verificationCode) {
                            this.showNotification('error', 'Kode verifikasi harus diisi');
                            return;
                        }
                        try {
                            const res = await fetch("/pemilik/akun/verify", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    email: this.verificationEmail,
                                    code: this.verificationCode
                                })
                            });
                            const data = await res.json();
                            if (!res.ok) throw new Error(data.message || 'Kode salah');

                            this.showVerificationModal = false;
                            this.showNotification('success', 'Akun berhasil diverifikasi');

                            // Update status tombol akses langsung
                            if (this.pendingAccessUserId) {
                                this.userStatus[this.pendingAccessUserId] = 'Aktif';
                                const btn = document.querySelector(
                                    `button[data-user-id='${this.pendingAccessUserId}']`);
                                if (btn) {
                                    btn.classList.remove('inactive');
                                    btn.classList.add('active');
                                    btn.innerText = 'Nonaktifkan';
                                }
                                this.pendingAccessUserId = null;
                            }
                        } catch (err) {
                            this.showNotification('error', err.message || 'Kode salah');
                        }
                    },

                    async handleAccessClick(userId, name, currentAccess, email) {
                        if (currentAccess) {
                            this.toggleAccess(userId);
                        } else {
                            this.verificationEmail = email;
                            this.verificationCode = '';
                            this.pendingAccessUserId = userId;

                            try {
                                const res = await fetch(`/pemilik/akun/${userId}/resend-code`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                });
                                const data = await res.json();
                                if (!res.ok) throw new Error(data.message || 'Gagal mengirim kode');
                                this.showNotification('success', data.message || 'Kode verifikasi dikirim');
                                this.showVerificationModal = true;
                            } catch (err) {
                                this.showNotification('error', err.message || 'Terjadi kesalahan');
                            }
                        }
                    },

                    async toggleAccess(userId) {
                        this.loadingUserId = userId;
                        try {
                            const res = await fetch(`/pemilik/akun/${userId}/access`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            });
                            const data = await res.json();
                            this.showNotification('success', data.message || 'Status akses berhasil diubah');
                            setTimeout(() => window.location.reload(), 500);
                        } catch (err) {
                            this.showNotification('error', err.message || 'Terjadi kesalahan');
                        } finally {
                            this.loadingUserId = null;
                        }
                    },

                    confirmDelete(id, name) {
                        if (!id) return this.showNotification('error', 'User ID tidak valid');
                        if (!confirm(`Hapus akun ${name}?`)) return;
                        fetch(`/pemilik/akun/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(r => r.json())
                            .then(data => {
                                this.showNotification('success', data.message || 'Akun berhasil dihapus');
                                setTimeout(() => window.location.reload(), 500);
                            })
                            .catch(err => this.showNotification('error', err.message || 'Terjadi kesalahan'));
                    }
                }
            }
        </script>
    </div>
</body>
<footer class="footer bg-gray-800 text-white p-4">
    @include('komponen.footer')
</footer>

</html>
