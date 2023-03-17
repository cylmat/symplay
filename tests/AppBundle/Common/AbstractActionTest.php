<?php

namespace App\Test\AppBundle\Common;

use App\AppBundle\Common\AbstractAction;
use App\AppBundle\Common\AppRequest;
use PHPUnit\Framework\TestCase;

final class AbstractActionTest extends TestCase
{
    private AbstractAction $abstractAction;

    protected function setUp(): void
    {
        $this->abstractAction = $this->getMockBuilder(AbstractAction::class)
            ->setConstructorArgs([])
            ->getMockForAbstractClass();

        $this->abstractAction
            ->method('execute')
            ->with(new AppRequest(['val']))
            ->willReturn('test-ok');
    }

    public function testExecute(): void
    {
        $request = new AppRequest(['val']);
        $this->assertSame('test-ok', $this->abstractAction->execute($request));
    }

    public function testExecuteRequest(): void
    {
        $this->assertSame('test-ok', $this->abstractAction->executeRequest(['val']));
    }
}
