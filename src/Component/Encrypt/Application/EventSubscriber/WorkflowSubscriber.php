<?php

namespace App\Encrypt\Application\EventSubscriber;

use App\AppBundle\Entity\Log;
use App\Encrypt\Domain\Model\EncryptedData;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\EnteredEvent;
use Symfony\Component\Workflow\Event\TransitionEvent;

class WorkflowSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly LoggerInterface $mainLogger,
        private readonly ManagerRegistry $doctrine
    ) {
    }

    /** @return string[] */
    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.encrypt.entered' => 'entered',
            'workflow.encrypt.transition' => 'transition',
        ];
    }

    /** @SuppressWarnings(PHPMD.MissingImport) */
    public function entered(EnteredEvent $event): void
    {
        $event->getSubject() instanceof EncryptedData or throw new \RuntimeException('Event subject must be an instance of '.EncryptedData::class);
        $this->mainLogger->debug(EncryptedData::class.' entered in "'.($place = \array_key_first($event->getSubject()->getCurrentPlace())).'" place.');
        
        $log = (new Log())->setChannel('workflow')->setLevel(LogLevel::INFO)->setMessage('Encrypted data entered in '.$place);
        $this->doctrine->getManager()->persist($log);
        $this->doctrine->getManager()->flush();
    }

    /** @SuppressWarnings(PHPMD.MissingImport) */
    public function transition(TransitionEvent $event): void
    {
        $event->getSubject() instanceof EncryptedData or throw new \RuntimeException('Event subject must be an instance of '.EncryptedData::class);
    }
}
