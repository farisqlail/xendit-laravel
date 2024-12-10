<?php

namespace App\Http\Controllers;

use App\Services\XenditService;
use Xendit\Configuration;
use Xendit\Payout\PayoutApi;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $xenditService;

    public function __construct(XenditService $xenditService)
    {
        $this->xenditService = $xenditService;
    }

    public function createInvoice(Request $request)
    {
        $validated = $request->validate([
            'external_id' => 'required|string',
            'amount' => 'required|numeric|min:10000',
        ]);

        try {
            $invoice = $this->xenditService->createInvoice($validated);

            return response()->json(['success' => true, 'invoice' => $invoice], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function createEWalletInvoice(Request $request)
    {
        try {
            $apiInstance = new PayoutApi();
            Configuration::setXenditKey(env('XENDIT_API_KEY'));

            $idempotency_key = "6758439c2bab4f5ba6b6a025";
            $for_user_id = "6751c43e39eb59d6d3897cf6";
            $data = [
                'reference_id' => $request->get('external_id'),
                'currency' => 'IDR',
                'amount' => $request->get('amount'),
                'channel_code' => $request->get('channel_code'),
                'ewallet_details' => [
                    'success_redirect_url' => 'https://your-website.com/success',
                ],
            ];

            $paymentRequest = $apiInstance->createPayout($idempotency_key, $for_user_id, $data);
            return response()->json(['success' => true, 'data' => $paymentRequest], 200);
        } catch (\Exception $e) {
            echo 'Exception when calling PaymentMethodApi->createPaymentMethod: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function getInvoice($invoiceId)
    {
        try {
            $invoice = $this->xenditService->getInvoice($invoiceId);
            return response()->json(['success' => true, 'invoice' => $invoice], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
