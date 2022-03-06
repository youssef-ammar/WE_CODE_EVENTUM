<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Event;
use App\Entity\Produit;
use App\Form\EventType;
use App\Form\ProduitType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/admin", name="event_index", methods={"GET"})
     */
    public function index(Request $request,PaginatorInterface $paginator): Response
    { $donnees = $this->getDoctrine()->getRepository(Event::class)->findAll();
        $events = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }
    /**
     * @Route("/home", name="event_home", methods={"GET"})
     */
    public function index2(Request $request,PaginatorInterface $paginator): Response
    { $donnees = $this->getDoctrine()->getRepository(Event::class)->findAll();
        $events = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('event/homeevent.html.twig', [
            'events' => $events,
        ]);
    }
    /**
     * @Route("/partenaire", name="profile", methods={"GET"})
     */
    public function index3(Request $request,PaginatorInterface $paginator): Response
    { $donnees = $this->getDoctrine()->getRepository(Event::class)->findAll();
        $events = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('Profile.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['image']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/upload';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename. '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename);
                $event->setImage($newFilename);

            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/new/part", name="add_part", methods={"GET","POST"})
     */
    public function new1(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['image']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/upload';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename. '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename);
                $event->setImage($newFilename);

            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event/add_front.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit/", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);// creation formulaire
        $form->handleRequest($request);
        $oldFileName = $event->getImage();
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['image']->getData();

            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/upload';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename =$originalFilename. '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $event->setImage($newFilename);
            }
            else{
                $event->setImage($oldFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
            return $this->redirectToRoute('event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event/edit.html.twig', [
            'events' => $event,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}/edit/part", name="part_edit", methods={"GET","POST"})
     */
    public function  part(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event/edit_front.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }
    /**
     * @Route("part/{id}", name="event_show_part", methods={"GET"})
     */
    public function partshow(Event $event): Response
    {
        return $this->render('event/show_front.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="event_delete")
     */
    public function deleteeventadmin(Request $request,$id)
    {

        $result=$this->getDoctrine()->getRepository(Event::class)->find($id);

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($result);
        $entityManager->flush();
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('event_index');


    }
    /**
     * @Route("/delete/part/{id}", name="event_del_part")
     */
    public function deleteeventpart(Request $request,$id)
    {

        $result=$this->getDoctrine()->getRepository(Event::class)->find($id);

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($result);
        $entityManager->flush();
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('profile');


    }
}
