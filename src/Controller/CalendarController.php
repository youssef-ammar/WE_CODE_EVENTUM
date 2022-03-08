<?php

namespace App\Controller;

use App\Entity\Calendar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CalendarRepository;
class CalendarController extends AbstractController
{

/**
     * @Route("/calendar", name="calendar")
     */
    public function index(CalendarRepository $calendar): Response
    {

        $user=$this->getUser();

        //dd($user->getId());
        $cal=$this->getDoctrine()->getRepository(Calendar::class)->findCal($user->getId());
      //  dd($cal);
        //$events = $calendar->findAll();
        $rdvs = [];
        foreach($cal as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'backgroudcolor' => $event->getBackgroudcolor(),
                'yes' => $event->getYes(),
                'textcolor' => $event->getTextcolor(),

            ];
        }

        $data = json_encode($rdvs);

        return $this->render('calendar/index.html.twig', compact('data'))
         ;
    }
}
