<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
   public function creditCheckout()
   {
        $user = User::find(1);
        $intent = $user->createSetupIntent();
        $price = 100;
       return view('welcome', compact('intent' , 'price'));
   }
   public function purchase(Request $request)
   {
        $user = User::find(1);
        $paymentMethod = $request->payment_method;
        $price = 100;

        try{

            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->charge($price * 100, $paymentMethod);
        }catch(\Exception $e){
            dd($e->getMessage());
        }

        dd("your logic after payment");
        /**
         * 1. Create a new PaymentIntent with the order amount and currency
         * 2. Create a SetupIntent with the order amount and currency
         * 3. Attach the PaymentIntent to the SetupIntent
         * 4.Your Logic After Payment
         */

   }
}
