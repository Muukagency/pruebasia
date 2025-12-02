<?php

return [
    'meta' => [
        'verify_token' => env('META_VERIFY_TOKEN'),
        'app_id' => env('META_APP_ID'),
        'app_secret' => env('META_APP_SECRET'),
        'whatsapp_template' => env('META_WHATSAPP_TEMPLATE'),
    ],
    'whatsapp' => [
        'mode' => env('WHATSAPP_MODE', 'basic'),
        'business_token' => env('WHATSAPP_BUSINESS_TOKEN'),
        'business_phone' => env('WHATSAPP_BUSINESS_PHONE'),
        'sender' => env('WHATSAPP_SENDER_PHONE'),
    ],
    'payments' => [
        'provider' => env('PAYMENT_PROVIDER', 'conekta'),
        'conekta' => [
            'public' => env('CONEKTA_PUBLIC_KEY'),
            'private' => env('CONEKTA_PRIVATE_KEY'),
        ],
        'mercadopago' => [
            'token' => env('MERCADOPAGO_TOKEN'),
        ],
        'webhook_secret' => env('PAYMENT_WEBHOOK_SECRET'),
    ],
];
