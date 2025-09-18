<?php

return [
/*
   |--------------------------------------------------------------------------
   | ZaloPay Configuration
   |--------------------------------------------------------------------------
   |
   | Configuration for ZaloPay payment gateway integration
   |
   */

'app_id' => env('ZALOPAY_APP_ID', '2553'),
'key1' => env('ZALOPAY_KEY1', 'PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL'),
'key2' => env('ZALOPAY_KEY2', 'kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz'),
'app_user' => env('ZALOPAY_APP_USER', 'demo'),
'environment' => env('ZALOPAY_ENVIRONMENT', 'sandbox'),

/*
   |--------------------------------------------------------------------------
   | URLs
   |--------------------------------------------------------------------------
   */
    'return_url' => env('ZALOPAY_RETURN_URL', 'http://localhost:8000/checkout/zalopay-return'),
    'callback_url' => env('ZALOPAY_CALLBACK_URL', 'http://localhost:8000/checkout/zalopay-callback'),
    'return_url' => env('ZALOPAY_RETURN_URL', 'http://127.0.0.1:8000/checkout/zalopay-return'),
    'callback_url' => env('ZALOPAY_CALLBACK_URL', 'http://127.0.0.1:8000/checkout/zalopay-callback'),

/*
   |--------------------------------------------------------------------------
   | API Endpoints
   |--------------------------------------------------------------------------
   */
'create_order_url' => env('ZALOPAY_CREATE_ORDER_URL', 'https://sb-openapi.zalopay.vn/v2/create'),
'query_order_url' => env('ZALOPAY_QUERY_ORDER_URL', 'https://sb-openapi.zalopay.vn/v2/query'),

/*
   |--------------------------------------------------------------------------
   | Payment Configuration
   |--------------------------------------------------------------------------
   */
'bank_code' => '', // Để trống sẽ hiển thị tất cả phương thức thanh toán
'item' => '[]', // JSON string mô tả sản phẩm
'embed_data' => '{}', // Dữ liệu bổ sung