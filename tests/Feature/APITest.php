<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Helper;

class APITest extends TestCase
{
    use WithFaker;
    static $token='';
    static $loan_id='';
    static $installment_amount='';
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    public function testCheckRegistrationApi()
    {
        $response = $this->post('api/register', ['name' =>$this->faker->firstName(),'email'=>$this->faker->email(),'password'=>'123456','c_password'=>'123456']);
        $response->assertStatus(200);
        self::$token="Bearer ".$response['data']['token'];
    }

    public function testCheckLoginApi()
    {
        $response = $this->post('api/login', ['email' =>'admin@gmail.com','password'=>'123456']);
        $response->assertStatus(200);
        self::$token="Bearer ".$response['data']['token'];
    }

    public function testCheckAuthenticationInLoanApi()
    {
        $response = $this->post('api/createLoan', ['amount' =>'1000','loan_term'=>'1','interest_rate' =>'10','installment_period'=>'1']);
        $response->assertStatus(302);
    }

    public function testCheckCreateLoanRequestApi()
    {
        $response = $this->withHeaders([
            'Authorization' => self::$token,
        ])->post('api/createLoan', ['amount' =>'1000','loan_term'=>'1','interest_rate' =>'10','installment_period'=>'1']);
        $response->assertStatus(200);
        self::$loan_id=$response['data']['loan']['id'];
    }

    public function testCheckGetLoansApi()
    {
        $response = $this->withHeaders([
            'Authorization' => self::$token,
        ])->get('api/getLoans');
        $response->assertStatus(200);

    }

    public function testCheckGetLoanDetailsApi()
    {
        $response = $this->withHeaders([
            'Authorization' => self::$token,
        ])->get('api/loanDetails/'.self::$loan_id);
        $response->assertStatus(200);
        self::$installment_amount=$response['data']['loan']['id'];
    }
   
    public function testCheckPayInsatallmentApi()
    {
        $response = $this->withHeaders([
            'Authorization' => self::$token,
        ])->post('api/createInstallment', ['amount' =>'88','payment_method'=>'1','loan_id' =>self::$loan_id]);
        $response->assertStatus(200);
    }
    
}
