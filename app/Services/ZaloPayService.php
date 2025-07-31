<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZaloPayService
{
    private $appId;
    private $key1;
    private $key2;
    private $environment;
    private $createOrderUrl;
    private $queryOrderUrl;

    public function __construct()
    {
        $this->appId = config('zalopay.app_id');
        $this->key1 = config('zalopay.key1');
        $this->key2 = config('zalopay.key2');
        $this->environment = config('zalopay.environment', 'sandbox');
        $this->createOrderUrl = config('zalopay.create_order_url');
        $this->queryOrderUrl = config('zalopay.query_order_url');
    }

    /**
     * Tạo đơn hàng thanh toán ZaloPay
     */
    public function createOrder($orderData)
    {
        try {
            $transId = $this->generateTransId();
            
            $params = [
                'app_id' => $this->appId,
                'app_user' => config('zalopay.app_user'),
                'app_trans_id' => $transId,
                'app_time' => round(microtime(true) * 1000), // milliseconds
                'amount' => $orderData['amount'],
                'description' => $orderData['description'] ?? "Thanh toán đơn hàng #{$orderData['order_id']}",
                'bank_code' => config('zalopay.bank_code'),
                'item' => json_encode($orderData['items'] ?? []),
                'embed_data' => json_encode([
                    'order_id' => $orderData['order_id'],
                    'redirecturl' => config('zalopay.return_url')
                ]),
                'callback_url' => config('zalopay.callback_url'),
            ];

            // Tạo MAC
            $params['mac'] = $this->createMac($params);

            Log::info('ZaloPay Create Order Request', $params);

            $response = Http::asForm()->post($this->createOrderUrl, $params);
            
            $result = $response->json();
            
            Log::info('ZaloPay Create Order Response', $result);

            if ($result['return_code'] == 1) {
                return [
                    'success' => true,
                    'app_trans_id' => $transId,
                    'order_url' => $result['order_url'],
                    'zp_trans_token' => $result['zp_trans_token'] ?? null,
                    'order_token' => $result['order_token'] ?? null
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $result['return_message'] ?? 'Tạo đơn hàng ZaloPay thất bại',
                    'error_code' => $result['return_code']
                ];
            }

        } catch (\Exception $e) {
            Log::error('ZaloPay Create Order Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Lỗi kết nối ZaloPay: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Truy vấn trạng thái đơn hàng
     */
    public function queryOrder($appTransId)
    {
        try {
            $params = [
                'app_id' => $this->appId,
                'app_trans_id' => $appTransId,
            ];

            // Tạo MAC cho query
            $data = $params['app_id'] . '|' . $params['app_trans_id'] . '|' . $this->key1;
            $params['mac'] = hash_hmac('sha256', $data, $this->key1);

            Log::info('ZaloPay Query Order Request', $params);

            $response = Http::asForm()->post($this->queryOrderUrl, $params);
            $result = $response->json();

            Log::info('ZaloPay Query Order Response', $result);

            return $result;

        } catch (\Exception $e) {
            Log::error('ZaloPay Query Order Error: ' . $e->getMessage());
            return [
                'return_code' => -1,
                'return_message' => 'Lỗi kết nối ZaloPay: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Xác thực callback từ ZaloPay
     */
    public function verifyCallback($data)
    {
        try {
            $mac = $data['mac'] ?? '';
            unset($data['mac']);

            // Tính MAC để verify
            $reqMac = hash_hmac('sha256', $data['data'], $this->key2);

            if (strcmp($mac, $reqMac) === 0) {
                $dataJson = json_decode($data['data'], true);
                return [
                    'valid' => true,
                    'data' => $dataJson
                ];
            } else {
                return [
                    'valid' => false,
                    'message' => 'Invalid MAC'
                ];
            }

        } catch (\Exception $e) {
            Log::error('ZaloPay Verify Callback Error: ' . $e->getMessage());
            return [
                'valid' => false,
                'message' => 'Error verifying callback'
            ];
        }
    }

    /**
     * Tạo MAC cho request
     */
    private function createMac($params)
    {
        $data = $params['app_id'] . '|' . $params['app_trans_id'] . '|' . 
                $params['app_user'] . '|' . $params['amount'] . '|' . 
                $params['app_time'] . '|' . $params['embed_data'] . '|' . 
                $params['item'];
        
        return hash_hmac('sha256', $data, $this->key1);
    }

    /**
     * Tạo transaction ID unique
     */
    private function generateTransId()
    {
        return date('ymd') . '_' . time() . '_' . rand(1000, 9999);
    }

    /**
     * Format số tiền (ZaloPay yêu cầu integer)
     */
    public function formatAmount($amount)
    {
        return (int) round($amount);
    }
} 