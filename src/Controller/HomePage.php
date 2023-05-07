<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomePage extends AbstractController
{
    #[Route('/')]
    public function show()
    {
        return $this->render('index.html.twig', ['name' => 'Le yopi !' ]);
    }
}