<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Queue Connection Name
    |--------------------------------------------------------------------------
    |
    | Lumen's queue API supports an assortment of back-ends via a single
    | API, giving you convenient access to each back-end using the same
    | syntax for every one. Here you may define a default connection.
    |
    */

    'default' => env('QUEUE_CONNECTION', 'sync'),

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection information for each server that
    | is used by your application. A default configuration has been added
    | for each back-end shipped with Lumen. You are free to add more.
    |
    | Drivers: "sync", "database", "beanstalkd", "sqs", "redis", "null"
    |
    */

    'connections' => [

        'sync' => [
            'driver' => 'sync',
        ],

        'database' => [
            'driver' => 'database',
            'table' => env('QUEUE_TABLE', 'jobs'),
            'queue' => 'default',
            'retry_after' => 90,
        ],

        'beanstalkd' => [
            'driver' => 'beanstalkd',
            'host' => 'localhost',
            'queue' => 'default',
            'retry_after' => 90,
        ],

        'sqs' => [
            'driver' => 'sqs',
            'key' => env('SQS_KEY', 'your-public-key'),
            'secret' => env('SQS_SECRET', 'your-secret-key'),
            'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
            'queue' => env('SQS_QUEUE', 'your-queue-name'),
            'region' => env('SQS_REGION', 'us-east-1'),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => env('QUEUE_REDIS_CONNECTION', 'default'),
            'queue' => 'default',
            'retry_after' => 90,
            'block_for' => null,
        ],

        'rabbitmq' => [
        
           'driver' => 'rabbitmq',
           'queue' => env('RABBITMQ_QUEUE', 'default'),
           'connection' => PhpAmqpLib\Connection\AMQPLazyConnection::class,
       
           'hosts' => [
               [
                   'host' => env('RABBITMQ_HOST', '127.0.0.1'),
                   'port' => env('RABBITMQ_PORT', 5672),
                   'user' => env('RABBITMQ_USER', 'guest'),
                   'password' => env('RABBITMQ_PASSWORD', 'guest'),
                   'vhost' => env('RABBITMQ_VHOST', '/'),
               ],
           ],
       
           'options' => [
               'ssl_options' => [
                   'cafile' => env('RABBITMQ_SSL_CAFILE', null),
                   'local_cert' => env('RABBITMQ_SSL_LOCALCERT', null),
                   'local_key' => env('RABBITMQ_SSL_LOCALKEY', null),
                   'verify_peer' => env('RABBITMQ_SSL_VERIFY_PEER', true),
                   'passphrase' => env('RABBITMQ_SSL_PASSPHRASE', null),
               ],
           ],
       
           /*
            * Set to "horizon" if you wish to use Laravel Horizon.
            */
           'worker' => env('RABBITMQ_WORKER', 'default'),
            
        ],

        'rabbitmq_direct' => [
        
           'driver' => 'rabbitmq',
           'queue' => env('RABBITMQ_DIRECT_QUEUE', 'default'),
           'connection' => PhpAmqpLib\Connection\AMQPLazyConnection::class,
       
           'hosts' => [
               [
                   'host' => env('RABBITMQ_HOST', '127.0.0.1'),
                   'port' => env('RABBITMQ_PORT', 5672),
                   'user' => env('RABBITMQ_USER', 'guest'),
                   'password' => env('RABBITMQ_PASSWORD', 'guest'),
                   'vhost' => env('RABBITMQ_VHOST', '/'),
               ],
           ],
       
           'options' => [
                'queue' => [
                    'exchange' => env('RABBITMQ_DIRECT_EXCHANGE_NAME', 'amq.direct'),
                    'exchange_type' => env('RABBITMQ_DIRECT_EXCHANGE_TYPE', 'direct'),
                    'exchange_routing_key' => env('RABBITMQ_DIRECT_EXCHANGE_ROUTING_KEY', 'default'),
                    'prioritize_delayed_messages' =>  env('RABBITMQ_DIRECT_PRIORITIZE_DELAYED_MESSAGES', false),
                    'queue_max_priority' => env('RABBITMQ_DIRECT_QUEUE_MAX_PRIORITY', 10),
                ],
                'exchange' => [
                    'name' => env('RABBITMQ_DIRECT_EXCHANGE_NAME', 'amq.direct'),
                    'declare' => env('RABBITMQ_DIRECT_EXCHANGE_DECLARE', true),
                    'type' => env('RABBITMQ_DIRECT_EXCHANGE_TYPE', 'direct'),
                    'passive' => env('RABBITMQ_DIRECT_EXCHANGE_PASSIVE', false),
                    'durable' => env('RABBITMQ_DIRECT_EXCHANGE_DURABLE', true),
                    'auto_delete' => env('RABBITMQ_DIRECT_EXCHANGE_AUTODELETE', false),
                    'arguments' => env('RABBITMQ_DIRECT_EXCHANGE_ARGUMENTS'),
                ], 
                'ssl_options' => [
                    'cafile' => env('RABBITMQ_DIRECT_SSL_CAFILE', null),
                    'local_cert' => env('RABBITMQ_DIRECT_SSL_LOCALCERT', null),
                    'local_key' => env('RABBITMQ_DIRECT_SSL_LOCALKEY', null),
                    'verify_peer' => env('RABBITMQ_DIRECT_SSL_VERIFY_PEER', true),
                    'passphrase' => env('RABBITMQ_DIRECT_SSL_PASSPHRASE', null),
                ],
           ],
       
           /*
            * Set to "horizon" if you wish to use Laravel Horizon.
            */
           'worker' => env('RABBITMQ_DIRECT_WORKER', 'default'),
            
        ],

        'rabbitmq_fanout' => [
        
           'driver' => 'rabbitmq',
           'queue' => env('RABBITMQ_FANOUT_QUEUE', 'default'),
           'connection' => PhpAmqpLib\Connection\AMQPLazyConnection::class,
       
           'hosts' => [
               [
                   'host' => env('RABBITMQ_HOST', '127.0.0.1'),
                   'port' => env('RABBITMQ_PORT', 5672),
                   'user' => env('RABBITMQ_USER', 'guest'),
                   'password' => env('RABBITMQ_PASSWORD', 'guest'),
                   'vhost' => env('RABBITMQ_VHOST', '/'),
               ],
           ],
       
           'options' => [
                'queue' => [
                    'exchange' => env('RABBITMQ_FANOUT_EXCHANGE_NAME', 'amq.fanout'),
                    'exchange_type' => env('RABBITMQ_FANOUT_EXCHANGE_TYPE', 'fanout'),
                    'prioritize_delayed_messages' =>  env('RABBITMQ_FANOUT_PRIORITIZE_DELAYED_MESSAGES', false),
                    'queue_max_priority' => env('RABBITMQ_FANOUT_QUEUE_MAX_PRIORITY', 10),
                ],
                'exchange' => [
                    'name' => env('RABBITMQ_FANOUT_EXCHANGE_NAME', 'amq.fanout'),
                    'declare' => env('RABBITMQ_FANOUT_EXCHANGE_DECLARE', true),
                    'type' => env('RABBITMQ_FANOUT_EXCHANGE_TYPE', 'fanout'),
                    'passive' => env('RABBITMQ_FANOUT_EXCHANGE_PASSIVE', false),
                    'durable' => env('RABBITMQ_FANOUT_EXCHANGE_DURABLE', true),
                    'auto_delete' => env('RABBITMQ_FANOUT_EXCHANGE_AUTODELETE', false),
                    'arguments' => env('RABBITMQ_FANOUT_EXCHANGE_ARGUMENTS'),
                ],
                'ssl_options' => [
                   'cafile' => env('RABBITMQ_FANOUT_SSL_CAFILE', null),
                   'local_cert' => env('RABBITMQ_FANOUT_SSL_LOCALCERT', null),
                   'local_key' => env('RABBITMQ_FANOUT_SSL_LOCALKEY', null),
                   'verify_peer' => env('RABBITMQ_FANOUT_SSL_VERIFY_PEER', true),
                   'passphrase' => env('RABBITMQ_FANOUT_SSL_PASSPHRASE', null),
               ],
           ],
       
           /*
            * Set to "horizon" if you wish to use Laravel Horizon.
            */
           'worker' => env('RABBITMQ_FANOUT_WORKER', 'default'),
            
        ],
        
    ],

    /*
    |--------------------------------------------------------------------------
    | Failed Queue Jobs
    |--------------------------------------------------------------------------
    |
    | These options configure the behavior of failed queue job logging so you
    | can control which database and table are used to store the jobs that
    | have failed. You may change them to any database / table you wish.
    |
    */

    'failed' => [
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => env('QUEUE_FAILED_TABLE', 'failed_jobs'),
    ],

];
