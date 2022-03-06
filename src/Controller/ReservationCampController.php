<?php

namespace App\Controller;

use App\Entity\Camping;
use App\Entity\ReservationCamp;
use App\Form\ReservationCampType;
use App\Repository\ReservationCampRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\DefaultController;
use App\Mail\Mailer;
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
     * @Route("/canfi", name="confirmation", methods={"GET"})
     */
    public function conf(ReservationCampRepository $reservationCampRepository): Response
    {
        return $this->render('reservation_camp/confirmer.html.twig');
    }
    /**
     * @Route("/new/{id}", name="reservation_camp_new", methods={"GET","POST"})
     */
    public function new(Request $request,$id): Response
    {
        $reservationCamp = new ReservationCamp();
        $form = $this->createForm(ReservationCampType::class, $reservationCamp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result=$this->getDoctrine()->getRepository(Camping::class)->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $reservationCamp->setCamping($result);
            $entityManager->persist($reservationCamp);
            $entityManager->flush();

            return $this->redirectToRoute('sendEmail');
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
     * @Route("/delete/{id}", name="res_delete")
     */
    public function delete(Request $request,$id)
    {

        $result=$this->getDoctrine()->getRepository(ReservationCamp::class)->find($id);

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($result);
        $entityManager->flush();
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('reservation_camp_index');
    }


    public function rechercheBYcamping()
    {
        $ReservationCamp=$this->getDoctrine()->getManager();
        $ReservationCamp = $ReservationCamp->getRepository(className:ReservationCamp::class)->findAll();
        return $this->render("reservation_camp/Recherche.html.twig",array('ReservationCamp'=>$ReservationCamp));
    }
    /**
     * @route("/sendEmail", name="sendEmail")
     */
    function sendEmail(Mailer $mailer){

        $mailer->sendEmail('isleemhamzi@gmail.com');
        $this->addFlash("success", "Réservation effectuée avec succès! Merci de consulter votre mail");
        return  $this->redirectToRoute('confirmation');
    }

}
