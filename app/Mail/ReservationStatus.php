<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $status;

    public function __construct($reservation, $status)
    {
        $this->reservation = $reservation;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject("Reservation {$this->status}")
                    ->view('emails.reservation-status')
                    ->with([
                        'hotel' => $this->reservation->listing->title ?? 'Unknown Hotel',
                        'checkIn' => $this->reservation->start_date->format('Y-m-d'),
                        'checkOut' => $this->reservation->end_date->format('Y-m-d'),
                        'status' => $this->status,
                    ]);
    }
}