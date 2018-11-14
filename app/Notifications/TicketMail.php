<?php

namespace App\Notifications;

use App\Mail\TicketMail as Mailable;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TicketMail extends Notification
{
    use Queueable;
    /**
     * @var string
     */
    private $message;
    /**
     * @var Ticket
     */
    private $ticketId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $message, $ticketId)
    {
        //
        $this->message = $message;
        $this->ticketId = $ticketId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->from('helpdesk@bioclin.com.br', 'HelpDesk')
            ->subject('E-mail enviado pelo SIRSOL')
            ->line($this->message)
            ->action('Acompanhar', url('http://172.16.101.30:3000/bioclin/timeline/' . $this->ticketId ));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'user_name' => $notifiable->name,
            'ticket_id' => $this->ticketId
        ];
    }
}
