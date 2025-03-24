<?php
return [
    'paths' => ['api/*'], // Aktifkan CORS hanya untuk API
    'allowed_methods' => ['*'], // Izinkan semua metode (GET, POST, PUT, DELETE)
    'allowed_origins' => ['*'], // Izinkan semua domain (ganti jika perlu)
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Izinkan semua header
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false, // Set true jika butuh cookie/auth header
];
