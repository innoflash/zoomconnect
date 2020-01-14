<?php

return [
    /**
     * These are the ZoomConnest API endpoints for JSON and XML message sending alternatives
     * 
     * In case they change for some reason feel free to update here
     */
    'url' => [
        'json' => [
            'single' => 'https://www.zoomconnect.com/app/api/rest/v1/sms/send.json',
            'bulk' => 'https://www.zoomconnect.com/app/api/rest/v1/sms/send-bulk.json'
        ],
        'xml' => [
            'single' => 'https://www.zoomconnect.com/app/api/rest/v1/sms/send.xml',
            'bulk' => 'https://www.zoomconnect.com/app/api/rest/v1/sms/send-bulk.xml'
        ]
    ],

    /**
     * This is the email used to register and is used by ZoomConnect to identify you
     */
    'email' => env('ZOOMCONNECT_EMAIL', null),

    /**
     * This is the api token given to you by ZoomConnect
     */
    'api_token' => env('ZOOMCONNECT_TOKEN', null),

    /**
     * This selects the way you would wanna send the SMS
     * 
     * Available options are [json, xml]
     */
    'sms_method' => 'xml'
];
