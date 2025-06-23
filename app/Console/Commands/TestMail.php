<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\CapsuleDelivered;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the email functionality by sending a test notification';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        if (!$email) {
            $email = $this->ask('Enter the email address to send the test to:');
        }

        // Create a mock capsule for testing
        $capsule = new \App\Models\Capsule([
            'title' => 'Test Time Capsule',
            'message' => 'This is a test message from the past!',
            'unlock_date' => now(),
            'status' => 'delivered',
        ]);

        try {
            // Send test notification
            Notification::route('mail', $email)
                ->notify(new CapsuleDelivered($capsule));

            $this->info("✅ Test email sent successfully to: {$email}");
            $this->info("📧 Check your email (and spam folder) for the test message.");
            
        } catch (\Exception $e) {
            $this->error("❌ Failed to send email: " . $e->getMessage());
            $this->info("💡 Make sure your mail configuration is correct in .env file");
        }
    }
} 