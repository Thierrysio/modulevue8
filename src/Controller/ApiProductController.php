<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Utils\Utils;

class ApiProductController extends AbstractController
{
    #[Route('/api/product', name: 'app_api_product')]
    public function index(): Response
    {
        return $this->render('api_product/index.html.twig', [
            'controller_name' => 'ApiProductController',
        ]);
    }

    #[Route('/api/products', name: 'app_api_products')]
    public function getProducts(Request $request,ProductRepository $productRepository)
    {
        $response =new Utils();
       $produits = $productRepository->findAll();
       return $response->GetJsonResponse($request,$produits);
    }
}
