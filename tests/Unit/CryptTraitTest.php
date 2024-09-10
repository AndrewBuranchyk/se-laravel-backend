<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Traits\Crypt;

class CryptTraitTest extends TestCase
{
    use Crypt;

    public function test_encryptStr(): void
    {
        $item = 'Password';
        $result = $this->encryptStr($item);
        $this->assertIsString($result);
        print('Result: ' . $result);
    }

    public function test_decryptStr(): void
    {
        $item = 'RrhnSPwekZEEQiwIoO9TzFQuufgGr4x0UBYEOkrDu1w=';
        $result = $this->decryptStr($item);
        $this->assertIsString($result);
        print('Result: ' . $result);
    }
}
