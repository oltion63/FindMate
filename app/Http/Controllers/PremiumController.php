<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $plan = $request->query('plan', '1month');
        $plans = [
            '1month' => [
                'price' => 'price_1RYn41JYwg6jUZYwpE1w9xe7',
                'months' => 1,
            ],
            '6months' => [
                'price' => 'price_1RYn5aJYwg6jUZYwZXAY1RQz', 
                'months' => 6,
            ],
            '1year' => [
                'price' => 'price_1RYn6SJYwg6jUZYwVbMZWfZZ',
                'months' => 12,
            ],
        ];
        if (!isset($plans[$plan])) {
            abort(400, 'Invalid plan');
        }
        $stripePriceId = $plans[$plan]['price'];
        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => $stripePriceId,
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'customer_email' => $user->email,
            'success_url' => route('premium.success', ['plan' => $plan]),
            'cancel_url' => url()->previous(),
            'metadata' => [
                'user_id' => $user->id,
                'plan' => $plan,
            ],
        ]);
        return Redirect::away($session->url);
    }

    public function success(Request $request)
    {
        $user = Auth::user();
        $plan = $request->query('plan', '1month');
        $months = match($plan) {
            '1month' => 1,
            '6months' => 6,
            '1year' => 12,
            default => 1,
        };
        $user->is_premium = true;
        $user->premium_until = now()->addMonths($months);
        $user->save();
        return redirect()->route('jobs.index')->with('success', 'You are now a premium member!');
    }
}
