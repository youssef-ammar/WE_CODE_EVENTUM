<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Event;
use App\Entity\Images;
use App\Entity\Produit;
use App\Form\EventType;
use App\Form\ProduitType;
use App\Repository\EventRepository;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\SerializerInterface;

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
    {
        //klwxcjdddddddddddddddddddddddddddddddddddddddddddddd
        $donnees = $this->getDoctrine()->getRepository(Event::class)->findAll();
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
    {
        //kllknddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
        $donnees = $this->getDoctrine()->getRepository(Event::class)->findAll();
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
            $images = $form->get('images')->getData();

            // On boucle sur les images
            foreach($images as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new Images();
                $img->setNom($fichier);
                $event->addImage($img);
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
            $images = $form->get('images')->getData();

            // On boucle sur les images
            foreach($images as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new Images();
                $img->setNom($fichier);
                $event->addImage($img);
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
     * @Route("/{id}/edit/", name="annonces_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {


            $form = $this->createForm(EventType::class, $event);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // On récupère les images transmises
                $images = $form->get('images')->getData();

                // On boucle sur les images
                foreach ($images as $image) {
                    // On génère un nouveau nom de fichier
                    $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                    // On copie le fichier dans le dossier uploads
                    $image->move(
                        $this->getParameter('images_directory'),
                        $fichier
                    );

                    // On stocke l'image dans la base de données (son nom)
                    $img = new Images();
                    $img->setNom($fichier);
                    $event->addImage($img);
                }

                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('event_index');
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
//$result->removeImage($result->getImages());
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

    /**
     * @Route("/supprime/image/{id}", name="annonces_delete_image" )
     */
    public function deleteImage(Images $image, Request $request){
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide

            // On récupère le nom de l'image
            $nom = $image->getNom();
            // On supprime le fichier
            unlink($this->getParameter('images_directory').'/'.$nom);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
        return new JsonResponse(['success'=>1]);
    }

}
