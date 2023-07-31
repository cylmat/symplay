<?php

namespace App\Text\Application\Controller;

use App\Text\Application\TextAction;
use App\Text\Application\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TextController extends AbstractController
{
    #[Route('/text', name: 'app_text_index')]
    public function index(Request $request, TextAction $textAction): Response
    {
        $textForm = $this->createForm(TextType::class, null, []);
        $textForm->handleRequest($request);

        $result = null;
        /* @todo use Model */
        if ($textForm->isSubmitted() && $textForm->isValid()) {
            $result = $textAction->executeRequest([
                'text' => $textForm->get('text')->getData(),
                'commands' => [
                    $this->commandArguments(
                        'sed',
                        [
                            'pattern' => $textForm->get('pattern')->getData(),
                            'replace' => $textForm->get('replace')->getData(),
                        ]
                    ),
                ],
            ]);
        }

        return $this->render('text/index.html.twig', [
            'form' => $textForm,
            'result' => $result,
        ]);
    }

    /**
     * @param mixed[][] $arguments
     *
     * @return mixed[]
     */
    private function commandArguments(string $command, array $arguments): array
    {
        return [
            'cmd' => $command,
            'arguments' => $arguments,
        ];
    }
}