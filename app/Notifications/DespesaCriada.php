<?php

namespace App\Notifications;

use App\Models\Despesa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DespesaCriada extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Despesa $despesa)
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
        return (new MailMessage)
                    ->line('Foi criada uma nova despesa.')
                    ->line("Dono: {$this->despesa->dono()->first()->name}")
                    ->line("Data: {$this->despesa->data}")
                    ->line("Valor: {$this->despesa->valor}")
                    ->line("Descrição:  {$this->despesa->descricao}");
    }
}
