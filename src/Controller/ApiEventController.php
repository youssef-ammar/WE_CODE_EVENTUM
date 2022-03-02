<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;

class ApiEventController extends AbstractController
{
    /**
     * @Route("/api/event", name="api_event" , methods={"GET"})
     */
    public function index(EventRepository $repo): Response
    {
      /*  $event= $repo->findAll();
        $eventnormalises=$normalizable->normalize($event,null,['groups'=>'Event']);

        $json=json_encode($eventnormalises);
        $response= new Response($json,200,[
            "Content-type"=>"application/json"
        ]);
        return $response;
        */
                return $this->json($repo->findAll(),200,[],['groups'=>'Event']);

    }
    //http://127.0.0.1:8000/api/event
    /**
     * @Route("/api/event/{id}", name="api_event_supp",methods={"POST"}, requirements={"id"="\d+"})
     */

    public function deleteAction(Event $id)
    {
        $em=$this->getDoctrine()->getManager();

        $em->remove($id);
        $em->flush();
        return new JsonResponse(['msg' => 'event supprimé'],200);
    }

/**
 * @Route("/api/event", name="api_event_add",methods={"POST"})
 */
public function add(Request $request,SerializerInterface $serializer,EntityManagerInterface $em)
{
    $content= $request->getContent();
    $event = $serializer->deserialize($content, Event::class, 'json');

    $em->persist($event);
    $em->flush();
    return $this->json($event,201,[],['groups'=>'Event']);
}

}
