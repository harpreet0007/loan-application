<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Loan;
use Helper;
use App\Http\Resources\TransactionCollection;

class Transactions extends Controller
{
    //
    public function createInstallment(Request $request)
    {
        $getData = $request->all();
        $response = $this->validateData($getData,[
            'amount' => ['required', 'regex:/^\d*(\.\d{2})?$/'],
            'payment_method' => 'required|string',
            'loan_id' => 'required|integer',
        ]);
        
        if ($response !== true) {
            return $this->respondJson('please provide valid data format.',$response,200,0);
        }
        
        $loan = Loan::select(['id', 'amount', 'interest_rate', 'loan_term','installment_period'])
                ->where([
                    'user_id'=>auth()->user()->id,
                    'id'=>$getData['loan_id'],
                    'status'=>Loan::LOAN_STATUS_APPROVED
                ])
                ->first();
        if ($loan) {
            $given_payment_amount = number_format($getData['amount'], 2, '.', '');
            $monthly_installment = Helper::GetEmi($loan->amount,$loan->interest_rate,$loan->loan_term,$loan->installment_period_multiplication,$loan->transactions()->count()+1);

            if ($monthly_installment === $given_payment_amount) {
                $payment = $loan->transactions()->create($getData);
                return $this->respondJson('Installment successfully paid.', ['payment' => TransactionCollection::make($payment)],200,1);
            }
            return $this->respondJson('installment amount should be '.$monthly_installment,$response,200,0);
        }
        return $this->respondJson('No loan found to make a payment of installment.',[],200,0);
    }
}
