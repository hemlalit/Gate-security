<?php

$key = 'vazeCollege@mulund';

function encryptData($data, $key)
{
    $method = 'AES-128-CBC';
    
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
    $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}


function decryptData($data, $key)
{
    $method = 'AES-128-CBC';

    try {
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);

        // Check if IV length is valid before attempting decryption
        if (strlen($iv) !== openssl_cipher_iv_length($method)) {
            throw new Exception('Invalid IV length.');
        }

        $decrypted = openssl_decrypt($encrypted_data, $method, $key, 0, $iv);

        // If decryption fails, throw an exception
        if ($decrypted === false) {
            throw new Exception('Decryption failed.');
        }

        return $decrypted;
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Decryption error: " . $e->getMessage());

        // Return a default value or handle the error gracefully
        return null; // or return a specific value indicating failure
    }
}
