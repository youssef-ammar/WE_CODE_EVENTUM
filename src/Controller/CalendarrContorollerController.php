<?php

namespace App\Controller;

use App\Controller\SecurityController;
use App\Entity\Calendar;
use App\Entity\Event;
use App\Entity\Images;
use App\Entity\Utilisateur;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;
use App\Security\LoginFormAuthenticator;
use App\Security\SecurityExtension;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/calendarr/contoroller")
 */
class CalendarrContorollerController extends AbstractController
{
    /**
     * @Route("/", name="calendarr_contoroller_index", methods={"GET"})
     */
    public function index(CalendarRepository $calendarRepository): Response
    {

        return $this->render('calendarr_contoroller/index.html.twig', [
            'calendars' => $calendarRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="calendarr_contoroller_new", methods={"GET","POST"})
     */
    public function new(Request $request,$id): Response
    {

        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

            $result=$this->getDoctrine()->getRepository(Event::class)->find($id);
       // $user = (new SecurityController)->getUser();
       // $user = (new LoginFormAuthenticator)->getUser();

    //    dd($this->getUser());

            $calendar->setUtilisateur($this->getUser());
            $calendar->setStart($result->getDateDebut());
            $calendar->setEnd($result->getDateFin());
            $calendar->setTitle($result->getNom());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($calendar);
            $entityManager->flush();
        $this->addFlash('success','votre participation sera prise en charge ');
            return $this->redirectToRoute('calendar', [], Response::HTTP_SEE_OTHER);

    }


    /**
     * @Route("/{id}", name="calendarr_contoroller_show", methods={"GET"})
     */
    public function show(Calendar $calendar): Response
    {
        return $this->render('calendarr_contoroller/show.html.twig', [
            'calendar' => $calendar,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="calendarr_contoroller_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Calendar $calendar): Response
    {
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('calendarr_contoroller_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('calendarr_contoroller/edit.html.twig', [
            'calendar' => $calendar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calendarr_contoroller_delete", methods={"POST"})
     */
    public function delete(Request $request, Calendar $calendar): Response
    {
        if ($this->isCsrfTokenValid('delete'.$calendar->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($calendar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('calendarr_contoroller_index', [], Response::HTTP_SEE_OTHER);
    }
}
