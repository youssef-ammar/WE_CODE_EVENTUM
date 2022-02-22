<?php

namespace App\Controller;

use App\Entity\ReservationCamp;
use App\Form\ReservationCampType;
use App\Repository\ReservationCampRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservation/camp")
 */
class ReservationCampController extends AbstractController
{
    /**
     * @Route("/", name="reservation_camp_index", methods={"GET"})
     */
    public function index(ReservationCampRepository $reservationCampRepository): Response
    {
        return $this->render('reservation_camp/index.html.twig', [
            'reservation_camps' => $reservationCampRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="reservation_camp_new", methods={"GET","POST"})
     */
    public function new(Request $request,$id): Response
    {
        $reservationCamp = new ReservationCamp();
        $form = $this->createForm(ReservationCampType::class, $reservationCamp);
        $form->handleRequest($request);
        $reservationCamp.setCamping(1);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservationCamp);
            $entityManager->flush();


            return $this->redirectToRoute('reservation_camp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation_camp/new.html.twig', [
            'reservation_camp' => $reservationCamp,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_camp_show", methods={"GET"})
     */
    public function show(ReservationCamp $reservationCamp): Response
    {
        return $this->render('reservation_camp/show.html.twig', [
            'reservation_camp' => $reservationCamp,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_camp_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ReservationCamp $reservationCamp): Response
    {
        $form = $this->createForm(ReservationCampType::class, $reservationCamp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_camp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation_camp/edit.html.twig', [
            'reservation_camp' => $reservationCamp,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_camp_delete", methods={"POST"})
     */
    public function delete(Request $request, ReservationCamp $reservationCamp): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationCamp->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservationCamp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_camp_index', [], Response::HTTP_SEE_OTHER);
    }
}
