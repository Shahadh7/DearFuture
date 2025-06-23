<?php

namespace App\Notifications;

use App\Models\Capsule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CapsuleDelivered extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public int $capsuleId,
        public ?string $deliveryToken = null
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Fetch the capsule from the database
        $capsule = Capsule::find($this->capsuleId);
        
        // If capsule doesn't exist, send a generic message
        if (!$capsule) {
            return (new MailMessage)
                ->subject("🎁 Time Capsule Notification")
                ->greeting("Hello!")
                ->line("A time capsule was ready for you, but it seems to have been removed.")
                ->line("Thank you for being part of the DearFuture community!")
                ->salutation("With warm regards,\nThe DearFuture Team");
        }
        
        $unlockDate = $capsule->unlock_date ? date('F j, Y \a\t g:i A', strtotime($capsule->unlock_date)) : 'now';
        
        // Use the delivery token from constructor if available, otherwise try to get it from the capsule
        $token = $this->deliveryToken ?? $capsule->delivery_token;
        
        // If we still don't have a token, generate a fallback message
        if (!$token) {
            return (new MailMessage)
                ->subject("🎁 Your Time Capsule is Ready! - {$capsule->title}")
                ->greeting("Hello!")
                ->line("A special time capsule has been unlocked just for you!")
                ->line("**Capsule Title:** {$capsule->title}")
                ->line("**Unlocked:** {$unlockDate}")
                ->line("Please visit your dashboard to view this capsule.")
                ->line("This capsule contains a message from the past, waiting to be discovered by you in this moment.")
                ->line("Thank you for being part of the DearFuture community!")
                ->salutation("With warm regards,\nThe DearFuture Team");
        }
        
        // Generate unlock link using the delivery_token
        $unlockLink = route('capsules.unlock', ['token' => $token]);

        
        return (new MailMessage)
                    ->subject("🎁 Your Time Capsule is Ready! - {$capsule->title}")
                    ->greeting("Hello!")
                    ->line("A special time capsule has been unlocked just for you!")
                    ->line("**Capsule Title:** {$capsule->title}")
                    ->line("**Unlocked:** {$unlockDate}")
                    ->action('Open Your Capsule', $unlockLink)
                    ->line("This capsule contains a message from the past, waiting to be discovered by you in this moment.")
                    ->line("Thank you for being part of the DearFuture community!")
                    ->salutation("With warm regards,\nThe DearFuture Team");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $capsule = Capsule::find($this->capsuleId);
        
        return [
            'capsule_id' => $this->capsuleId,
            'capsule_title' => $capsule ? $capsule->title : 'Unknown',
            'unlock_date' => $capsule ? $capsule->unlock_date : null,
        ];
    }
} 