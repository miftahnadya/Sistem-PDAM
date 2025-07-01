<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Tagihan - Admin PDAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="flex min-h-screen">
        @include('component.sidebar')
        
        <main class="flex-1 px-4 py-6 lg:px-8 lg:py-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <a href="{{ route('isitagihan') }}" 
                       class="text-blue-600 hover:text-blue-800 mr-4">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <h1 class="text-3xl lg:text-4xl font-bold text-[#10283a]">
                        <i class="fas fa-plus mr-3 text-[#6bb6d6]"></i>Input Tagihan Baru
                    </h1>
                </div>
                <p class="text-gray-600">Input tagihan untuk pelanggan PDAM berdasarkan bulan dan tahun</p>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Input -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <form action="{{ route('admin.store-tagihan') }}" method="POST" id="inputTagihanForm">
                    @csrf
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2"></i>Pilih Pelanggan
                                </label>
                                <select name="id_pel" id="id_pel" required 
                                        class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:outline-none">
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach($pelanggan as $p)
                                        <option value="{{ $p->id_pel }}" 
                                                data-nama="{{ $p->nama_pelanggan }}"
                                                data-goltar="{{ $p->goltar }}"
                                                data-alamat="{{ $p->alamat }}"
                                                data-meter="{{ $p->angka_meter_kini ?? 0 }}">
                                            {{ $p->id_pel }} - {{ $p->nama_pelanggan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Periode Input (Bulan dan Tahun) -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-calendar mr-2"></i>Bulan
                                    </label>
                                    <select name="bulan" id="bulan" required 
                                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:outline-none">
                                        <option value="">-- Pilih Bulan --</option>
                                        <option value="1" {{ date('n') == 1 ? 'selected' : '' }}>Januari</option>
                                        <option value="2" {{ date('n') == 2 ? 'selected' : '' }}>Februari</option>
                                        <option value="3" {{ date('n') == 3 ? 'selected' : '' }}>Maret</option>
                                        <option value="4" {{ date('n') == 4 ? 'selected' : '' }}>April</option>
                                        <option value="5" {{ date('n') == 5 ? 'selected' : '' }}>Mei</option>
                                        <option value="6" {{ date('n') == 6 ? 'selected' : '' }}>Juni</option>
                                        <option value="7" {{ date('n') == 7 ? 'selected' : '' }}>Juli</option>
                                        <option value="8" {{ date('n') == 8 ? 'selected' : '' }}>Agustus</option>
                                        <option value="9" {{ date('n') == 9 ? 'selected' : '' }}>September</option>
                                        <option value="10" {{ date('n') == 10 ? 'selected' : '' }}>Oktober</option>
                                        <option value="11" {{ date('n') == 11 ? 'selected' : '' }}>November</option>
                                        <option value="12" {{ date('n') == 12 ? 'selected' : '' }}>Desember</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-calendar-alt mr-2"></i>Tahun
                                    </label>
                                    <select name="tahun" id="tahun" required 
                                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:outline-none">
                                        <option value="">-- Pilih Tahun --</option>
                                        @for($year = 2020; $year <= 2030; $year++)
                                            <option value="{{ $year }}" {{ date('Y') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-gauge mr-2"></i>Angka Meter Lalu
                                    </label>
                                    <input type="number" name="angka_meter_lalu" id="angka_meter_lalu" 
                                           step="0.001" min="0" required
                                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:outline-none"
                                           onchange="hitungPemakaian()">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-gauge-high mr-2"></i>Angka Meter Kini
                                    </label>
                                    <input type="number" name="angka_meter_kini" id="angka_meter_kini" 
                                           step="0.001" min="0" required
                                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:outline-none"
                                           onchange="hitungPemakaian()">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-tint mr-2"></i>Pemakaian (m³)
                                </label>
                                <input type="number" id="pemakaian" readonly
                                       class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 bg-gray-50">
                                <p class="text-sm text-blue-600 mt-1" id="periodeInfo"></p>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div class="bg-blue-50 p-6 rounded-lg">
                                <h3 class="font-semibold text-blue-800 mb-4">
                                    <i class="fas fa-info-circle mr-2"></i>Informasi Pelanggan
                                </h3>
                                <div id="pelangganInfo" class="space-y-2 text-sm">
                                    <p>Pilih pelanggan untuk melihat informasi</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-money-bill mr-2"></i>Biaya Admin
                                    </label>
                                    <input type="number" name="biaya_admin" id="biaya_admin" 
                                           value="10000" min="0" required
                                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:outline-none"
                                           onchange="hitungTotal()">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>Denda
                                    </label>
                                    <input type="number" name="denda" id="denda" 
                                           value="0" min="0"
                                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:outline-none"
                                           onchange="hitungTotal()">
                                </div>
                            </div>

                            <div class="bg-green-50 p-6 rounded-lg">
                                <h3 class="font-semibold text-green-800 mb-4">
                                    <i class="fas fa-calculator mr-2"></i>Kalkulasi Tagihan
                                </h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span>Harga Air:</span>
                                        <span id="hargaAir">Rp 0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Biaya Admin:</span>
                                        <span id="displayBiayaAdmin">Rp 10,000</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Denda:</span>
                                        <span id="displayDenda">Rp 0</span>
                                    </div>
                                    <hr class="border-green-200">
                                    <div class="flex justify-between font-bold text-lg">
                                        <span>Total Tagihan:</span>
                                        <span id="totalTagihan" class="text-green-600">Rp 10,000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-8 pt-6 border-t">
                        <a href="{{ route('isitagihan') }}" 
                           class="px-8 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i>Simpan Tagihan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Tarif berdasarkan golongan
        const tarifGolongan = {
            '21': 3600,  // Rumah Tangga 1
            '22': 4500,  // Rumah Tangga 2
            '23': 5400,  // Rumah Tangga 3
            '24': 6300,  // Rumah Tangga 4
            '31': 7200,  // Komersial 1
            '32': 8100,  // Komersial 2
            '41': 9000,  // Industri 1
            '42': 10800  // Industri 2
        };

        const namaBulan = {
            1: 'Januari', 2: 'Februari', 3: 'Maret', 4: 'April',
            5: 'Mei', 6: 'Juni', 7: 'Juli', 8: 'Agustus',
            9: 'September', 10: 'Oktober', 11: 'November', 12: 'Desember'
        };

        document.getElementById('id_pel').addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const info = document.getElementById('pelangganInfo');
            
            if (this.value) {
                const nama = option.dataset.nama;
                const goltar = option.dataset.goltar;
                const alamat = option.dataset.alamat;
                const meterLalu = option.dataset.meter;
                
                info.innerHTML = `
                    <p><strong>Nama:</strong> ${nama}</p>
                    <p><strong>Golongan Tarif:</strong> ${goltar}</p>
                    <p><strong>Alamat:</strong> ${alamat}</p>
                    <p><strong>Meter Terakhir:</strong> ${meterLalu} m³</p>
                    <p><strong>Tarif per m³:</strong> Rp ${(tarifGolongan[goltar] || 3600).toLocaleString('id-ID')}</p>
                `;
                
                document.getElementById('angka_meter_lalu').value = meterLalu;
                hitungPemakaian();
            } else {
                info.innerHTML = '<p>Pilih pelanggan untuk melihat informasi</p>';
            }
        });

        function updatePeriodeInfo() {
            const bulan = document.getElementById('bulan').value;
            const tahun = document.getElementById('tahun').value;
            const info = document.getElementById('periodeInfo');
            
            if (bulan && tahun) {
                info.textContent = `Periode: ${namaBulan[parseInt(bulan)]} ${tahun}`;
            } else {
                info.textContent = '';
            }
        }

        document.getElementById('bulan').addEventListener('change', updatePeriodeInfo);
        document.getElementById('tahun').addEventListener('change', updatePeriodeInfo);

        function hitungPemakaian() {
            const meterLalu = parseFloat(document.getElementById('angka_meter_lalu').value) || 0;
            const meterKini = parseFloat(document.getElementById('angka_meter_kini').value) || 0;
            const pemakaian = meterKini - meterLalu;
            
            document.getElementById('pemakaian').value = pemakaian >= 0 ? pemakaian.toFixed(3) : 0;
            hitungTotal();
        }

        function hitungTotal() {
            const pelangganSelect = document.getElementById('id_pel');
            const option = pelangganSelect.options[pelangganSelect.selectedIndex];
            
            if (!option.value) return;
            
            const goltar = option.dataset.goltar;
            const pemakaian = parseFloat(document.getElementById('pemakaian').value) || 0;
            const biayaAdmin = parseFloat(document.getElementById('biaya_admin').value) || 0;
            const denda = parseFloat(document.getElementById('denda').value) || 0;
            
            const tarif = tarifGolongan[goltar] || 3600;
            const hargaAir = pemakaian * tarif;
            const total = hargaAir + biayaAdmin + denda;
            
            document.getElementById('hargaAir').textContent = `Rp ${hargaAir.toLocaleString('id-ID')}`;
            document.getElementById('displayBiayaAdmin').textContent = `Rp ${biayaAdmin.toLocaleString('id-ID')}`;
            document.getElementById('displayDenda').textContent = `Rp ${denda.toLocaleString('id-ID')}`;
            document.getElementById('totalTagihan').textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }

        // Form validation
        document.getElementById('inputTagihanForm').addEventListener('submit', function(e) {
            const meterLalu = parseFloat(document.getElementById('angka_meter_lalu').value);
            const meterKini = parseFloat(document.getElementById('angka_meter_kini').value);
            
            if (meterKini < meterLalu) {
                e.preventDefault();
                alert('Angka meter kini harus lebih besar atau sama dengan meter lalu');
                return;
            }
            
            const bulan = document.getElementById('bulan').value;
            const tahun = document.getElementById('tahun').value;
            
            if (!bulan || !tahun) {
                e.preventDefault();
                alert('Pilih bulan dan tahun terlebih dahulu');
                return;
            }
        });

        // Initialize
        updatePeriodeInfo();
    </script>
</body>
</html>