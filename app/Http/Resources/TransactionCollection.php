<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Helper;

class TransactionCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $total_amount_with_interest=Helper::GetTotalWithIntrest($this->loan->amount,$this->loan->interest_rate,$this->loan->loan_term,$this->loan->installment_period_multiplication);
        $total_interest = $total_amount_with_interest-$this->loan->amount;

        return [
            'id' => (int)$this->id,
            'user' => $this->user->name,
            'total_amount_with_interest' => number_format($total_amount_with_interest, 2),
            'term_installment' => number_format($this->amount, 2),
            'payment_method' => $this->payment_method,
            'loan_term' => $this->loan->loan_term." ".$this->loan->installment_period_text,
            'paid_installments_count' => $this->loan->transactions()->count(),
            'paid_on' => $this->created_at,
        ];
    }
}
