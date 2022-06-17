<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\{ User, Loan };
use DateTime;

class LoanTakenInMailable extends Mailable
{
    use Queueable, SerializesModels;

    protected User $intaker;
    protected Loan $loan;
    protected DateTime $datetime;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $intaker, Loan $loan, DateTime $time)
    {
        $this->subject("Loan taken in");

        $this->intaker = $intaker;
        $this->loan = $loan;
        $this->datetime = $time;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dateDifference = $this->datetime->diff($this->loan->loaning_end->toDateTime());

        // get the individual parts of the date difference
        $seconds = intval( $dateDifference->format("%s") );
        $minutes = intval( $dateDifference->format("%i") );
        $hours = intval( $dateDifference->format("%h") );
        $days = intval( $dateDifference->format("%d") );
        $months = intval( $dateDifference->format("%m") );
        $years = intval( $dateDifference->format("%y") );

        $diffText = "";

        // show the biggest difference
        if (abs($years) > 0) $diffText = __(":years year(s)", ["years" => $years]);
        else if (abs($months) > 0) $diffText = __(":months month(s)", ["months" => $months]);
        else if (abs($days) > 0) $diffText = __(":days day(s)", ["days" => $days]);
        else if (abs($hours) > 0) $diffText = __(":hours hour(s)", ["hours" => $hours]);
        else if (abs($minutes) > 0) $diffText = __(":minutes minute(s)", ["minutes" => $minutes]);
        else $diffText = __(":seconds second(s)", ["seconds" => $seconds]);

        return $this->markdown('mail.loan.taken-in', [
            "closer" => $this->intaker->getFullName(),
            "time" => date_format($this->datetime, "G:s"),
            "date" => date_format($this->datetime, "j F"),

            "dateDiff" => $diffText,
            "isLate" => 0 < intval( $dateDifference->format("%r%f") ),

            // TODO make it so that loans can have multiple articles
            "item" => $this->loan->article->name,
            "itemCount" => $this->loan->amount
        ]);
    }
}
