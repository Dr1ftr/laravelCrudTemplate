<?php

namespace App\Http\Controllers;

use App\Mail\{ LoanRequestAcceptedMailable, LoanRequestRejectedMailable };
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RequestLoan;
use App\Models\Loan;
use Illuminate\Support\Facades\Mail;

class RequestLoanController extends Controller
{
    public function getRequests()
    {
        $requestLoanTable = (new RequestLoan)->getTable();
        $userTable = (new User())->getTable();

        $requests = RequestLoan::select("$requestLoanTable.id as requestId", "$requestLoanTable.*", "$userTable.*")
            ->leftJoin("$userTable", "$userTable.id", '=', "$requestLoanTable.user_id")
            ->paginate(7);

        // dd($requests);
        return view('overview-request', ['requests' => $requests]);
    }

    public function acceptRequest(Request $request, RequestLoan $loanRequest)
    {
        $now = now(); // call once to avoid multiple calls to now() (because it's slow)

        // convert request to actual loan
        $loan = Loan::create([
            'user_id' => $loanRequest->user_id,
            'article_id' => $loanRequest->article_id,
            'amount' => $loanRequest->amount,
            'loaning_start' => $loanRequest->loaning_start,
            'loaning_end' => $loanRequest->loaning_end,

            Loan::CREATED_AT => $now,
            Loan::UPDATED_AT => $now
        ]);

        // delete the request (it has been replaced with the loan)
        $loanRequest->delete();

        // send mail to user to tell them that their loan has been accepted
        Mail::to($loan->user->email)->queue(
            new LoanRequestAcceptedMailable(
                $request->user(), // user that accepted the request
                $loan
            )
        );

        return redirect()->route("request.view")->with("msg", __("Succesfully accepted the request."));
    }

    public function rejectRequest(RequestLoan $loanRequest)
    {
        // send mail to user to tell them that their loan has been accepted
        Mail::to($loanRequest->user->email)->queue(
            new LoanRequestRejectedMailable(
                $loanRequest
            )
        );

        // delete after sending the mail, because it's used in the mail's content
        $loanRequest->delete();

        return redirect()->route("request.view")->with("msg", __("Succesfully rejected the request."));
    }
}
