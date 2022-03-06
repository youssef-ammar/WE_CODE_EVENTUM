<?php

namespace App\Controller;

use App\Entity\Camping;
use App\Entity\Event;
use App\Form\CampingType;
use App\Form\EventType;
use App\Repository\CampingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * @Route("/camping")
 */
class CampingController extends AbstractController
{
    /**
     * @Route("/admin", name="camping_index", methods={"GET"})
     */
    public function index(CampingRepository $campingRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Camping::class)->findAll();
        $camping = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('camping/index.html.twig', [
            'campings' => $camping,
        ]);
    }
    /**
 * @Route("/home", name="camping_index_home", methods={"GET"})
 */
    public function indexhome(CampingRepository $campingRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Camping::class)->findAll();
        $camping = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('camping/homecamping.html.twig', [
            'campings' => $camping,
        ]);
    }

    /**
     * @Route("/partenaire", name="camping_index_part", methods={"GET"})
     */
    public function indexpart(CampingRepository $campingRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Camping::class)->findAll();
        $camping = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('camping/profile.html.twig', [
            'campings' => $camping,
        ]);
    }

    /**
     * @Route("/new", name="camping_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $camp = new Camping();
        $form = $this->createForm(CampingType::class, $camp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['image']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/uploadcamp';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename. '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename);
                $camp->setImage($newFilename);

            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($camp);
            $entityManager->flush();

            return $this->redirectToRoute('camping_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('camping/new.html.twig', [
            'event' => $camp,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/new/part", name="camping_new_part", methods={"GET","POST"})
     */
    public function newpart(Request $request): Response
    {
        $camp = new Camping();
        $form = $this->createForm(CampingType::class, $camp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['image']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/uploadcamp';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename. '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename);
                $camp->setImage($newFilename);

            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($camp);
            $entityManager->flush();

            return $this->redirectToRoute('camping_index_part', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('camping/ajouter_part.html.twig', [
            'event' => $camp,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("admin/{id}", name="camping_show", methods={"GET"})
     */
    public function show(Camping $camping): Response
    {
        return $this->render('camping/show.html.twig', [
            'camping' => $camping,
        ]);
    }

    /**
     * @Route("part/{id}", name="camping_show_part", methods={"GET"})
     */
    public function showpart(Camping $camping): Response
    {
        return $this->render('camping/homedetail.html.twig', [
            'camping' => $camping,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="camping_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Camping $camping): Response
    {
        $form = $this->createForm(CampingType::class, $camping);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('camping_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('camping/edit.html.twig', [
            'camping' => $camping,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit/part", name="camping_edit_part", methods={"GET","POST"})
     */
    public function editpart(Request $request, Camping $camping): Response
    {
        $form = $this->createForm(CampingType::class, $camping);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('camping_index_part', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('camping/edit_part.html.twig', [
            'camping' => $camping,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="camping_delete")
     */
    public function deletecampadmin(Request $request,$id)
    {

        $result=$this->getDoctrine()->getRepository(Camping::class)->find($id);

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($result);
        $entityManager->flush();
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('camping_index');


    }
    /**
     * @Route("part/delete/{id}", name="camping_delete_part")
     */
    public function deletecamppart(Request $request,$id)
    {

        $result=$this->getDoctrine()->getRepository(Camping::class)->find($id);

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($result);
        $entityManager->flush();
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('camping_index_part');


    }
    /**
     * @Route ("/mapp")
     */
}
