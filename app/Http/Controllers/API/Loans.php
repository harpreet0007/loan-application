<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Loan;
use App\Http\Resources\LoanCollection;

class Loans extends Controller
{
    public function create(Request $request)
    {
        $getData = $request->all();
        $response = $this->validateData($getData,[
            'amount' => 'required|regex:/^[0-9]+(\.[0-9]{1,2})?$/',
            'loan_term' => 'required|integer',
            'interest_rate' => 'required|regex:/^[0-9]+(\.[0-9]{1,2})?$/'
        ]);
        
        if ($response !== true) {
            return $this->respondJson($response,[],422,0);
        }

        $loan = Loan::create($getData);
        return $this->respondJson('Loan created.', ['loan' => LoanCollection::make($loan)],200,1);
    }

    public function getLoans()
    {
        $loans = Loan::with('user')->where('user_id', auth()->user()->id)->paginate(10);
        return $this->respondJson('', ['loans' => LoanCollection::collection($loans)],200,1);
    }

    public function loanDetails($id)
    {
        $loan = Loan::with('user', 'transactions')->find($id);
        if($loan){
            return $this->respondJson('', ['loan' => LoanCollection::make($loan)],200,1);
        }
        return $this->respondJson('loan infromation not found.',[],200,0);
    }
}
