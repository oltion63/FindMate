<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PremiumController extends Controller
{
    public function checkout(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $user = Auth::user();
        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'FindMate Premium Membership',
                    ],
                    'unit_amount' => 12000, 
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'customer_email' => $user->email,
            'success_url' => route('premium.success'),
            'cancel_url' => url()->previous(),
            'metadata' => [
                'user_id' => $user->id,
            ],
        ]);

        return Redirect::away($session->url);
    }

    public function success(Request $request)
    {
        $user = Auth::user();
        $user->is_premium = true;
        $user->save();
        return redirect()->route('jobs.index')->with('success', 'You are now a premium member!');
    }
}
