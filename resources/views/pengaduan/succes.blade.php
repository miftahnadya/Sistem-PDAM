<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Berhasil Dikirim - PDAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pdam-dark': '#005792',
                        'pdam-blue': '#53CDE2',
                        'pdam-light': '#D1F4FA',
                        'pdam-lightest': '#EDF9FC'
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .bounce-in { animation: bounceIn 0.6s ease-out; }
        .fade-in-up { animation: fadeInUp 0.8s ease-out; }
        
        .success-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 20px 40px rgba(0, 87, 146, 0.1);
        }
        
        .ticket-highlight {
            background: linear-gradient(135deg, #EDF9FC 0%, #D1F4FA 100%);
            border: 2px solid #53CDE2;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #005792 0%, #53CDE2 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 87, 146, 0.3);
        }
        
        .btn-secondary {
            border: 2px solid #D1F4FA;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: #EDF9FC;
            border-color: #53CDE2;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-pdam-lightest to-pdam-light min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="success-card rounded-3xl p-8 max-w-lg w-full text-center fade-in-up">
            <!-- Success Icon -->
            <div class="w-24 h-24 bg-green-100 rounded-full mx-auto mb-6 flex items-center justify-center bounce-in">
                <i class="fas fa-check-circle text-green-600 text-4xl"></i>
            </div>
            
            <!-- Main Title -->
            <h1 class="text-3xl font-bold text-pdam-dark mb-4">
                Pengaduan Berhasil Dikirim!
            </h1>
            
            <p class="text-gray-600 mb-6">
                Terima kasih telah mempercayai layanan PDAM. Pengaduan Anda telah diterima dan akan segera ditindaklanjuti.
            </p>
            
            <!-- Ticket Number Card -->
            <div class="ticket-highlight rounded-2xl p-6 mb-6">
                <div class="flex items-center justify-center mb-3">
                    <i class="fas fa-ticket-alt text-pdam-blue text-2xl mr-3"></i>
                    <span class="text-sm font-medium text-pdam-dark">Nomor Tiket Anda</span>
                </div>
                <p class="text-3xl font-bold text-pdam-dark mb-2">{{ $pengaduan->ticket_number }}</p>
                <p class="text-xs text-gray-500">Simpan nomor tiket ini untuk melacak status pengaduan</p>
            </div>
            
            <!-- Information Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <!-- Processing Time -->
                <div class="bg-blue-50 rounded-xl p-4">
                    <i class="fas fa-clock text-blue-600 text-xl mb-2"></i>
                    <p class="text-sm font-medium text-blue-800">Waktu Proses</p>
                    <p class="text-xs text-blue-600">1x24 Jam Kerja</p>
                </div>
                
                <!-- Status -->
                <div class="bg-yellow-50 rounded-xl p-4">
                    <i class="fas fa-hourglass-start text-yellow-600 text-xl mb-2"></i>
                    <p class="text-sm font-medium text-yellow-800">Status Saat Ini</p>
                    <p class="text-xs text-yellow-600">Pending</p>
                </div>
            </div>
            
            <!-- Next Steps Info -->
            <div class="bg-gray-50 rounded-xl p-6 mb-8">
                <h4 class="font-bold text-gray-800 mb-3 flex items-center justify-center">
                    <i class="fas fa-info-circle text-pdam-blue mr-2"></i>
                    Langkah Selanjutnya
                </h4>
                <ul class="text-sm text-gray-600 space-y-2 text-left">
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                        Tim PDAM akan meninjau pengaduan Anda
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-phone text-blue-500 mr-2 mt-1"></i>
                        Petugas akan menghubungi Anda via HP: {{ $pengaduan->no_hp }}
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-tools text-orange-500 mr-2 mt-1"></i>
                        Tindak lanjut sesuai kategori: {{ ucfirst(str_replace('_', ' ', $pengaduan->kategori)) }}
                    </li>
                </ul>
            </div>
            
            <!-- Action Buttons -->
            <div class="space-y-4">
                <button onclick="copyTicketNumber()" 
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-xl transition-colors flex items-center justify-center">
                    <i class="fas fa-copy mr-2"></i>
                    Salin Nomor Tiket
                </button>
                
                <a href="{{ route('pengaduan.track') }}" 
                   class="w-full btn-primary text-white py-3 px-6 rounded-xl transition-all block">
                    <i class="fas fa-search mr-2"></i>
                    Lacak Status Pengaduan
                </a>
                
                <a href="{{ route('dashboardmasyarakat') }}" 
                   class="w-full btn-secondary text-pdam-dark hover:text-pdam-dark py-3 px-6 rounded-xl transition-all block">
                    <i class="fas fa-home mr-2"></i>
                    Kembali ke Dashboard
                </a>
                
                <a href="{{ route('pengaduanpelanggan') }}" 
                   class="w-full text-gray-500 hover:text-gray-700 py-2 px-6 rounded-xl transition-colors block text-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Pengaduan Baru
                </a>
            </div>
            
            <!-- Contact Info -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-xs text-gray-500 mb-2">Butuh bantuan lebih lanjut?</p>
                <p class="text-sm text-pdam-dark font-medium">
                    <i class="fas fa-phone mr-1"></i>
                    Hubungi: (021) 123-4567
                </p>
            </div>
        </div>
    </div>

    <script>
        function copyTicketNumber() {
            const ticketNumber = "{{ $pengaduan->ticket_number }}";
            navigator.clipboard.writeText(ticketNumber).then(function() {
                // Show success message
                showNotification('Nomor tiket berhasil disalin!', 'success');
            }, function(err) {
                // Fallback for older browsers
                const textArea = document.createElement("textarea");
                textArea.value = ticketNumber;
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    showNotification('Nomor tiket berhasil disalin!', 'success');
                } catch (err) {
                    showNotification('Gagal menyalin nomor tiket', 'error');
                }
                document.body.removeChild(textArea);
            });
        }

        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white font-medium transition-all transform translate-x-full ${
                type === 'success' ? 'bg-green-600' : 'bg-red-600'
            }`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check' : 'times'} mr-2"></i>
                ${message}
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Animate out and remove
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Auto redirect after 30 seconds (optional)
        setTimeout(() => {
            if (confirm('Apakah Anda ingin diarahkan ke halaman pelacakan pengaduan?')) {
                window.location.href = "{{ route('pengaduan.track') }}";
            }
        }, 30000);
    </script>
</body>
</html>