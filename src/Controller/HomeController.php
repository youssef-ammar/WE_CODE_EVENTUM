<?php

namespace App\Controller;

use App\Entity\Voyage;
use App\Form\VoyageType;
use App\Repository\VoyageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/invoice", name="invoice")
     */
    public function home(): Response
    {
        return $this->render('Front/voyage/invoice.html.twig');
    }
    /**
     * @Route("/voy", name="voy")
     */
    public function voy(): Response
    {
        return $this->render('Front/voyage/voyage_details.html.twig');
    }
    /**
     * @Route("/voyage", name="voyage", methods={"GET"})
     */
    public function voyage(VoyageRepository $voyageRepository): Response
    {
        return $this->render('Front/voyage/index.html.twig', [
            'voyages' => $voyageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/voyage/front", name="voyageFront", methods={"GET"})
     */
    public function voyageFront(VoyageRepository $voyageRepository): Response
    {
        return $this->render('Front/travel.html.twig', [
            'voyages' => $voyageRepository->findAll(),
        ]);
    }
    /**
     * @Route("/new", name="voyageNew", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voyage = new Voyage();
        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['image_voy']->getData();
            if ($uploadedFile) {
                $image = $this->getParameter('kernel.project_dir').'/public/upload';
                $originalFilename=pathinfo($uploadedFile->getClientOriginalName(),PATHINFO_FILENAME);
                $newFilename=$originalFilename. '-' .uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move(
                    $image,
                    $newFilename
                );
                $voyage->setImageVoy($newFilename);


            }

            $entityManager->persist($voyage);
            $entityManager->flush();


            return $this->redirectToRoute('voyage');
        }

        return $this->render('Front/voyage/new.html.twig', [
            'voyage' => $voyage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("voyageShow/{id}", name="voyageShow", methods={"GET"})
     */
    public function show(Voyage $voyage): Response
    {
        return $this->render('Front/voyage/show.html.twig', [
            'voyage' => $voyage,
        ]);
    }
    /**
     * @Route("voyage/{id}/edit", name="voyageEdit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Voyage $voyage, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);


        $oldFileName = $voyage->getImageVoy();
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['image_voy']->getData();

            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/upload';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename =$originalFilename. '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $voyage->setImageVoy($newFilename);
            }
            else{
                $voyage->setImageVoy($oldFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voyage);
            $entityManager->flush();
            return $this->redirectToRoute('voyage');
        }





        return $this->render('Front/voyage/edit.html.twig', [
            'voyage' => $voyage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("voyage/delete/{id}", name="voyageDelete")
     */
    public function delete(Request $request,$id)
    {

        $result=$this->getDoctrine()->getRepository(Voyage::class)->find($id);

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($result);
        $entityManager->flush();

        return $this->redirectToRoute('voyage');


    }
}
