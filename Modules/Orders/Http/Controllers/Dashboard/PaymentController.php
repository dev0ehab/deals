<?php

namespace Modules\Orders\Http\Controllers\Dashboard;

use App\Services\PaymentGateways\MyfatoorahService;
use Illuminate\Routing\Controller;



class PaymentController extends Controller
{




    public function myFatorahApproval()
    {
        $paymentClass = new MyfatoorahService();
        return $paymentClass->handleApproval();

    }


    public function myFatorahCancel()
    {
        return redirect()->route('pay.form')->withErrors('The payment process no compeleted, please try again');
    }


        public function payForm()
    {
        return view('orders::orders.pay-form');
    }
}
