<?php

namespace App\Test\Encrypt\Application\Listener;

use App\Encrypt\Application\Listener\WorkflowListener;
use App\Encrypt\Domain\Model\EncryptedData;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Workflow\Event\EnteredEvent;
use Symfony\Component\Workflow\Event\TransitionEvent;
use Symfony\Component\Workflow\Marking;

final class WorkflowListenerTest extends TestCase
{
    private WorkflowListener $workflowListener;

    /**
     * Sample
     * @requires PHP >= 8
     */
    protected function setUp(): void
    {
        $this->workflowListener = new WorkflowListener();
    }

    public function testGetSubscribedEvents(): void
    {
        $this->assertIsArray($this->workflowListener->getSubscribedEvents());
    }

    public function testEntered(): void
    {
        $event = new EnteredEvent(new EncryptedData(''), new Marking());
        $this->assertNull($this->workflowListener->entered($event));

        $this->expectException(\RuntimeException::class);
        $event = new EnteredEvent(new \stdClass(), new Marking());
        $this->workflowListener->entered($event);
    }

    public function testTransition(): void
    {
        $event = new TransitionEvent(new EncryptedData(''), new Marking());
        $this->assertNull($this->workflowListener->transition($event));

        $this->expectException(\RuntimeException::class);
        $event = new TransitionEvent(new \stdClass(), new Marking());
        $this->workflowListener->transition($event);
    }
}