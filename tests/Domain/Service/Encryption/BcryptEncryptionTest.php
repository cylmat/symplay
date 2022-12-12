<?php

namespace App\Domain\Service\Encryption;

use App\Domain\Model\EncryptedData;
use App\Domain\Service\Encryption\BcryptEncryption;
use PHPUnit\Framework\TestCase;

final class BcryptEncryptionTest extends TestCase
{
    private BcryptEncryption $bcryptEncryption;

    protected function setUp(): void
    {
        $this->bcryptEncryption = new BcryptEncryption();
    }

    public function testEncrypt(): void
    {
        $this->assertInstanceOf(EncryptedData::class, $this->bcryptEncryption->encrypt('value', []));
    }
}