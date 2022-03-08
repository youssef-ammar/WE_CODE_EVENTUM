<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Calendar;
class CalenderapiController extends AbstractController
{
    /**
     * @Route("/api/{id}/edit", name="api_event_edit", methods={"PUT"})
     */
    public function majEvent(?Calendar $calendar, Request $request)
    {
        // On récupère les données
        $donnees = json_decode($request->getContent());

        if(
            isset($donnees->title) && !empty($donnees->title) &&
            isset($donnees->start) && !empty($donnees->start) &&
            isset($donnees->description) && !empty($donnees->description) &&
            isset($donnees->backgroudcolor) && !empty($donnees->backgroudcolor) &&
            isset($donnees->yes) && !empty($donnees->yes) &&
            isset($donnees->textcolor) && !empty($donnees->textcolor)
        ){
            // Les données sont complètes
            // On initialise un code
            $code = 200;

            // On vérifie si l'id existe
            if(!$calendar){
                // On instancie un rendez-vous
                $calendar = new Calendar;

                // On change le code
                $code = 201;
            }

            // On hydrate l'objet avec les données
            $calendar->setTitle($donnees->title);
            $calendar->setDescription($donnees->description);
            $calendar->setStart(new DateTime($donnees->start));
            if($donnees->allday){
                $calendar->setEnd(new DateTime($donnees->start));
            }else{
                $calendar->setEnd(new DateTime($donnees->end));
            }
            $calendar->setAllday($donnees->allday);
            $calendar->setBackgroudcolor($donnees->backgroudcolor);
            $calendar->setYes($donnees->yes);
            $calendar->setTextColor($donnees->textcolor);

            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();

            // On retourne le code
            return new Response('Ok', $code);
        }else{
            // Les données sont incomplètes
            return new Response('Données incomplètes', 404);
        }



    }
}
