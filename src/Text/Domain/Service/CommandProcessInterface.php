<?php

namespace App\Text\Domain\Service;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/** @see https://symfony.com/doc/current/service_container/tags.html */
#[AutoconfigureTag('app.auto_command_process')]
interface CommandProcessInterface
{
    public const CMD = '';

    /** @param string[][] $args */
    public function processText(string $text, array $args): string;
}