<?php

namespace App\ApiResource\Application\Controller;

use App\ApiResource\Application\RandomApiAction;
use App\AppBundle\Application\Common\AppRequest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @see https://fosrestbundle.readthedocs.io */
class RandomApiController extends AbstractFOSRestController
{
    #[Route('/')]
    public function getRandomIntAction(RandomApiAction $action): Response
    {
        $data = $action->execute(new AppRequest());
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }
}