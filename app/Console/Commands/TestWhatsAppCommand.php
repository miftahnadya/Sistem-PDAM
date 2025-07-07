<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;

class TestWhatsAppCommand extends Command
{
    protected $signature = 'whatsapp:test {phone} {--message=}';
    protected $description = 'Test WhatsApp integration';

    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        parent::__construct();
        $this->whatsAppService = $whatsAppService;
    }

    public function handle()
    {
        $phone = $this->argument('phone');
        $message = $this->option('message') ?: 'Test message dari sistem PDAM';

        $this->info("Mengirim pesan WhatsApp ke: {$phone}");
        
        $result = $this->whatsAppService->sendMessage($phone, $message);
        
        if ($result) {
            $this->info('✅ Pesan berhasil dikirim!');
        } else {
            $this->error('❌ Gagal mengirim pesan. Cek log untuk detail error.');
        }
    }
}
