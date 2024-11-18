<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestVueController extends AbstractController
{
    #[Route('/test/vue', name: 'app_test_vue')]
    public function index(): Response
    {
        return $this->render('test_vue/index.html.twig', [
            'controller_name' => 'TestVueController',
        ]);
    }
}
