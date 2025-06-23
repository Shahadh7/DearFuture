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
    public function __construct(public Capsule $capsule)
    {
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
        $unlockDate = $this->capsule->unlock_date ? date('F j, Y \a\t g:i A', strtotime($this->capsule->unlock_date)) : 'now';
        
        return (new MailMessage)
                    ->subject("🎁 Your Time Capsule is Ready! - {$this->capsule->title}")
                    ->greeting("Hello!")
                    ->line("A special time capsule has been unlocked just for you!")
                    ->line("**Capsule Title:** {$this->capsule->title}")
                    ->line("**Unlocked:** {$unlockDate}")
                    ->action('Open Your Capsule', route('capsules.show', $this->capsule))
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
        return [
            'capsule_id' => $this->capsule->id,
            'capsule_title' => $this->capsule->title,
            'unlock_date' => $this->capsule->unlock_date,
        ];
    }
} 