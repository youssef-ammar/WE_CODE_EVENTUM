<?php

namespace App\Controller;

use App\Entity\CarteFidelite;
use App\Entity\Utilisateur;
use App\Form\CarteFideliteType;
use App\Form\UtilisateurType;
use App\Repository\CarteFideliteRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CarteFideliteController extends AbstractController
{
    /**
     * @Route("/carte/fidelite", name="carte_fidelite")
     */
    public function index(): Response
    {
        return $this->render('carte_fidelite/index.html.twig', [
            'controller_name' => 'CarteFideliteController',
        ]);
    }

    /**
     * @Route("/affichercartes",name="affichercartes")
     */
    public function afficherusers   (CarteFideliteRepository $repository){
        $tablecartes=$repository->findAll();
        return $this->render('carte_fidelite/affichercartes.html.twig'
            ,['tablecartes'=>$tablecartes]);

    }

    /**
     * @Route("/ajoutercarte", name="ajoutercarte")

     */
    public function ajoutercarte(Request $request)
    {

        $carte  = new CarteFidelite() ;
        $form= $this->createForm(CarteFideliteType::class,$carte);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $new=$form->getData();

            $em= $this->getDoctrine()->getManager();
            $em->persist($carte);
            $em->flush();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute("affichercartes");


        }
        return $this->render("carte_fidelite/ajoutercarte.html.twig",array("form"=>$form->createView()));
    }

    /**
     * @Route("/supprimercarte/{id}",name="supprimercarte")
     */
    public function supprimercarte($id,EntityManagerInterface $em ,CarteFideliteRepository $repository){
        $carte=$repository->find($id);
        $em->remove($carte);
        $em->flush();

        return $this->redirectToRoute('affichercartes');
    }



    /**
     * @Route("/{id}/modifiercarte", name="modifiercarte", methods={"GET","POST"})
     */
    public function modifiercarte(Request $request, CarteFidelite $carte): Response
    {
        $form = $this->createForm(CarteFideliteType::class, $carte);


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('affichercartes');
        }

        return $this->render('carte_fidelite/modifiercarte.html.twig', [
            'carte' => $carte,
            'form' => $form->createView(),
        ]);
    }



}
