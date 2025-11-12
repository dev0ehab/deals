<?php

return [
    'new' => [
        'user' => [
            'subject' => 'Your Order is pending',
            'body' => 'Thank you for your order, click here to see your order details'
        ],
        'vendor' => [
            'subject' => 'New Order',
            'body' => 'There is new order number :id'
        ],
    ],

    'change-status' => [
        'subject' => 'Your order status has been changed',
        'body' => 'Your order :id status has been changed to :status',
    ],


    'refund' => [
        'user' => [

            'true' => [
                'subject' => 'Your refund request has been sent for order #:id',
                'body' => 'Your payment has been refunded successfully'
            ],

            'false' => [
                'subject' => 'Your refund request has been sent for order #:id',
                'body' => 'please contact the technical support'
            ]

        ]
    ],

    'cancelled' => [
        'user' => [
            'subject' => 'Your Order has been cancelled',
            'body' => 'The vendor cancel the order number #:id and return the payment :payment',
            'body_reason' => 'The vendor cancel the order number #:id, and return the payment :payment, due to :reason',
        ],
        'admin' => [
            'subject' => 'The Order has been cancelled',
            'body' => 'The User cancel the order number #:id',
            'body_reason' => 'The User cancel the order number #:id, due to :reason',
        ],

        'subject' => 'Your Order has been cancelled',
        'body' => 'The vendor cancel the order number #:id',
        'body_reason' => 'The vendor cancel the order number #:id, due to :reason',
        'system_body' => 'Your order number #:id is cancelled, Due to exceeding the time allowed to accept the order or assign the order to the delivery driver by the vendor.'
    ],
];
