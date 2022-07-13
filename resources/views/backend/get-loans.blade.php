
@extends('layouts.app')
@section('content')
@include('backend/flash-message')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">User</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Loan Term</th>
                    <th scope="col">Intrest Rate</th>
                    <th scope="col">Status</th>
                    <th scope="col">Installment Period</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @if($loans)
                        @foreach ($loans as $value)
                           <tr>
                            <th scope="row">{{$value->id}}</th>
                            <td>{{$value->user->name}}</td>
                            <td>{{$value->amount}}</td>
                            <td>{{$value->loan_term}}</td>
                            <td>{{$value->interest_rate}}</td>
                            <td>{{$value->status_text}}</td>
                            <td>{{$value->installment_period_text}}ly</td>
                            <td>@if($value->status=='0') <a href="{{ url('changeStatus/'.$value->id."/1") }}"><button class="btn btn-success">Approve</button></a><a href="{{ url('changeStatus/'.$value->id."/2") }}" class="offset-1"><button class="btn btn-danger">Reject</button></a>@else - @endif</td>
                          </tr>
                        @endforeach
                    @endif
                  
                </tbody>
              </table>
              {{ $loans->links() }}
        </div>
    </div>
</div>
@endsection