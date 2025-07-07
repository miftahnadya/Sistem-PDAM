<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $twilio;
    protected $from;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.auth_token')
        );
        $this->from = config('services.twilio.whatsapp_from');
    }

    /**
     * Send WhatsApp message
     *
     * @param string $to
     * @param string $message
     * @return bool
     */
    public function sendMessage($to, $message)
    {
        try {
            // Format nomor telepon untuk WhatsApp
            $originalNumber = $to;
            $to = $this->formatPhoneNumber($to);
            
            Log::info('Attempting to send WhatsApp message', [
                'original_number' => $originalNumber,
                'formatted_number' => $to,
                'message_preview' => substr($message, 0, 50) . '...'
            ]);
            
            $twilioMessage = $this->twilio->messages->create(
                "whatsapp:{$to}",
                [
                    'from' => $this->from,
                    'body' => $message
                ]
            );

            Log::info('WhatsApp message sent successfully', [
                'to' => $to,
                'message_sid' => $twilioMessage->sid,
                'status' => $twilioMessage->status,
                'direction' => $twilioMessage->direction
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp message', [
                'original_number' => $originalNumber ?? $to,
                'formatted_number' => $to,
                'error' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return false;
        }
    }

    /**
     * Send pengaduan confirmation to customer
     *
     * @param string $phoneNumber
     * @param string $ticketNumber
     * @param string $customerName
     * @return bool
     */
    public function sendPengaduanConfirmation($phoneNumber, $ticketNumber, $customerName)
    {
        $message = "Halo {$customerName},\n\n";
        $message .= "Terima kasih telah mengirimkan pengaduan Anda.\n\n";
        $message .= "📋 *Detail Pengaduan:*\n";
        $message .= "• Nomor Tiket: {$ticketNumber}\n";
        $message .= "• Status: Sedang Diproses\n";
        $message .= "• Tanggal: " . now()->format('d/m/Y H:i') . "\n\n";
        $message .= "Pengaduan Anda sedang kami proses. Kami akan menghubungi Anda segera untuk tindak lanjut.\n\n";
        $message .= "Untuk melacak status pengaduan, gunakan nomor tiket di atas.\n\n";
        $message .= "Terima kasih,\n";
        $message .= "*Tim Customer Service PDAM*";

        return $this->sendMessage($phoneNumber, $message);
    }

    /**
     * Send status update to customer
     *
     * @param string $phoneNumber
     * @param string $ticketNumber
     * @param string $status
     * @param string $notes
     * @return bool
     */
    public function sendStatusUpdate($phoneNumber, $ticketNumber, $status, $notes = '')
    {
        $statusText = $this->getStatusText($status);
        
        $message = "📢 *Update Status Pengaduan*\n\n";
        $message .= "Nomor Tiket: {$ticketNumber}\n";
        $message .= "Status Baru: {$statusText}\n";
        $message .= "Waktu Update: " . now()->format('d/m/Y H:i') . "\n\n";
        
        if ($notes) {
            $message .= "📝 *Catatan:*\n{$notes}\n\n";
        }
        
        $message .= "Terima kasih atas kesabaran Anda.\n\n";
        $message .= "*Tim Customer Service PDAM*";

        return $this->sendMessage($phoneNumber, $message);
    }

    /**
     * Send notification to admin
     *
     * @param string $adminPhoneNumber
     * @param string $ticketNumber
     * @param string $category
     * @param string $customerName
     * @return bool
     */
    public function sendAdminNotification($adminPhoneNumber, $ticketNumber, $category, $customerName)
    {
        $message = "🚨 *Pengaduan Baru Diterima*\n\n";
        $message .= "📋 *Detail:*\n";
        $message .= "• Tiket: {$ticketNumber}\n";
        $message .= "• Kategori: " . ucfirst(str_replace('_', ' ', $category)) . "\n";
        $message .= "• Nama Pelanggan: {$customerName}\n";
        $message .= "• Waktu: " . now()->format('d/m/Y H:i') . "\n\n";
        $message .= "Silakan login ke sistem untuk melihat detail lengkap.\n\n";
        $message .= "*Sistem PDAM*";

        return $this->sendMessage($adminPhoneNumber, $message);
    }

    /**
     * Format phone number for WhatsApp
     *
     * @param string $phoneNumber
     * @return string
     */
    private function formatPhoneNumber($phoneNumber)
    {
        // Remove all non-numeric characters except +
        $phoneNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);
        
        // If already starts with +62, return as is
        if (substr($phoneNumber, 0, 3) === '+62') {
            return $phoneNumber;
        }
        
        // If starts with 62 (without +), add +
        if (substr($phoneNumber, 0, 2) === '62') {
            return '+' . $phoneNumber;
        }
        
        // If starts with 0, replace with +62
        if (substr($phoneNumber, 0, 1) === '0') {
            return '+62' . substr($phoneNumber, 1);
        }
        
        // If starts with 8 (Indonesian mobile), add +62
        if (substr($phoneNumber, 0, 1) === '8') {
            return '+62' . $phoneNumber;
        }
        
        // Default: add +62
        return '+62' . $phoneNumber;
    }

    /**
     * Get status text in Indonesian
     *
     * @param string $status
     * @return string
     */
    private function getStatusText($status)
    {
        $statusMap = [
            'pending' => '⏳ Menunggu Diproses',
            'in_progress' => '🔄 Sedang Diproses',
            'resolved' => '✅ Selesai',
            'closed' => '🔒 Ditutup',
            'rejected' => '❌ Ditolak'
        ];

        return $statusMap[$status] ?? $status;
    }
}
