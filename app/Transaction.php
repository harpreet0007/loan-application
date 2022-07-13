<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Loan;
class Transaction extends Model
{
    protected $fillable = ['amount','payment_method','loan_id'];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $transaction->user_id = auth()->user()->id;
        });
        self::created(function($transaction){
            if ($transaction->loan->loan_term*$transaction->loan->installment_period_multiplication === $transaction->loan->transactions()->count()) {
                $transaction->loan->offsetUnset('installment_period_multiplication');
                $transaction->loan->update(['status' => Loan::LOAN_STATUS_FULL_PAID]);
            }
        });

    }
    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
