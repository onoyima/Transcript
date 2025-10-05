<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Remita extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'student_id', 'rrr', 'order_id', 'fee_type', 'fee_type_id',
        'service_type_id', 'amount', 'status_code', 'status', 'request_ip',
        'order_ref', 'bank_code', 'branch_code', 'debit_date', 'transaction_id',
        'transaction_date', 'channel', 'verify_by', 'authenticate', 'authenticate_by'
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }

    // Generate RRR (Remita Reference)
    public function generateRRR($payment, $customField)
    {
        Log::info('Generating RRR for payment', ['order_id' => $payment->order_id, 'student_id' => $payment->student_id]);

        // Directly pass the values for testing
        $apiKey = '154279';  // REMITA_API_KEY
        $merchantId = '8434377560';  // REMITA_MERCHANT_ID

        Log::info('Remita API Key and Merchant ID', [
            'apiKey' => $apiKey,
            'merchantId' => $merchantId
        ]);

        // Check if keys are available
        if (!$apiKey || !$merchantId) {
            Log::error('API Key or Merchant ID is missing');
            throw new \Exception('Missing API Key or Merchant ID');
        }

        $orderId = $payment->order_id;
        $hash = hash('sha512', $merchantId . $payment->service_type_id . $orderId . $payment->amount . $apiKey);

        Log::debug('Generated hash for request', ['hash' => $hash]);

        $url = 'https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit';

        $jsonData = [
            'serviceTypeId' => $payment->service_type_id,
            'amount' => $payment->amount,
            'merchantId' => $merchantId,
            'apiKey' => $apiKey,
            'orderId' => $orderId,
            'payerName' => $payment->payer_name,
            'payerEmail' => $payment->payer_email,
            'payerPhone' => $payment->payer_phone,
            'description' => $payment->description,
            'customField' => $customField,
        ];

        Log::info('Sending payment data to Remita API', ['jsonData' => $jsonData]);

        $headers = [
            'Content-Type: application/json',
            'Authorization: remitaConsumerKey=' . $merchantId . ',remitaConsumerToken=' . $hash
        ];

        $response = $this->postMethod($url, $headers, json_encode($jsonData));

        Log::info('Received response from Remita API', ['response' => $response]);

        return $response;
    }


    // Post method to make HTTP requests to Remita API
    private function postMethod($url, $headers, $data)
    {
        try {
            Log::info('Headers to be sent', ['headers' => $headers]);

            Log::info('Making POST request to Remita API', ['url' => $url, 'headers' => $headers, 'data' => $data]);

            $response = Http::withHeaders($headers)->post($url, json_decode($data, true));


            Log::info('POST request successful', ['response' => $response->json()]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error during POST request to Remita API', ['error_message' => $e->getMessage()]);

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    // Verify RRR
    public function verifyRRR($rrr)
    {
        Log::info('Verifying RRR', ['rrr' => $rrr]);

        $apiKey = config('app.REMITA_API_KEY');
        $merchantId = config('app.REMITA_MERCHANT_ID');
        $hash = hash('sha512', $rrr . $apiKey . $merchantId);
        $url = config('app.REMITA_DOMAIN') . "/remita/ecomm/{$merchantId}/{$rrr}/{$hash}/status.reg";

        Log::debug('Generated hash for RRR verification', ['hash' => $hash]);

        $headers = [
            'Content-Type: application/json',
            'Authorization: remitaConsumerKey=' . $merchantId . ',remitaConsumerToken=' . $hash
        ];

        $response = $this->getMethod($url, $headers);

        Log::info('Received response for RRR verification', ['response' => $response]);

        return $response;
    }

    // Get method to make HTTP requests to Remita API
    private function getMethod($url, $headers)
    {
        Log::info('Making GET request to Remita API', ['url' => $url, 'headers' => $headers]);

        $response = Http::withHeaders($headers)->get($url);

        Log::info('GET request successful', ['response' => $response->json()]);

        return $response->json();
    }

    // Get status code description
    public function getStatusAttribute()
    {
        Log::info('Getting status description for status code', ['status_code' => $this->status_code]);

        switch ($this->status_code) {
            case '25':
                return 'Reference Generated';
            case '21':
                return 'Transaction Pending';
            case '01':
                return 'Transaction Approved';
            case '30':
                return 'Insufficient Balance';
            case '02':
                return 'Transaction Failed';
            case '00':
                return 'Transaction Completed';
            default:
                return 'Unknown Error';
        }
    }

    // Get fee type description
    public function getFeesAttribute()
    {
        Log::info('Getting fee description for fee type', ['fee_type' => $this->fee_type]);

        switch ($this->fee_type) {
            case 1:
                return 'School Fees';
            case 2:
                return 'Undergraduate Acceptance Fee';
            case 3:
                return 'Late Course Registration';
            case 4:
                return 'ID Card Replacement';
            default:
                return 'Other Fees';
        }
    }
}
