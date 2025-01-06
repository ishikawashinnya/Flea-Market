<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\StripeClient;
use Stripe\Exception\ApiErrorException;
use App\Models\Item;
use App\Models\SoldItem;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    //クレジットカード・コンビニ払い機能
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
            SoldItem::create([
                'item_id' => $item_id,
                'user_id' => Auth::id(),
            ]);

            return view('thanks', compact('item_id'), ['showMypageButton' => true, 'showToppageButton' => true]);
        } catch (\Exception $e) {
            return back()->with('error', '購入情報の保存に失敗しました');
        }
    }

    public function cancel($item_id) {
        return view('cancel', compact('item_id'), ['showMypageButton' => true, 'showToppageButton' => true]);
    }

    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    //銀行振込機能
    public function banktransfer(Request $request)
    {
        $item = Item::findOrFail($request->item_id);

        $stripe = new StripeClient(config('services.stripe.secret'));

        $customerId = $this->createOrGetCustomer($request);

        try {
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $item->price,
                'currency' => 'jpy',
                'customer' => $customerId,
                'payment_method_types' => ['customer_balance'], 
                'payment_method_data' => ['type' => 'customer_balance'],
                'payment_method_options' => [
                    'customer_balance' => [
                        'funding_type' => 'bank_transfer',
                        'bank_transfer' => ['type' => 'jp_bank_transfer'],
                    ],
                ],
                'confirm' => true, 
            ]);
        } catch (\Exception $e) {
            return view('error')->with('message', 'PaymentIntent作成中にエラーが発生しました: ' . $e->getMessage());
        }

        try {
            $paymentIntentDetails = $stripe->paymentIntents->retrieve($paymentIntent->id);

            if (isset($paymentIntentDetails->next_action->display_bank_transfer_instructions)) {
                $bankTransferInfo = $paymentIntentDetails->next_action->display_bank_transfer_instructions->financial_addresses[0];
                $amountRemaining = $paymentIntentDetails->amount_remaining;

                SoldItem::create([
                    'item_id' => $item->id,
                    'user_id' => $request->user()->id,
                ]);

                return view('success', [
                    'hosted_instructions_url' => $paymentIntentDetails->next_action->display_bank_transfer_instructions->hosted_instructions_url,
            ], ['showMypageButton' => true, 'showToppageButton' => true]);
            } else {
                return view('error', ['showMypageButton' => true, 'showToppageButton' => true])->with('message', '銀行振込の情報が見つかりません。');
            }
        } catch (\Exception $e) {
            return view('error', ['showMypageButton' => true, 'showToppageButton' => true])->with('message', '支払い情報の取得中にエラーが発生しました: ' . $e->getMessage());
        }
    }

    private function createOrGetCustomer(Request $request)
    {
        $stripe = new StripeClient(config('services.stripe.secret'));
        $user = $request->user();

        if ($user->stripe_customer_id) {
            return $user->stripe_customer_id;
        }

        $customer = $stripe->customers->create([
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $user->stripe_customer_id = $customer->id;
        $user->save();

        return $customer->id;
    }
}