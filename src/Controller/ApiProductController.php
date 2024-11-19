<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\FournisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\ProductRepository;
use App\Repository\VilleRepository;

use App\Utils\Utils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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

    #[Route('/api/product/add', name: 'app_api_products_add')]
    public function AddProduct(Request $request, EntityManagerInterface $entityManager ) : JsonResponse
    {

        $data = json_decode($request->getContent(), true);
       
       $produit = new Product();
       $produit->setName($data['name']);
       $produit->setDescription($data['description']);
       $produit->setPrice($data['price']);

       $entityManager->persist($produit);
       $entityManager->flush();
       return $this->json(['message' => 'Produit créé avec succès.'], Response::HTTP_CREATED);
    }

    #[Route('/api/villes', name: 'app_api_villes')]
    public function getVilles(Request $request,VilleRepository $villeRepository)
    {
        $response =new Utils();
       $villes = $villeRepository->findAll();
       return $response->GetJsonResponse($request,$villes);
    }
    #[Route('/api/fournisseurs', name: 'app_api_fournisseurs')]
    public function getFournisseurs(Request $request,FournisseurRepository $fournisseurRepository)
    {
        $response =new Utils();
       $fournisseurs = $fournisseurRepository->findAll();
       return $response->GetJsonResponse($request,$fournisseurs);
    }
}
