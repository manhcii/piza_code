<?php

namespace App;

class Consts
{
    const SET_TIME = [
        365 * 24 * 60 * 60  =>  'year',
        30 * 24 * 60 * 60  =>  'month',
        24 * 60 * 60  =>  'day',
        60 * 60  =>  'hour',
        60  =>  'min',
        1  =>  'sec'
    ];
    const TIME_NAME = [
        'year'  => 'year',
        'month' => 'month',
        'day' => 'day',
        'hour'  => 'hour',
        'min' => 'min',
        'sec' => 'sec'
    ];

    const MONTH = [
        '1'=>'January',
        '2'=>'February',
        '3'=>'March',
        '4'=>'April',
        '5'=>'May',
        '6'=>'June',
        '7'=>'July',
        '8'=>'August',
        '9'=>'September',
        '10'=>'October',
        '11'=>'November',
        '12'=>'December'
    ];
    // For delete some data
    const STATUS_DELETE = 'delete';
    // Loại liên hệ
    const CONTACT_TYPE = [
        'contact' => 'contact',
        'faq' => 'faq',
        'newsletter' => 'newsletter',
        'advise' => 'advise',
        'call_request' => 'call_request'
    ];
    const CONTACT_STATUS = [
        'new' => 'new',
        'processing' => 'processing',
        'processed' => 'processed',
        'cancel' => 'cancel'
    ];
    // Status for users
    const USER_STATUS = [
        'pending' => 'pending',
        'active' => 'active',
        'deactive' => 'deactive',
        'delete' => 'delete'
    ];
    const ORDER_TYPE = [
        'product' => 'product',
        'service' => 'service',
    ];
    // Status for order
    const ORDER_STATUS = [
        '0' => 'Processing ',
        '1' => 'Completed',
        '2' => 'Cancel',
    ];
    const PAYMENT_STATUS = [
        '0' => 'Unpaid ',
        '1' => 'Paid'
    ];
    // Status for ship
    const TYPE_SHIPING = [
        'price' => 'Based on products price',
        // 'weight' => 'Based on products weight',
    ];
    // Status for discoutn
    const TYPE_DISCOUNT = [
        'money' => 'Money discount ($)',
        'pecent' => 'Percentage discount (%)',
        // 'free_ship' => 'Free Shipping',
    ];
    const APPLY_FOR = [
        'all-orders' => 'All orders',
        'amount-minimum-order' => 'Order amount from',
        'specific-product' => 'Product',
        'category-product' => 'Product Category',
        'customer' => 'Customer',
    ];
    // Status for taxonomy
    const TAXONOMY_STATUS = [
        'active' => 'active',
        'deactive' => 'deactive'
    ];
    // Style for header
    const STYLE_HEADER = [
        'header-nav-button' => 'Menu Butom',
        'image' => 'Menu Image',
    ];

    // Status for taxonomy
    const POST_STATUS = [
        'published' => 'published',
        'draff' => 'draff',
        'approved' => 'approved',
    ];

    // Status for general
    const STATUS = [
        'active' => 'active',
        'deactive' => 'deactive',
        'delete' => 'delete'
    ];

    const PAGINATE = [
        'post' => 8,
        'product' =>9,
        'sidebar' => 4,
        'search' => 8,
    ];
    const DEFAULT_PAGINATE_LIMIT = 20;

    const TITLE_BOOLEAN = [
        '1' => 'true',
        '0' => 'false'
    ];

    const TAXONOMY = [
        'post' => 'post',
        'product' => 'product',

    ];
    // Define all route for taxonomy
    const ROUTE_TAXONOMY = [
        'post' => 'category',
        'product' => 'product-category',

    ];
    // Define all route for post
    const ROUTE_POST = [
        'post' => '',
        'product' => '',
    ];

    // Tạo danh sách chức năng định tuyến để gọi khi tạo trang trong admin -> người dùng có thể tùy chọn
    const ROUTE_NAME = [
        [
            "title" => "Home Page",
            "name" => "home.default",
            "template" => [
                [
                    "title" => "Home Default",
                    "name" => "home.default"
                ],
                [
                    "title" => "Home Category",
                    "name" => "home.category"
                ]
            ],
            "is_config" => true,
            "show_route" => true
        ],
        [
            "title" => "Product Page",
            "name" => "product.detail",
            "template" => [
                [
                    "title" => "Product Default",
                    "name" => "default"
                ]
            ],
            "is_config" => true
        ],
        [
            "title" => "Product Category Page",
            "name" => "product.category",
            "template" => [
                [
                    "title" => "product Category Default",
                    "name" => "default"
                ]
            ],
            "is_config" => true
        ],

        [
            "title" => "Post Page",
            "name" => "post.detail",
            "template" => [
                [
                    "title" => "Post default",
                    "name" => "default"
                ]
            ],
            "is_config" => true,
        ],
        [
            "title" => "Post Category Page",
            "name" => "post.category",
            "template" => [
                [
                    "title" => "Post Category Default",
                    "name" => "default"
                ]
            ],
            "is_config" => true
        ],
        [
            "title" => "Custom Page",
            "name" => "page.default",
            "template" => [
                [
                    "title" => "Page Default",
                    "name" => "page.default"
                ]
            ],
            "is_config" => true,
            "show_route" => true
        ],
        [
            "title" => "Service Page",
            "name" => "service.default",
            "template" => [
                [
                    "title" => "Service Default",
                    "name" => "service.default"
                ]
            ],
            "is_config" => true,
            "show_route" => true
        ],

    ];

    const ROUTE_SITEMAP = [
        [
            "name" => "pages",
            "time" => "2023-03-23 15:35:00",
        ],
        [
            "name" => "taxonomy",
            "time" => "2023-03-23 15:35:00",
        ],
        [
            "name" => "post",
            "time" => "2023-03-23 15:35:00",
        ]
    ];
}
