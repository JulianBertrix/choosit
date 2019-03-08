<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Produit;

class AdminController extends AbstractController
{
    /**
     * affiche la vue de la page admin
     * @Route("/admin", name="admin")
     */
    public function index()
    {
         //recupération des produits
        $products = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        return $this->render('admin/index.html.twig', [
            'produits' => $products,
        ]);
    }

    /**
     * permet de creer un nouveau produit
     * @Route("/create/prod", name="create_prod")
     */
    public function create(Request $request)
    {
        //stockage de l'entity manager dans une variable "$em"
        $em = $this->getDoctrine()->getManager();
        //recupération des superglobals
        $post = $request->request->all();

        //création d'un nouveau produit
        $product = new Produit();
        $product->setNom($post['nom']);
        $product->setDescription($post['description']);
        $product->setPrix($post['prix']);
        $em->persist($product);
        $em->flush();

        return new Response("ok");
    }

    /**
     * permet de modifier un produit
     * @Route("/update/prod/{id}", name="update_prod")
     */
    public function update(Request $request, $id)
    {
        //recupération du produit
        $product = $this->getDoctrine()->getRepository(Produit::class)->find($id);
        //stockage de l'entity manager dans une variable "$em"
        $em = $this->getDoctrine()->getManager();
        //recupération des superglobals
        $post = $request->request->all();

        //modification du produit
        $product->setNom($post['nom']);
        $product->setDescription($post['description']);
        $product->setPrix($post['prix']);
        $em->merge($product);
        $em->flush();

        return new Response("ok");
    }

    /**
     * permet de supprimer un produit
     * @Route("/delete/prod/{id}", name="delete_prod")
     */
    public function delete($id)
    {
        //recupération du produit
        $product = $this->getDoctrine()->getRepository(Produit::class)->find($id);
        //stockage de l'entity manager dans une variable "$em"
        $em = $this->getDoctrine()->getManager();
        //suppression du produit
        $em->remove($product);
        $em->flush();

        return new Response("ok");
    }

    /**
     * Point d'API qui retourne la totalité des produits en JSON
     * @Route("/api/get/prods", name="get_prods")
     */
    public function getProds()
    {
        $products = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        
        $json_prods = array();

        foreach($products as $value){
            array_push($json_prods, array(
                "nom" => $value->getNom(),
                "description" => $value->getDescription(),
                "prix" => $value->getPrix()
            ));
        }

        return $this->json($json_prods);
    }
}
