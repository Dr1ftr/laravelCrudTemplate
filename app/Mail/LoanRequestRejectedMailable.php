<?php

namespace App\Mail;

use App\Models\RequestLoan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoanRequestRejectedMailable extends Mailable
{
    use Queueable, SerializesModels;

    protected RequestLoan $rejectedRequest;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(RequestLoan $rejectedRequest)
    {
        $this->subject("Loan request rejected");

        $this->rejectedRequest = $rejectedRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.loan.request-rejected', [
            "startTime" => date_format( $this->rejectedRequest->loaning_start, "G:s" ),
            "startDate" => date_format( $this->rejectedRequest->loaning_start, "j F" ),

            "endTime" => date_format( $this->rejectedRequest->loaning_end, "G:s" ),
            "endDate" => date_format( $this->rejectedRequest->loaning_end, "j F" ),

            // TODO make it so that loans can have multiple articles
            "item" => $this->rejectedRequest->article->name,
            "itemCount" => $this->rejectedRequest->amount,
        ]);
    }
}
