<?php

declare(strict_types=1);

namespace App\ApiResource\Application\Controller;

use App\ApiResource\Application\RandomApiAction;
use App\AppBundle\Application\Common\AppRequest;
use App\AppBundle\Application\OutputInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @see https://fosrestbundle.readthedocs.io */
#[Route('/')]
final class RandomApiController extends AbstractFOSRestController
{
    public function __invoke(RandomApiAction $action, OutputInterface $output): Response
    {
        $data = $action->execute(new AppRequest());
        $view = $this->view($data, Response::HTTP_OK);

        $response = $this->handleView($view);
        $output->validate($response->getContent());

        return $response;
    }
}
