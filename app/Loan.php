<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = ['amount','loan_term','interest_rate','status','user_id','installment_period'];

    public const LOAN_STATUS_PENDING = 0;
    public const LOAN_STATUS_APPROVED = 1;
    public const LOAN_STATUS_REJECTED = 2;
    public const LOAN_STATUS_FULL_PAID = 3;

    public const LOAN_WEEKLY = 0;
    public const LOAN_MONTH = 1;
    public const LOAN_YEARLY = 2;

    public static $status = [
        self::LOAN_STATUS_PENDING => 'Pending',
        self::LOAN_STATUS_APPROVED => 'Approved',
        self::LOAN_STATUS_REJECTED => 'Rejected',
        self::LOAN_STATUS_FULL_PAID => 'Fully-Paid'
    ];

    public static $installment_period_multiplication = [
        self::LOAN_WEEKLY => '52',
        self::LOAN_MONTH => '12',
        self::LOAN_YEARLY => '1'
    ];

    public static $installment_period_text = [
        self::LOAN_WEEKLY => 'week',
        self::LOAN_MONTH => 'month',
        self::LOAN_YEARLY => 'year'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($loan) {
            $loan->user_id = auth()->user()->id;
            $loan->status = self::LOAN_STATUS_PENDING;
        });
    }

    public function getStatusTextAttribute($value)
    {
        return $this->attributes['status_text'] = self::$status[$this->attributes['status']];
    }

    public function getInstallmentPeriodMultiplicationAttribute($value)
    {
        return $this->attributes['installment_period_multiplication'] = self::$installment_period_multiplication[$this->attributes['installment_period']];
    }

    public function getInstallmentPeriodTextAttribute($value)
    {
        return $this->attributes['installment_period_text'] = self::$installment_period_text[$this->attributes['installment_period']];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
