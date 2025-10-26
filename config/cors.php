<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'https://developers.thebase.com',         // BASEプレビュー環境
        'https://admin.thebase.com',              // BASE管理画面
        'https://starringwhite.base.shop',        // 本番BASE
        'https://*.thebase.in',                   // 旧BASEドメイン
        'https://*.base.shop',                    // 新BASEドメイン
        'https://dev.starringwhite.navi.jpn.com', // Laravel開発ドメイン
    ],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false, // BASEとのCORSはcookie不要なので false
];