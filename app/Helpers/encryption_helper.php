<?php

if (!function_exists('base64_url_encode')) {
    function base64_url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}

if (!function_exists('base64_url_decode')) {
    function base64_url_decode($data) {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}

if (!function_exists('encrypt_data')) {
    function encrypt_data($plaintext, $key) {
        $cipher = "aes-256-cbc";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext = openssl_encrypt($plaintext, $cipher, $key, 0, $iv);
        return base64_url_encode($iv . $ciphertext);
    }
}

if (!function_exists('decrypt_data')) {
    function decrypt_data($ciphertext_base64, $key) {
        $cipher = "aes-256-cbc";
        $ciphertext = base64_url_decode($ciphertext_base64);
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = substr($ciphertext, 0, $ivlen);
        $ciphertext = substr($ciphertext, $ivlen);
        return openssl_decrypt($ciphertext, $cipher, $key, 0, $iv);
    }
}
