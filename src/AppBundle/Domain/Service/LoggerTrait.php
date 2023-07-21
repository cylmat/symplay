<?php

namespace App\AppBundle\Domain\Service;

// Used with LoggerAwareInterface.
trait LoggerTrait
{
    protected LoggerInterface $logger;

    public function setLogger(LoggerInterface $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    public function getLogger(?string $channel = null): LoggerInterface
    {
        $logger = clone $this->logger;
        $channel ? $logger->setChannel($channel) : null;

        return $logger;
    }
}
