# Panduan Integrasi WhatsApp dengan Twilio

## Setup dan Konfigurasi

### 1. Mendapatkan Kredensial Twilio

1. **Daftar/Login ke Twilio**

    - Kunjungi https://www.twilio.com/
    - Daftar akun baru atau login dengan akun yang sudah ada

2. **Ambil Kredensial**

    - Buka Twilio Console
    - Catat `Account SID` dan `Auth Token` dari dashboard

3. **Setup WhatsApp Sandbox (untuk testing)**
    - Buka Twilio Console > Messaging > WhatsApp
    - Ikuti instruksi untuk join WhatsApp Sandbox
    - Catat nomor sandbox WhatsApp (`whatsapp:+14155238886`)

### 2. Konfigurasi Environment

Update file `.env` dengan kredensial Twilio:

```env
# Twilio Configuration
TWILIO_SID=your_actual_account_sid
TWILIO_AUTH_TOKEN=your_actual_auth_token
TWILIO_WHATSAPP_FROM=whatsapp:+14155238886

# Admin WhatsApp untuk notifikasi (format: +62xxxxxxxxxx)
ADMIN_WHATSAPP_NUMBER=+6281234567890
```

### 3. Testing WhatsApp Sandbox

Sebelum production, test dengan sandbox:

1. Kirim pesan "join <sandbox-keyword>" ke nomor sandbox
2. Contoh: "join your-sandbox-keyword" ke +1 415 523 8886
3. Tunggu konfirmasi dari Twilio

## Fitur yang Tersedia

### 1. Notifikasi untuk Pelanggan

Ketika pelanggan mengirim pengaduan, mereka akan menerima:

-   ✅ Konfirmasi pengaduan diterima
-   📋 Nomor tiket pengaduan
-   📱 Update status secara real-time

**Contoh pesan:**

```
Halo John Doe,

Terima kasih telah mengirimkan pengaduan Anda.

📋 Detail Pengaduan:
• Nomor Tiket: PDAM202507081001
• Status: Sedang Diproses
• Tanggal: 08/07/2025 14:30

Pengaduan Anda sedang kami proses. Kami akan menghubungi Anda segera untuk tindak lanjut.

Terima kasih,
Tim Customer Service PDAM
```

### 2. Notifikasi untuk Admin

Admin akan menerima notifikasi untuk setiap pengaduan baru:

-   🚨 Alert pengaduan baru
-   📋 Detail singkat pengaduan
-   ⏰ Timestamp pengaduan

**Contoh pesan:**

```
🚨 Pengaduan Baru Diterima

📋 Detail:
• Tiket: PDAM202507081001
• Kategori: Kualitas Air
• Nama Pelanggan: John Doe
• Waktu: 08/07/2025 14:30

Silakan login ke sistem untuk melihat detail lengkap.

Sistem PDAM
```

### 3. Update Status

Ketika status pengaduan diubah, pelanggan akan mendapat notifikasi:

**Contoh pesan:**

```
📢 Update Status Pengaduan

Nomor Tiket: PDAM202507081001
Status Baru: ✅ Selesai
Waktu Update: 08/07/2025 16:45

📝 Catatan:
Masalah pipa bocor telah diperbaiki oleh tim teknis kami.

Terima kasih atas kesabaran Anda.

Tim Customer Service PDAM
```

## Penggunaan dalam Kode

### 1. Mengirim Konfirmasi Pengaduan

```php
// Dalam PengaduanController@store
$this->whatsAppService->sendPengaduanConfirmation(
    $request->no_hp,           // Nomor HP pelanggan
    $pengaduan->ticket_number, // Nomor tiket
    $request->nama_pelanggan   // Nama pelanggan
);
```

### 2. Update Status Pengaduan

```php
// API endpoint: PUT /pengaduan/{id}/status
// Body: {"status": "resolved", "notes": "Masalah telah diselesaikan"}

$this->whatsAppService->sendStatusUpdate(
    $pengaduan->no_hp,           // Nomor HP
    $pengaduan->ticket_number,   // Nomor tiket
    $request->status,            // Status baru
    $request->notes              // Catatan (opsional)
);
```

### 3. Notifikasi Admin

```php
$this->whatsAppService->sendAdminNotification(
    $adminPhone,                 // Nomor HP admin
    $pengaduan->ticket_number,   // Nomor tiket
    $request->kategori,          // Kategori pengaduan
    $request->nama_pelanggan     // Nama pelanggan
);
```

## Format Nomor Telepon

Service akan otomatis memformat nomor telepon:

-   Input: `081234567890` → Output: `+6281234567890`
-   Input: `0812-3456-7890` → Output: `+6281234567890`
-   Input: `+6281234567890` → Output: `+6281234567890` (tidak berubah)

## Status Pengaduan

Mapping status dalam bahasa Indonesia:

-   `pending` → ⏳ Menunggu Diproses
-   `in_progress` → 🔄 Sedang Diproses
-   `resolved` → ✅ Selesai
-   `closed` → 🔒 Ditutup
-   `rejected` → ❌ Ditolak

## Error Handling

Sistem akan:

1. ✅ Tetap menyimpan pengaduan meski WhatsApp gagal
2. 📝 Log semua error ke Laravel log
3. 🔄 Tidak menginterupsi proses utama

## Production Setup

### 1. WhatsApp Business API

Untuk production, gunakan WhatsApp Business API:

1. Daftar WhatsApp Business API di Twilio
2. Verifikasi nomor bisnis
3. Setup template pesan yang disetujui WhatsApp

### 2. Template Messages

Buat template pesan yang disetujui WhatsApp:

-   Template konfirmasi pengaduan
-   Template update status
-   Template notifikasi admin

### 3. Monitoring

Monitor penggunaan:

-   Cek Twilio Console untuk statistik pengiriman
-   Monitor Laravel logs untuk error
-   Setup alert untuk kegagalan pengiriman

## Tips Penggunaan

1. **Testing**: Selalu test di sandbox sebelum production
2. **Rate Limiting**: Waspadai rate limit Twilio (1 pesan/detik untuk sandbox)
3. **Template**: Gunakan template yang disetujui untuk production
4. **Error Handling**: Selalu handle exception untuk WhatsApp service
5. **Logging**: Monitor logs untuk debug masalah
6. **Format Nomor**: Pastikan format nomor HP konsisten (+62...)

## Troubleshooting

### Pesan tidak terkirim

1. Cek kredensial Twilio di `.env`
2. Pastikan nomor sudah join sandbox (untuk testing)
3. Cek Laravel logs untuk error detail
4. Verifikasi format nomor telepon

### Error "Invalid phone number"

1. Pastikan nomor dalam format internasional (+62...)
2. Cek apakah nomor sudah join WhatsApp sandbox
3. Verifikasi nomor aktif dan bisa menerima WhatsApp

### Error "Authentication failed"

1. Cek `TWILIO_SID` dan `TWILIO_AUTH_TOKEN`
2. Pastikan kredensial valid dan aktif
3. Cek apakah akun Twilio dalam status good standing
