<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Loan;
use Helper;

class LoanCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $status = [
            Loan::LOAN_STATUS_PENDING => 'Pending',
            Loan::LOAN_STATUS_APPROVED => 'Approved',
            Loan::LOAN_STATUS_REJECTED => 'Rejected',
            Loan::LOAN_STATUS_FULL_PAID => 'Fully-Paid'
        ];
        $total_amount_with_interest=Helper::GetTotalWithIntrest($this->amount,$this->interest_rate,$this->loan_term,$this->installment_period_multiplication);
        $total_interest = $total_amount_with_interest-$this->amount;
        
        return [
            'id' => (int)$this->id,
            'user' => $this->user->name,
            'amount' => number_format($this->amount, 2),
            'loan_term' => $this->loan_term*$this->installment_period_multiplication." ".$this->installment_period_text."(s)",
            'interest_rate' => $this->interest_rate." %",
            'total_interest' => number_format($total_interest, 2),
            'total_amount_with_interest' => number_format($total_amount_with_interest, 2),
            'status' => $status[$this->status],
            'transactions' => TransactionCollection::collection($this->whenLoaded('transactions')),
        ];
    }
}
