<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Student;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie")
 */
class CategorieController extends AbstractController
{
    /**
     * @Route("/", name="categorie_index", methods={"GET"})
     */
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="categorie_new")
     * Method({"GET","POST"})
     */
    public function new(Request $request)
    {
        $categorie = new Categorie();
        $form = $this->createFormBuilder($categorie)
            ->add('nom', TextType::class)
            ->add('description', TextType::class)
            ->add('ajouter', SubmitType::class, array('label' => 'ajouter')
            )->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Student = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Student);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_index');

        }
        return $this->render('categorie/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/{id}", name="categorie_show", methods={"GET"})
     */
    public function show(Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }



    /**
     * @Route("/delete/{id}", name="categorie_delete")
     */
    public function delete(Request $request,$id)
    {

        $result=$this->getDoctrine()->getRepository(Categorie::class)->find($id);

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($result);
        $entityManager->flush();
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('categorie_index');


    }
    /**
     * @Route("/edit/{id}", name="categorie_edit")
     * Method({"GET","POST"})
     */

    public function edit(Request $request,$id){

        $categorie=$this->getDoctrine()->getRepository(Categorie::class)->find($id);
        $form =$this->createFormBuilder($categorie)
            ->add('nom', TextType::class)
            ->add('description',TextType::class)

            ->add('save', SubmitType::class, array('label'=>'Modifier'
            ))->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $categorie = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            return $this->redirectToRoute('categorie_index');
        }
        return $this->render('categorie/edit.html.twig', ['form' => $form->createView()]);



    }

}
