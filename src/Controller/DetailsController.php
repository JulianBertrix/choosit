<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Produit;
use App\Entity\Panier;

class DetailsController extends AbstractController
{
    /**
     * @Route("/details/{id}", name="details")
     */
    public function index($id)
    {
        //récupération du produit
        $product = $this->getDoctrine()->getRepository(Produit::class)->find($id);
        return $this->render('details/index.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/add/product/{id}", name="add")
     */
    public function addToCart(Request $request, Session $session, $id)
    {
        //stockage de l'entity manager dans une variable "$em"
        $em = $this->getDoctrine()->getManager();

        //démarrage de la session
        $session->start();

        //récupération du produit a ajouter au panier
        $product = $this->getDoctrine()->getRepository(Produit::class)->find($id);
        
        //récupération des superglobals
        $post = $request->request->all();

        //si il n'existe aucune session nommée "panier"
        if(!$session->has('panier')){
            //creation d'un nouvel objet panier
            $panier = new Panier();
            $panier->setQuantite($post['qte']);
            $panier->setPrix($product->getPrix() * $post['qte']);
            $panier->setProduit($product->getNom());
            $em->persist($panier);
            $em->flush();

            //récupération des paniers
            $paniers = $this->getDoctrine()->getRepository(Panier::class)->findAll();

            //création d'une session "panier"
            $session->set('panier', $paniers);
        }else{
            //creation d'un nouvel objet panier
            $panier = new Panier();
            $panier->setProduit($product->getNom());
            $panier->setQuantite($post['qte']);
            $panier->setPrix($product->getPrix() * $post['qte']);
            $em->persist($panier);
            $em->flush();
            
            /*mise à jours de la quantité d'un produit existant sinon on le créer
            if($panier->getProduit() === $product->getNom()){
                $panier->setQuantite($panier->getQuantite() + $post['qte']);
                $em->merge($panier);
                $em->flush();                   
            }else{
                $panier->setQuantite($post['qte']);
                $panier->setPrix($product->getPrix() * $post['qte']);
                $em->persist($panier);
                $em->flush();
            }*/
        }

        //récupération des paniers
        $paniers = $this->getDoctrine()->getRepository(Panier::class)->findAll();

        $session->set('panier', $paniers);

        return new Response("ok");
    }
}
