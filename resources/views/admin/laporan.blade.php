<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - PDAM Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="flex w-full min-h-screen">
        @include('component.sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 lg:ml-0 transition-all duration-300">
            <!-- Header -->
            <div class="bg-white shadow-lg border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Laporan</h1>
                        <p class="text-gray-600">Laporan keuangan dan operasional PDAM</p>
                    </div>
                    <button onclick="printReport()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-print mr-2"></i>Cetak Laporan
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Filter Periode -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <form method="GET" action="{{ route('admin.laporan') }}" class="flex flex-wrap gap-4 items-end">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                            <select name="bulan" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                                @endfor
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                            <select name="tahun" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                @for($i = date('Y'); $i >= date('Y') - 3; $i--)
                                <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                    </form>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Pelanggan</p>
                                <p class="text-3xl font-bold text-gray-800">{{ number_format($laporan_data['total_pelanggan']) }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Tagihan</p>
                                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($laporan_data['total_tagihan'], 0, ',', '.') }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-emerald-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Tagihan Terbayar</p>
                                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($laporan_data['tagihan_terbayar'], 0, ',', '.') }}</p>
                            </div>
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Tagihan Tertunggak</p>
                                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($laporan_data['tagihan_tertunggak'], 0, ',', '.') }}</p>
                            </div>
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail per Golongan -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Detail per Golongan Tarif</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Golongan</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Pelanggan</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Total Pemakaian (m³)</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Total Tagihan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($laporan_data['detail_per_golongan'] as $golongan => $data)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                                            Golongan {{ $golongan }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($data->jumlah_pelanggan ?? 0) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($data->total_pemakaian ?? 0) }} m³
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($data->total_tagihan ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Chart Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Distribusi Pelanggan per Golongan</h3>
                        <canvas id="golonganChart" height="300"></canvas>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Status Pembayaran</h3>
                        <canvas id="pembayaranChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chart configurations
        const golonganCtx = document.getElementById('golonganChart').getContext('2d');
        const pembayaranCtx = document.getElementById('pembayaranChart').getContext('2d');

        // Golongan Chart
        new Chart(golonganCtx, {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($laporan_data['detail_per_golongan'])),
                datasets: [{
                    data: @json(array_values(array_map(fn($item) => $item->jumlah_pelanggan ?? 0, $laporan_data['detail_per_golongan']))),
                    backgroundColor: [
                        '#3B82F6', '#10B981', '#F59E0B', '#EF4444',
                        '#8B5CF6', '#06B6D4', '#84CC16', '#F97316'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Pembayaran Chart
        new Chart(pembayaranCtx, {
            type: 'pie',
            data: {
                labels: ['Terbayar', 'Tertunggak'],
                datasets: [{
                    data: [{{ $laporan_data['tagihan_terbayar'] }}, {{ $laporan_data['tagihan_tertunggak'] }}],
                    backgroundColor: ['#10B981', '#EF4444']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        function printReport() {
            window.print();
        }
    </script>
</body>
</html>