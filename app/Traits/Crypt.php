<?php

namespace App\Traits;

trait Crypt
{
    public string $cipher = "AES-256-CBC";
    public string $key = '84d3326d233dd78ac3f1c89cb3feb7c5';
    public string $iv = 'iweb.couaLaravel';

    public function encryptStr(string $item = ''): false | string
    {
        if (!empty($item) && !empty($this->key) && strlen($this->iv)==16) {
            return openssl_encrypt($item, $this->cipher, $this->key,0, $this->iv);
        } else {
            return false;
        }
    }

    public function decryptStr(string $item = ''): false | string
    {
        if (!empty($item) && !empty($this->key) && strlen($this->iv)==16) {
            return openssl_decrypt($item, $this->cipher, $this->key,0, $this->iv);
        } else
            return false;
    }

    public function encodeArrayToStr($item = array()): string
    {
        if (!empty($item) && @is_array($item)){
            $item = @json_encode($item);
            $item = @base64_encode($item);
            return @urlencode($item);
        } else {
            return '';
        }
    }

    public function decodeStrToObject($item = ''): object
    {
        if (!empty($item) && @is_string($item)){
            $item = @urldecode($item);
            $item = @base64_decode($item);
            return @json_decode($item);
        } else
            return (object)[];
    }
}
