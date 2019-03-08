<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Panier;
use App\Entity\Produit;

class PanierController extends AbstractController
{
    /**
     * Affiche la vue du panier
     * @Route("/panier", name="panier")
     */
    public function index(Session $session)
    {
        //démarrage de la session
        $session->start();

        if($session->has('panier')){
            //recupération de la session "panier"
            $panier = $session->get('panier');

            //initialisation d'une variable "$total"
            $total = 0.0;

            for($i = 0; $i < sizeof($panier); $i++){
                //ajout des prix de chaque éléments de la session panier à la variable total
                $total += $panier[$i]->getPrix();     
            }
            
            return $this->render('panier/index.html.twig', [
                'panier' => $panier,
                'total' => $total
            ]);
        }
        return $this->render('panier/empty.html.twig');
    }

   /**
     * Permet de récupérer la totalité du panier
     * @Route("/get/cart", name="get_cart")
     */
    public function getCart(Session $session)
    {
        //démarrage de la session
        $session->start();

        //récuperation de la session "panier"
        $panier = $session->get('panier');

        return $this->json($panier);
    }

    /**
     * Permet de vider le panier
     * @Route("/clear/cart", name="clear")
     */
    public function clearCart(Session $session)
    {
        $paniers = $this->getDoctrine()->getRepository(Panier::class)->findAll();

        //démarrage de la session
        $session->start();

        //récuperation de la session "panier"
        $session->get('panier');
        //suppression de la session "panier"
        $session->clear();

        //suppression des objets paniers
        foreach($paniers as $value){
            $em = $this->getDoctrine()->getManager();
            $em->remove($value);
            $em->flush();
        }
        
        return new Response("votre panier est vide");
    }

    /**
     * Permet de supprimer un produit du panier
     * @Route("/delete/cart/prod/{id}", name="dcp")
     */
    public function deleteCartProd(Session $session, $id)
    {
        //démarrage de la session
        $session->start();

        $panier = $this->getDoctrine()->getRepository(Panier::class)->find($id);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($panier);
        $em->flush();
        
        $paniers = $this->getDoctrine()->getRepository(Panier::class)->findAll();
        $session->set("panier", $paniers);

        return new Response("ok");
    }

    /**
     * Permet d'enlever une unité à la quantité'
     * @Route("/sub/quantity/prod/{id}", name="sub_qte")
     */
    public function subQuantity(Session $session, $id)
    {
       //démarrage de la session
       $session->start();

       //recupération du panier et du produit par son nom
       $panier = $this->getDoctrine()->getRepository(Panier::class)->find($id);
       $produit = $this->getDoctrine()->getRepository(Produit::class)->findOneBy(['nom'=>$panier->getProduit()]);
       $em = $this->getDoctrine()->getManager();

       //on retire une unité à la quantité du produit au panier
       $panier->setQuantite($panier->getQuantite() - 1);
       //on recalcule le prix
       $panier->setPrix($produit->getPrix() * $panier->getQuantite());
       $em->merge($panier);

        //on retire le produit du panier si la quantité est inferieur ou égale à 0
        if($panier->getQuantite() <= 0){
            $em->remove($panier);
        }

       $em->flush();
    
       //on met à jour le nouveau panier
       $paniers = $this->getDoctrine()->getRepository(Panier::class)->findAll();
       $newPanier = $session->set('panier', $paniers);

       return $this->json($newPanier);
    }

    /**
     * Permet d'ajouter une unité à la quantité'
     * @Route("/add/quantity/prod/{id}", name="add_qte")
     */
    public function addQuantity(Session $session, $id)
    {
        //démarrage de la session
        $session->start();

        //recupération du panier et du produit par son nom
        $panier = $this->getDoctrine()->getRepository(Panier::class)->find($id);
        $produit = $this->getDoctrine()->getRepository(Produit::class)->findOneBy(['nom'=>$panier->getProduit()]);
        $em = $this->getDoctrine()->getManager();

        //on ajoute une unité à la quantité du produit au panier
        $panier->setQuantite($panier->getQuantite() + 1);
        //on recalcule le prix
        $panier->setPrix($produit->getPrix() * $panier->getQuantite());
        $em->merge($panier);
        $em->flush();

        //on met à jour le nouveau panier
        $paniers = $this->getDoctrine()->getRepository(Panier::class)->findAll();
        $newPanier = $session->set('panier', $paniers);

        return $this->json($newPanier);
    }
}
