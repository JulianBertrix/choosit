<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;

class HomeController extends AbstractController
{
    /**
     * affiche la vue de la page home 
     * @Route("/", name="home")
     */
    public function index()
    {
        //récupération des produits
        $products = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        return $this->render('home/index.html.twig', [
            'products' => $products,
        ]);
    }
}
