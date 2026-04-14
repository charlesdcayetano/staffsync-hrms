<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LeaveStatusUpdated extends Notification
{
    use Queueable;

    protected $leave;

    public function __construct($leave)
    {
        $this->leave = $leave;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database']; // Sends an email AND saves to DB
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Leave Request Update - NexusHR')
            ->line("Your leave request for {$this->leave->leavePlan->plan_name} has been {$this->leave->status}.")
            ->line("HR Remarks: " . ($this->leave->hr_remarks ?? 'None'))
            ->action('View Details', url('/leaves'))
            ->line('Thank you for using NexusHR.');
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "Your leave request was {$this->leave->status}.",
            'leave_id' => $this->leave->id,
        ];
    }
}