<?php

namespace App\Mail;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoanRequestAcceptedMailable extends Mailable
{
    use Queueable, SerializesModels;

    protected User $accepter;
    protected Loan $loan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $accepter, Loan $acceptedLoan)
    {
        $this->subject("Loan request accepted");

        $this->accepter = $accepter;
        $this->loan = $acceptedLoan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.loan.request-accepted', [
            "accepter" => $this->accepter->getFullName(),

            "startTime" => date_format( $this->loan->loaning_start, "G:s" ),
            "startDate" => date_format( $this->loan->loaning_start, "j F" ),

            "endTime" => date_format( $this->loan->loaning_end, "G:s" ),
            "endDate" => date_format( $this->loan->loaning_end, "j F" ),

            // TODO make it so that loans can have multiple articles
            "item" => $this->loan->article->name,
            "itemCount" => $this->loan->amount,
        ]);
    }
}
