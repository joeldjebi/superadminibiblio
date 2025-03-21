<?php

namespace App\Services;

use Exception;

class CustomEncryptor
{
    private $key;

    public function __construct()
    {
        // Charger la clé personnalisée depuis le fichier .env
        $this->key = base64_decode(env('CUSTOM_CRYPT_KEY'));

        if (!$this->key || strlen($this->key) !== 32) {
            throw new Exception("Clé de cryptage personnalisée invalide ou manquante.");
        }
    }

    /**
     * Chiffre une chaîne de caractères.
     *
     * @param string $data Les données à chiffrer
     * @return string Les données chiffrées
     * @throws Exception
     */
    public function encrypt(string $data): string
    {
        $iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $this->key, 0, $iv);

        if ($encrypted === false) {
            throw new Exception("Erreur lors du chiffrement des données.");
        }

        // Concaténer l'IV et les données chiffrées, puis encoder en base64
        return base64_encode($iv . $encrypted);
    }

    /**
     * Déchiffre une chaîne de caractères.
     *
     * @param string $encryptedData Les données chiffrées
     * @return string Les données déchiffrées
     * @throws Exception
     */
    public function decrypt(string $encryptedData): string
    {
        $data = base64_decode($encryptedData);
        $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($data, 0, $ivLength);
        $encrypted = substr($data, $ivLength);

        $decrypted = openssl_decrypt($encrypted, 'aes-256-cbc', $this->key, 0, $iv);

        if ($decrypted === false) {
            throw new Exception("Erreur lors du déchiffrement des données.");
        }

        return $decrypted;
    }
}