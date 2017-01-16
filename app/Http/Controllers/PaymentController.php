<?php

namespace App\Http\Controllers;

use App\SchoolFeePayment;
use Illuminate\Http\Request;
use Paystack;

class PaymentController extends Controller
{
    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    public function redirectToPaystackGateway(){
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback(Request $request)
    {
        $paymentDetails = Paystack::getPaymentData();

        var_dump($request->all());

        dd($paymentDetails);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }

    public function handleGatewayCallbackForCurrentSchoolFee(Request $request){
        $paymentDetails = Paystack::getPaymentData();

        //dd($paymentDetails['data']['metadata']['custom_fields']);


        $school_fee_payment = new SchoolFeePayment;

        $school_fee_payment->term = $paymentDetails['data']['metadata']['custom_fields'][0]['value'];
        $school_fee_payment->user_id = $paymentDetails['data']['metadata']['custom_fields'][1]['value'];
        $school_fee_payment->student_id = $paymentDetails['data']['metadata']['custom_fields'][2]['value'];
        $school_fee_payment->guardian_id = $paymentDetails['data']['metadata']['custom_fields'][3]['value'];
        $school_fee_payment->session_id = $paymentDetails['data']['metadata']['custom_fields'][4]['value'];
        $school_fee_payment->classroom_id = $paymentDetails['data']['metadata']['custom_fields'][5]['value'];
        $school_fee_payment->amount = $paymentDetails['data']['metadata']['custom_fields'][6]['value'];
        $school_fee_payment->transaction_date = '';

        $school_fee_payment->balance = 1;

        $school_fee_payment->reference = $paymentDetails['data']['reference'];

        $school_fee_payment->status = 'payed';






        dd($school_fee_payment);

        dd($paymentDetails);
    }

    public function testForm(){
        return view('guardian.testForm');
    }
}
