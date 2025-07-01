<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Tanggapan Pengaduan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <div class="w-60 bg-[#142938] flex flex-col items-center py-8 min-h-screen" style="background-color: #142938;">
        <!-- Avatar -->
        <div class="flex flex-col items-center mb-6">
            <div class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center text-3xl font-bold text-black mb-2">
                A
            </div>
            <div class="text-white font-semibold text-lg">Admin</div>
            <div class="text-blue-300 text-sm">Admin</div>
        </div>
        <!-- Menu -->
        <nav class="flex flex-col gap-2 w-full px-6">
            <a href="dashboard" class="flex items-center gap-3 text-white py-2 rounded hover:bg-[#22384a] transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="isitagihan" class="flex items-center gap-3 text-white py-2 rounded hover:bg-[#22384a] transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 17v-2a4 4 0 014-4h3m4 0a4 4 0 00-4-4H7a4 4 0 00-4 4v6a4 4 0 004 4h6"></path></svg>
                Cek Tagihan
            </a>
            <a href="Tanggapipengaduan" class="flex items-center gap-3 text-white py-2 rounded hover:bg-[#22384a] transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"></path><path d="M12 4v16m0 0H3"></path></svg>
                Pengaduan
            </a>
            <a href="Datapelanggan" class="flex items-center gap-3 text-white py-2 rounded hover:bg-[#22384a] transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"></circle><path d="M5.5 21a7.5 7.5 0 0113 0"></path></svg>
                Data Pelanggan
            </a>
            <a href="login" class="flex items-center gap-3 text-white py-2 rounded hover:bg-[#22384a] transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7"></path><path d="M3 12a9 9 0 0118 0 9 9 0 01-18 0z"></path></svg>
                Logout
            </a>
        </nav>
    </div>
    <div class="flex-1 flex flex-col md:flex-row gap-4 p-4 bg-gray-100">
        <div class="w-full md:w-1/3 bg-white rounded-xl shadow p-4 overflow-y-auto max-h-[80vh]">
            <div class="font-bold text-lg mb-2">DATA PENGADUAN</div>
            <div class="mb-4 p-3 rounded-lg" style="background-color: #1e3a8a;">
                <div class="text-white font-semibold text-base mb-1">Data Pelanggan</div>
                @if($selected)
                    <div class="text-white text-sm">
                        <div><span class="font-semibold">ID Pelanggan:</span> {{ $selected->id_pelanggan }}</div>
                        <div><span class="font-semibold">Nama:</span> {{ $selected->nama_pelapor }}</div>
                        <div><span class="font-semibold">Alamat:</span> {{ $selected->alamat }}</div>
                        <div><span class="font-semibold">No. Telp:</span> {{ $selected->no_telp }}</div>
                    </div>
                @else
                    <div class="text-blue-100 text-sm">Pilih pengaduan untuk melihat data pelanggan.</div>
                @endif
            </div>
            <table class="min-w-full text-xs">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-1 pr-2 w-6">Id</th>
                        <th class="py-1 pr-2">No. Tiket</th>
                        <th class="py-1 pr-2">Nama Pelapor</th>
                        <th class="py-1">Jenis</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-blue-50 cursor-pointer bg-blue-100 font-bold">
                        <td class="py-1 pr-2 text-green-600 font-bold">67890</td>
                        <td class="py-1 pr-2">251234</td>
                        <td class="py-1 pr-2">Nadya</td>
                        <td class="py-1 text-purple-700">TEKNIS</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Detail Pengaduan -->
        <div class="w-full md:w-2/3 bg-white rounded-xl shadow p-4 flex flex-col gap-4">
            @if($selected)
            <div>
                <div class="flex justify-between items-center mb-2">
                    <div class="font-bold text-lg">NO. TIKET {{ $selected->no_tiket }}</div>
                    <div class="flex gap-2">
                        <span class="px-2 py-1 bg-gray-200 rounded text-xs">Belum proses</span>
                        <span class="px-2 py-1 bg-blue-200 rounded text-xs">Sudah cek &amp; belum verifikasi</span>
                        <span class="px-2 py-1 bg-green-200 rounded text-xs">Terverifikasi</span>
                        <span class="px-2 py-1 bg-yellow-200 rounded text-xs">Ada RAB</span>
                        <span class="px-2 py-1 bg-red-200 rounded text-xs">Selesai</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                    <div><span class="font-semibold">ID Pelanggan:</span> {{ $selected->id_pelanggan }}</div>
                    <div><span class="font-semibold">Alamat:</span> {{ $selected->alamat }}</div>
                    <div><span class="font-semibold">Sumber Pengaduan:</span> {{ $selected->sumber_pengaduan }}</div>
                    <div><span class="font-semibold">Pengaduan Melalui:</span> {{ $selected->pengaduan_melalui }}</div>
                    <div><span class="font-semibold">No. Telp:</span> {{ $selected->no_telp }}</div>
                    <div><span class="font-semibold">Nomor:</span> {{ $selected->nomor }}</div>
                    <div><span class="font-semibold">Mulai Dikerjakan:</span> {{ $selected->mulai_dikerjakan }}</div>
                    <div><span class="font-semibold">Pernah Ditutup:</span> {{ $selected->pernah_ditutup }}</div>
                    <div><span class="font-semibold">Estimasi Penanganan:</span> {{ $selected->estimasi_penanganan }}</div>
                    <div><span class="font-semibold">RAB:</span> {{ $selected->rab }}</div>
                    <div><span class="font-semibold">Target Selesai:</span> {{ $selected->target_selesai }}</div>
                    <div><span class="font-semibold">Divisi:</span> {{ $selected->divisi }}</div>
                    <div><span class="font-semibold">Status Terakhir:</span> <span class="text-red-500 font-bold">{{ $selected->status_terakhir }}</span></div>
                    <div><span class="font-semibold">Petugas yang Menangani:</span> {{ $selected->petugas }}</div>
                </div>
            </div>
            <!-- Progress Penanganan -->
            <div>
                <div class="font-bold mb-1">PROGRES PENANGANAN</div>
                <table class="min-w-full text-xs border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-1 px-2 border">Status</th>
                            <th class="py-1 px-2 border">Tgl. Pengerjaan</th>
                            <th class="py-1 px-2 border">Gambar</th>
                            <th class="py-1 px-2 border">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($selected->progres as $progres)
                        <tr>
                            <td class="py-1 px-2 border">{{ $progres->status }}</td>
                            <td class="py-1 px-2 border">{{ $progres->tgl_pengerjaan }}</td>
                            <td class="py-1 px-2 border">
                                @if($progres->gambar)
                                    <img src="{{ asset('storage/'.$progres->gambar) }}" alt="Gambar" class="w-12 h-12 object-cover rounded">
                                @endif
                            </td>
                            <td class="py-1 px-2 border">{{ $progres->keterangan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-2 text-gray-400">Belum ada progres penanganan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @else
            <div class="flex flex-col items-center justify-center h-full text-gray-400">
                <span class="text-lg">Pilih salah satu data pengaduan.</span>
            </div>
            @endif
        </div>
    </div>
</div>
</body>
</html>