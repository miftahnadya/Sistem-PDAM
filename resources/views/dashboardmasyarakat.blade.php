<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Masyarakat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-[#f4fbfd] min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#10283a] min-h-screen flex flex-col py-8 px-4">
            <div class="mb-8">
                <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center mx-auto">
                    <span class="text-black font-bold text-2xl">{{ strtoupper(substr($user->nama_pelanggan,0,1)) }}</span>
                </div>
                <div class="text-center mt-2 text-white font-semibold">{{ $user->nama_pelanggan }}</div>
                <div class="text-center text-xs text-[#92CEE6]">Pelanggan</div>
            </div>
            <nav class="flex flex-col gap-4 flex-1">
                <a href="{{ route('dashboardmasyarakat') }}" class="text-white hover:text-[#92CEE6]">Dashboard</a>
                <a href="{{ route('cektagihan') }}" class="text-white hover:text-[#92CEE6]">Cek Tagihan</a>
                <a href="{{ route('pengaduanpelanggan') }}" class="text-white hover:text-[#92CEE6]">Pengaduan</a>
                <a href="#" class="text-white hover:text-[#92CEE6]">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-white hover:text-red-400 w-full text-left">Logout</button>
                </form>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 px-8 py-8">
            <h1 class="text-3xl font-bold mb-4">Dashboard Pelanggan</h1>
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-lg font-bold mb-2">Tanggal Jatuh Tempo Tagihan</h2>
                <p class="text-xl text-red-600 font-bold">{{ $jatuh_tempo }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-lg font-bold mb-2">Riwayat Pengaduan</h2>
                <table class="min-w-full border">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 border">Tanggal</th>
                            <th class="px-4 py-2 border">Isi Pengaduan</th>
                            <th class="px-4 py-2 border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat_pengaduan as $p)
                        <tr>
                            <td class="px-4 py-2 border">{{ $p->created_at->format('d-m-Y') }}</td>
                            <td class="px-4 py-2 border">{{ $p->isi_pengaduan }}</td>
                            <td class="px-4 py-2 border">{{ $p->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-bold mb-2">Grafik Pengaduan per Bulan</h2>
                <canvas id="grafikPengaduan" height="100"></canvas>
            </div>
        </main>
    </div>
    <script>
        const ctx = document.getElementById('grafikPengaduan').getContext('2d');
        const data = {
            labels: {!! json_encode($grafik_pengaduan->map(fn($g) => $g->bulan . '-' . $g->tahun)) !!},
            datasets: [{
                label: 'Jumlah Pengaduan',
                data: {!! json_encode($grafik_pengaduan->map(fn($g) => $g->total)) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2
            }]
        };
        new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</body>
</html>