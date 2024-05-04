<?php
namespace Config;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\Auth;
use App\Filters\User;
use App\Filters\Vendor;
class Filters extends BaseConfig {
    public array $aliases = [
        'csrf' => CSRF::class,
        'toolbar' => DebugToolbar::class, 
        'honeypot' => Honeypot::class, 
        'invalidchars' => InvalidChars::class, 
        'secureheaders' => SecureHeaders::class, 
        'auth' => Auth::class,
        'user' => User::class,
        'vendor' => Vendor::class
        ];
    public array $globals = [
        'before' => 
        ['csrf' => 
             ['except' => 
                        [   /* customer App API*/
                            'api/v1/customer/generate_orderid',
                            'api/v1/customer/add_amount',
                            'api/v1/customer/search_cab',
                            'api/v1/customer/coupon_list',
                            'api/v1/customer/apply_coupon',
                            'api/v1/customer/create_booking',
                            'api/v1/customer/booking_list',
                            'api/v1/customer/booking_details',
                            'api/v1/customer/confirm_booking',
                            
                            
                            'api/cashfree_webhook',
                            'get-record-booking-conditions',
                        
                        ]
            ], 
        ], 'after' => 
        ['toolbar',
    // 'honeypot',
    // 'secureheaders',
        ], ];
    public array $methods = [];
    public array $filters = [];
}
