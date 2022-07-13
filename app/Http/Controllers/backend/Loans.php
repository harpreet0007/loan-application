<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Loan;
use Helper;
use App\Http\Resources\LoanCollection;

class Loans extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getLoans()
    {
        $loans = Loan::with('user')->paginate(10);
        return view('backend/get-loans')->with(['loans'=>$loans]);
    }

    public function changeStatus($loan_id,$status)
    {
        $result=Loan::where(['id'=>$loan_id])->where('status','<>',$status)->update(['status'=>$status]);
        if($result){
            return back()->with('success','status updated successfully!');
        }else{
            return back()->with('error','something went wrong!');
        }
    }
}
