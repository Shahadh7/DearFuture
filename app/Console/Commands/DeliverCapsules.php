<?php

namespace App\Console\Commands;

use App\Models\Capsule;
use App\Models\DeliveryLog;
use App\Notifications\CapsuleDelivered;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class DeliverCapsules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'capsules:deliver';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deliver due capsules to their recipients.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $capsules = Capsule::with('user')
            ->where('status', 'locked')
            ->where('unlock_date', '<=', now())
            ->get();

        $deliveredCount = 0;

        foreach ($capsules as $capsule) {
            try {
                // Generate delivery token for unlock link
                $capsule->generateDeliveryToken();
                
                // Refresh the capsule to get the updated delivery_token
                $capsule->refresh();
                
                // Send notification to the recipient if email is set, otherwise to the capsule owner
                if ($capsule->recipient_email) {
                    $user = \App\Models\User::where('email', $capsule->recipient_email)->first();
                    if ($user) {
                        $user->notify(new CapsuleDelivered($capsule->id, $capsule->delivery_token));
                    } else {
                        Notification::route('mail', $capsule->recipient_email)
                            ->notify(new CapsuleDelivered($capsule->id, $capsule->delivery_token));
                    }
                } else {
                    $capsule->user->notify(new CapsuleDelivered($capsule->id, $capsule->delivery_token));
                }
                
                // Mark capsule as delivered
                $capsule->markAsDelivered();
                
                // Log the delivery
                DeliveryLog::create([
                    'capsule_id' => $capsule->id,
                    'user_id' => $capsule->user_id,
                    'delivery_date' => now(),
                    'status' => 'delivered',
                    'notes' => 'Automatically delivered via cron job'
                ]);
                
                $deliveredCount++;
                $this->info("Delivered capsule #{$capsule->id} from {$capsule->user->name}");
            } catch (\Exception $e) {
                // Log failed delivery
                DeliveryLog::create([
                    'capsule_id' => $capsule->id,
                    'user_id' => $capsule->user_id,
                    'delivery_date' => now(),
                    'status' => 'failed',
                    'notes' => 'Delivery failed: ' . $e->getMessage()
                ]);
                
                $this->error("Failed to deliver capsule #{$capsule->id}: " . $e->getMessage());
            }
        }

        $this->info("Delivered {$deliveredCount} capsules.");
    }
} 