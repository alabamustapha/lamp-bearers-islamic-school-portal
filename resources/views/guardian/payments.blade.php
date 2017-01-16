@extends('layouts.app')

@section('title', 'Payments')

@section('page-heading')
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $guardian->title . ' ' . $guardian->name }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('guardian') }}">Home</a>
                </li>
                <li class="active">
                    <a href="{{ url('guardian/payments') }}">Payments</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
 </div>
@endsection

@section('content')

<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Current Active Wards({{$guardian->students()->whereIn('status',  ['active', 'promoting', 'promoted', 'repeating', 'repeated', 'graduating'] )->count() }})</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                     <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover .teacher-classroom-dataTables" >
                        <thead>
                        <tr>
                            <th>Ward's name</th>
                            <th>Admin number</th>
                            <th>Sex</th>
                            <th>Class</th>
                            <th>Amount</th>
                            <th>Term</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($current_term_payments as $payment)

                        <tr class="gradeA">
                            <td>{{ $payment['student']->name }}</td>
                            <td>{{ $payment['student']->admin_number }}</td>
                            <td>{{ $payment['student']->sex }}</td>
                            <td>{{ $payment['student']->classroom->name or "" }}</td>
                            <td>{{ $payment['term'] }}</td>
                            <td>{{ $payment['amount'] }}</td>
                            <td>
                                <form action="{{ url('guardian/payments/current_school_fees') }}" method="post">
                                    <input type='hidden' name="amount" value="{{ $payment['amount'] * 100 }}">
                                    <input type='hidden' name="email"  value="{{ $payment['email'] }}">
                                    <input type='hidden' name="callback_url"  value="{{ url('guardian/payments/current_school_fee/callback') }}">
                                    <input type="hidden" name="metadata" value="{{ $payment['metadata'] }}">
                                    <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
                                    <input type="hidden" name="key" value="{{ config('paystack.secretKey') }}">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-credit-card"></i> Pay now</button>
                                </form>
                            </td>

                        </tr>
                       @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Ward's name</th>
                            <th>Admin number</th>
                            <th>Sex</th>
                            <th>Class</th>
                            <th>Amount</th>
                            <th>Term</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                        </table>
                            </div>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection