<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twilio\Rest\Client;

class CheckTwilioStatus extends Command
{
    protected $signature = 'twilio:status {message_sid?}';
    protected $description = 'Check Twilio message status';

    public function handle()
    {
        $messageSid = $this->argument('message_sid');
        
        try {
            $twilio = new Client(
                config('services.twilio.sid'),
                config('services.twilio.auth_token')
            );
            
            if ($messageSid) {
                // Check specific message
                $message = $twilio->messages($messageSid)->fetch();
                
                $this->info("Message Details:");
                $this->info("SID: " . $message->sid);
                $this->info("Status: " . $message->status);
                $this->info("Error Code: " . ($message->errorCode ?? 'None'));
                $this->info("Error Message: " . ($message->errorMessage ?? 'None'));
                $this->info("To: " . $message->to);
                $this->info("From: " . $message->from);
                $this->info("Body: " . $message->body);
            } else {
                // Get recent messages
                $messages = $twilio->messages->read([
                    'limit' => 5
                ]);
                
                $this->info("Recent Messages:");
                foreach ($messages as $message) {
                    $this->info("---");
                    $this->info("SID: " . $message->sid);
                    $this->info("To: " . $message->to);
                    $this->info("Status: " . $message->status);
                    $this->info("Error: " . ($message->errorCode ?? 'None'));
                    $this->info("Date: " . $message->dateSent->format('Y-m-d H:i:s'));
                }
            }
            
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
