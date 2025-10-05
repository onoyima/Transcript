<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Transcript Pricing Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains all pricing configurations for transcript applications
    | including base prices, category-specific pricing, and courier charges.
    |
    */

    'base' => [
        'undergraduate' => 2000,
        'postgraduate' => 3000,
    ],

    'student' => [
        'physical' => 5000,
        'ecopy' => 3000,
    ],

    'institutional' => [
        'ecopy' => 5000,
        'courier' => [
            'local' => [
                'dhl' => 3000,
                'zcarex' => 30000,
                'couples' => 3000,
            ],
            'international' => [
                'dhl' => 10000,
                'zcarex' => 10000,
                'couples' => 10000,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Additional Charges
    |--------------------------------------------------------------------------
    |
    | These are additional charges that can be applied to transcript applications
    | such as processing fees, handling charges, etc.
    |
    */

    'additional_charges' => [
        'processing_fee' => 500,
        'handling_fee' => 200,
        'express_processing' => 2000,
        'weekend_processing' => 1000,
    ],

    /*
    |--------------------------------------------------------------------------
    | Discount Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for any discounts that might be applied
    |
    */

    'discounts' => [
        'bulk_discount' => [
            'threshold' => 5, // Number of copies
            'percentage' => 10, // 10% discount
        ],
        'institutional_discount' => [
            'percentage' => 5, // 5% discount for institutional requests
        ],
    ],
];