<?php

namespace App\Http\Controllers;
use App\Models\Loan;
use App\Models\User;
use App\Mail\LoanTakenInMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LoanController extends Controller
{
    public function getLoans()
    {
        $loanTable = (new Loan())->getTable();
        $userTable = (new User())->getTable();

        $requests = Loan::select("$loanTable.id as loanId", "$loanTable.*", "$userTable.*")
            ->leftJoin("$userTable", "$userTable.id", '=', "$loanTable.user_id")
            ->where('returned_at', null) // only show loans that haven't been returned yet
            ->paginate(7);

        return view('overview-loan',['requests' => $requests]);
    }

    public function takeInLoan(Request $request, Loan $loan)
    {
        $now = now();

        $loan->returned_at = $now;

        $loan->save();

        // send mail to user to tell them that the loan has been closed
        Mail::to($loan->user->email)->queue(
            new LoanTakenInMailable(
                $request->user(), // user that took in the loan
                $loan, // the loan
                $now->toDateTime() // when the loan was taken in
            )
        );

        return redirect()->route("overview-loan")->with("msg", __('Succesfully took in the loan.'));
    }
}