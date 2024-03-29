<?php

declare(strict_types=1);

namespace App\Text\Application;

use App\AppBundle\Application\Common\AbstractAction;
use App\AppBundle\Application\Common\AppRequest;
use App\Text\Domain\Manager\CommandManager;

final class TextAction extends AbstractAction
{
    public function __construct(
        private readonly CommandManager $cmdManager,
    ) {
    }

    public function execute(AppRequest $request): TextResponse
    {
        $model = $this->cmdManager->processText($request->text, $request->commands);

        return new TextResponse($model);
    }
}
