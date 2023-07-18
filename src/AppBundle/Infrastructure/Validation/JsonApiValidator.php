<?php

namespace App\AppBundle\Infrastructure\Validation;

use App\AppBundle\Infrastructure\Contracts\JsonApiValidatorInterface;
use Art4\JsonApiClient\Exception\InputException;
use Art4\JsonApiClient\Exception\ValidationException;
use Art4\JsonApiClient\Input\ResponseStringInput;
use Art4\JsonApiClient\Manager\ErrorAbortManager;
use Art4\JsonApiClient\V1\Factory;

/** @see https://jsonapi.org/format */
final class JsonApiValidator implements JsonApiValidatorInterface
{
    public function validate(string $json): void
    {
        try {
            (new ErrorAbortManager(new Factory()))->parse(new ResponseStringInput($json));
        } catch (ValidationException $exception) {
            throw $exception; // Validation
        } catch (InputException $exception) {
            // Json format already processed by Symfony framework.
        }
    }
}
