<?php

namespace App\PlayBundle\Service\Encryption;

use App\Encrypt\Domain\Model\EncryptedData;

class BcryptEncryption implements EncryptionInterface
{
    public function __construct(
        private readonly AppWorkflowInterface $encryptWorkflow,
    ) {
    }

    public function encrypt(string $value, array $options): EncryptedData
    {
        $encryptedData = new EncryptedData(\password_hash($value, PASSWORD_BCRYPT, $options));
        $this->encryptWorkflow->apply($encryptedData, EncryptedData::PROCESS_TRANSITION);

        return $encryptedData;
    }
}
