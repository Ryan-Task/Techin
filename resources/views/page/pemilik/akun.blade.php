<!DOCTYPE html>
<html lang="id" x-data="app()">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        .toggle-container {
            width: 42px;
            height: 22px;
        }

        .toggle-label {
            background-color: #d1d5db;
            transition: background-color 0.3s ease;
        }

        .toggle-checkbox:checked+.toggle-label {
            background-color: #2563eb;
        }

        .toggle-checkbox {
            top: -2px;
            left: -2px;
            width: 26px;
            height: 26px;
            border: 2px solid #fff;
            background-color: white;
            transition: transform 0.3s ease;
        }

        .toggle-checkbox:checked {
            transform: translateX(20px);
        }

        [x-cloak] {
            display: none !important;
        }

        .modal-backdrop {
            z-index: 40;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            z-index: 50;
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

        .toggle-container.disabled {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Layout improvements */
        .main-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar-container {
            flex: 0 0 auto;
        }

        .content-container {
            flex: 1;
            padding: 1rem;
            margin-left: 0;
            width: calc(100% - 16rem);
        }

        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }

            .content-container {
                width: 100%;
                margin-left: 0;
                padding: 0.5rem;
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="main-container">
        <div class="sidebar-container mr-20">
            @include('komponen.sidebar')
        </div>

        <div class="content-container">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">Manajemen Akun Teknisi/Owner</h2>
                    <button @click="showAddModal = true"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Tambah Akun
                    </button>
                </div>

                <div class="p-6">
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div x-show="notification.show" x-cloak x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform translate-y-2"
                        :class="{
                            'bg-green-100 border border-green-400 text-green-700': notification.type === 'success',
                            'bg-red-100 border border-red-400 text-red-700': notification.type === 'error'
                        }"
                        class="mb-4 p-4 rounded">
                        <div class="flex justify-between items-center">
                            <span x-text="notification.message"></span>
                            <button @click="notification.show = false" class="text-lg font-semibold">&times;</button>
                        </div>
                    </div>

                    <form action="{{ route('pemilik.akun.index') }}" method="GET" class="mb-6">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Cari nama atau email...">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-极8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama</th>
                                    <th scope="col"
                                        class="px-6极 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $index => $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $users->firstItem() + $index }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role == 'owner' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="toggle-container relative inline-block w-10 mr-2 align-middle select-none">
                                                    <input type="checkbox" id="toggle-{{ $user->id }}"
                                                        @click="confirmToggleAccess($event, {{ $user->id }}, '{{ $user->name }}', {{ $user->akses ? 'true' : 'false' }})"
                                                        {{ $user->akses ? 'checked' : '' }}
                                                        class="toggle-checkbox absolute block rounded-full appearance-none cursor-pointer" />
                                                    <label for="toggle-{{ $user->id }}"
                                                        class="toggle-label block overflow-hidden h-6 rounded-full cursor-pointer"></label>
                                                </div>
                                                <span
                                                    class="text-sm text-gray-600">{{ $user->akses ? 'Aktif' : 'Nonaktif' }}</span>
                                                <span x-show="loadingUserId === {{ $user->id }}"
                                                    class="spinner"></span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button @click="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                                class="text-red-600 hover:text-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 极0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

            <!-- Add User Modal -->
            <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="fixed inset-0 bg-black/50" @click="showAddModal = false"></div>
                <div class="bg-white rounded-lg w-full max-w-md relative z-50 shadow-lg">
                    <form action="{{ route('pemilik.akun.store') }}" method="POST" class="p-6">
                        @csrf
                        <h3 class="text-lg font-semibold mb-4">Tambah Akun Baru</h3>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nama</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="name" name="name" type="text" placeholder="Nama lengkap" required
                                x-model="formData.name">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="email" name="email" type="email" placeholder="Email" required
                                x-model="formData.email">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                            <input
                                class="shadow appearance-none border rounded w-full极 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="password" name="password" type="password" placeholder="Password" required
                                minlength="6" x-model="formData.password">
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="role">Role</label>
                            <select
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none极 focus:shadow-outline"
                                id="role" name="role" required x-model="formData.role">
                                <option value="">Pilih Role</option>
                                <option value="teknisi">Teknisi</option>
                                <option value="owner">Owner</option>
                            </select>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="showAddModal = false"
                                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="fixed inset-0 bg-black/50" @click="showDeleteModal = false"></div>
                <div class="bg-white rounded-lg w-full max-w-md relative z-50">
                    <div class="p-6">
                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Hapus Akun</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500"
                                        x-text="'Apakah Anda yakin ingin menghapus akun ' + deleteName + '?'"></p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end space-x-3">
                            <button type="button" @click="showDeleteModal = false"
                                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</button>
                            <form :action="deleteUrl" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Toggle Access Confirmation Modal -->
            <div x-show="showToggleModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="fixed inset-0 bg-black/50" @click="cancelToggleAccess"></div>
                <div class="bg-white rounded-lg w-full max-w-md relative z-50">
                    <div class="p-6">
                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                                <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v极6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900"
                                    x-text="toggleData.newAccess ? 'Aktifkan Akses' : 'Nonaktifkan Akses'"></h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500"
                                        x-text="'Apakah Anda yakin ingin ' + (toggleData.newAccess ? 'mengaktifkan' : 'menonaktifkan') + ' akses untuk ' + toggleData.userName + '?'">
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end space-x-3">
                            <button type="button" @click="cancelToggleAccess"
                                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</button>
                            <button @click="toggleAccessConfirmed"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Ya,
                                Lanjutkan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        @include('komponen.footer')
    </div>

    <script>
        function app() {
            return {
                showAddModal: false,
                showDeleteModal: false,
                showToggleModal: false,
                deleteId: null,
                deleteName: '',
                deleteUrl: '',
                loadingUserId: null,
                toggleData: {
                    userId: null,
                    userName: '',
                    currentAccess: false,
                    newAccess: false,
                    checkboxElement: null // Menyimpan referensi checkbox
                },
                notification: {
                    show: false,
                    type: 'success',
                    message: ''
                },
                formData: {
                    name: '',
                    email: '',
                    password: '',
                    role: ''
                },

                showNotification(type, message) {
                    this.notification.type = type;
                    this.notification.message = message;
                    this.notification.show = true;
                    setTimeout(() => {
                        this.notification.show = false;
                    }, 5000);
                },

                confirmToggleAccess(event, userId, userName, currentAccess) {
                    // Mencegah perubahan visual toggle
                    event.preventDefault();

                    // Simpan referensi checkbox
                    const checkbox = document.getElementById(`toggle-${userId}`);

                    this.toggleData = {
                        userId,
                        userName,
                        currentAccess,
                        newAccess: !currentAccess,
                        checkboxElement: checkbox
                    };
                    this.showToggleModal = true;
                },

                cancelToggleAccess() {
                    // Kembalikan toggle ke state semula
                    if (this.toggleData.checkboxElement) {
                        this.toggleData.checkboxElement.checked = this.toggleData.currentAccess;
                    }
                    this.showToggleModal = false;
                },

                async toggleAccessConfirmed() {
                    this.showToggleModal = false;
                    this.loadingUserId = this.toggleData.userId;

                    try {
                        const response = await fetch(`/pemilik/akun/${this.toggleData.userId}/access`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                access: this.toggleData.newAccess
                            })
                        });

                        const data = await response.json();
                        if (!response.ok) throw new Error(data.message || 'Gagal mengubah status akses');

                        this.showNotification('success', data.message || 'Status akses berhasil diubah');

                        // Update teks status
                        const statusText = document.querySelector(`#toggle-${this.toggleData.userId}`).closest('td')
                            .querySelector('.text-sm.text-gray-600');
                        if (statusText) statusText.textContent = this.toggleData.newAccess ? 'Aktif' : 'Nonaktif';

                    } catch (error) {
                        console.error('Error:', error);

                        // Jika gagal, kembalikan toggle ke state semula
                        if (this.toggleData.checkboxElement) {
                            this.toggleData.checkboxElement.checked = this.toggleData.currentAccess;
                        }

                        this.showNotification('error', error.message || 'Terjadi kesalahan. Silakan coba lagi.');
                    } finally {
                        this.loadingUserId = null;
                    }
                },

                confirmDelete(id, name) {
                    this.deleteId = id;
                    this.deleteName = name;
                    this.deleteUrl = `/pemilik/akun/${id}`;
                    this.showDeleteModal = true;
                },

                resetForm() {
                    this.formData = {
                        name: '',
                        email: '',
                        password: '',
                        role: ''
                    };
                }
            }
        }
    </script>
</body>

</html>
