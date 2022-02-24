<?php

namespace App\Controller;

use App\Entity\Bookmark;
use App\Entity\Topic;


use App\Form\TopicType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum")
     */
    public function forum(): Response
    {
        /* $forum=new Topic();
         $forums=$this->createForm(TopicType::class,$forum);*/
        $forums = $this->getDoctrine()->getRepository(Topic::class)->findAll();

        return $this->render('Front/Forum/forum.html.twig', ["data" => $forums]);
    }


    /**
     * @Route("/inbox", name="inbox")
     */
    public function inbox(): Response
    {
        return $this->render('Front/Forum/inbox.html.twig');
    }

    /**
     * @Route("/dicussion", name="discussion")
     */
    public function discussion(): Response
    {
        return $this->render('Front/Forum/discussion.html.twig');
    }

    /**
     * @Route("/detailC/{id}", name="detailC")
     */
    public function detailC($id): Response
    {
        return $this->render('Front/Forum/Forum_details.html.twig',['id'=>$id]);
    }


    /**
     * @Route("/addFSt", name="addFSt")
     */
    public function addFSt(Request $request): Response
    {
        $forum = new Topic();
        $forums = $this->createForm(TopicType::class, $forum);
        $forums->handleRequest($request);
        if ($forums->isSubmitted() ) {
            $uploadedFile = $forums['image']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '\public\upload\forum';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename. '.' . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename);
                $forum->setImage($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($forum);
            $em->flush();
            return $this->redirectToRoute('forum');
        }


        return $this->render('Front/Forum/addForumSt1.html.twig', array('form' => $forums->createView())
        );


    }
    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request,$id): Response
    {
        $forums = $this->getDoctrine()->getRepository(Topic::class)->find($id);
        $form = $this->createForm(TopicType::class, $forums);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('forum');
        }

        return $this->render('Front/Forum/edit_Topic.twig',array('form'=>$form->createView()));
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id):Response
    {

        $result=$this->getDoctrine()->getRepository(Topic::class)->find($id);

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($result);
        $entityManager->flush();

        return $this->redirectToRoute('forum');


    }

    /**
     * @Route("/love/{id}", name="love")
     */
    public function love($id): Response
    {

        $forums = $this->getDoctrine()->getRepository(Topic::class)->find($id);
        $integer = intval($forums->getBookmark()) + 1;
           $book=new Bookmark();


        $forums->setBookmark($integer);
         $book->addTopic($forums);
        $em = $this->getDoctrine()->getManager();
        $em->persist($book);
        $em->flush();

        return $this->redirectToRoute("forum");
    }
    /**
     * @Route("/bookmark/{id}", name="bookmark")
     */
    public function bookmark($id): Response{

        $books=new Bookmark();
        $book=$this->getDoctrine()->getRepository(Topic::class)->find($id);
        $book=$this->getDoctrine()->getRepository(Topic::class)->findAll();

        $booked=$books->getTopic();


        return $this->render('Front/Forum/bookmarks.html.twig',["data"=>$book]);
    }
}
