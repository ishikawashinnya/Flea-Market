<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\StripeClient;
use Stripe\Exception\ApiErrorException;
use App\Models\Item;
use App\Models\Sold_item;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function checkout(Request $request) {
        $item = Item::findOrFail($request->item_id);
        $profile = auth()->user()->profile;
        $user = Auth::user();

        Stripe::setApikey(env('STRIPE_SECRET'));

        try {
            $paymentMethods = [];
            switch ($profile->payment_method) {
                case 'credit_card' : $paymentMethods = ['card'];
                    break;
                case 'convenience_store' : $paymentMethods = ['konbini'];
                    break;
                default: $paymentMethods = ['card'];
                    break;
            }

            $session = Session::create([
                'payment_method_types' => $paymentMethods,
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'jpy',
                            'product_data' => [
                                'name' => $item->name,
                            ],
                            'unit_amount' => $item->price,
                        ],
                        'quantity' =>1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('success', ['item_id' => $item->id]),
                'cancel_url' => route('cancel', ['item_id' => $item->id]),
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', '決済に失敗しました');
        }
    }

    public function success($item_id) {
        try {
            Sold_item::create([
                'item_id' => $item_id,
                'user_id' => Auth::id(),
            ]);

            return view('thanks', compact('item_id'));
        } catch (\Exception $e) {
            return back()->with('error', '購入情報の保存に失敗しました');
        }
    }

    public function cancel($item_id) {
        return view('cancel', compact('item_id'));
    }
}