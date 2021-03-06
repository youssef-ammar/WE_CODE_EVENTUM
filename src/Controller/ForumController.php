<?php

namespace App\Controller;

use App\Entity\Bookmark;

use App\Entity\Comment;
use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\Topic;
use App\Entity\Utilisateur;
use App\Form\CommentType;
use App\Form\MessageType;
use App\Form\TopicType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum/{lang}", name="forum")
     */
    public function forum(TranslatorInterface $translator, $lang): Response
    {
        /* $forum=new Topic();
         $forums=$this->createForm(TopicType::class,$forum);*/
        $this->transl($translator, $lang);
        $forums = $this->getDoctrine()->getRepository(Topic::class)->findAll();

        return $this->render('Front/Forum/forum.html.twig', ["data" => $forums, "lang" => $lang]);
    }

    public function transl(TranslatorInterface $translator, $id)
    {
        if ($id == "fr") {
            $translator->setLocale("fr");

        } else if ($id == "ar") {
            $translator->setLocale("ar");
        } else if ($id == "en") {
            $translator->setLocale("en");
        }
    }





    /*
     * @Route("/base/{lang}", name="base")

    public function indexBase(TranslatorInterface $translator, $lang): Response
    {
        $this->transl($translator, $lang);

        return $this->render('Front/Forum/base.html.twig', [
            "lang" => $lang

        ]);
    }
  */

    /**
     * @Route("/inbox/{lang}", name="inbox")
     */
    public function inbox(TranslatorInterface $translator, $lang): Response
    {
        $this->transl($translator, $lang);

        return $this->render('Front/Forum/inbox.html.twig', [
            "lang" => $lang
        ]);
    }

    /**
     * @Route("/dicussion/{lang}", name="discussion")
     */
    public function discussion(TranslatorInterface $translator, $lang,Request $request): Response
    {

        $this->transl($translator, $lang);
        $message = new Message();

      /*  $conversation = $this->getDoctrine()->getRepository(Conversation::class)->findConversationByParticipants($id,$id1);

        if (count($conversation)) {
            throw new \Exception("The conversation already exists");
        }*/
        $form = $this->createForm(MessageType::class, $message);
        $user1 = $this->getDoctrine()->getRepository(Utilisateur::class)->find(1);
$user2=$this->getDoctrine()->getRepository(Utilisateur::class)->find(2);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $message->setSender($user1);
            $message->setRecipient($user2);

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->addFlash("message", "Message envoy?? avec succ??s.");
            return $this->redirectToRoute('discussion', array("lang" => $lang));
        }



        $dataS=$this->getDoctrine()->getRepository(Message::class)->findSend($user1);

        $dataR=$this->getDoctrine()->getRepository(Message::class)->findRecep($user1);

        return $this->render('Front/Forum/discussion.html.twig',
            array('form' => $form->createView(), "lang" => $lang ,"dataS"=>$dataS
        ,"dataR"=>$dataR));
    }


    /**
     * @Route("/detailC/{lang}/{id}", name="detailC")
     */
    public function detailC($id, TranslatorInterface $translator, $lang, Request $request): Response
    {
        $this->transl($translator, $lang);
        $forum = new Comment();
        $cmt = $this->createForm(CommentType::class, $forum);
        $comts = $this->getDoctrine()->getRepository(Comment::class)->findAll();
        $cmt->handleRequest($request);
        if ($cmt->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            //$forum->setPoster($this->getUser());

            $forum->setPoster($this->getDoctrine()->getRepository(Utilisateur::class)->find(1));
            $em->persist($forum);
            $em->flush();
            return $this->redirectToRoute('detailC', array("lang" => $lang, 'id' => $id));


        }


        return $this->render('Front/Forum/Forum_details.html.twig',array('form' => $cmt->createView(), 'items' => $comts, 'lang' => $lang, 'id' => $id));
    }


    /**
     * @Route("/addFSt/{lang}", name="addFSt")
     */
    public function addFSt(Request $request, TranslatorInterface $translator, $lang): Response
    {

        $this->transl($translator, $lang);
        $forum = new Topic();
        $forums = $this->createForm(TopicType::class, $forum);
        $forums->handleRequest($request);
        if ($forums->isSubmitted()) {
            $uploadedFile = $forums['image']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '\public\upload\forum';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename);
                $forum->setImage($newFilename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($forum);
            $em->flush();
            return $this->redirectToRoute('forum', array("lang" => $lang));
        }


        return $this->render('Front/Forum/addForumSt1.html.twig', array('form' => $forums->createView(), "lang" => $lang)
        );


    }

    /**
     * @Route("/edit/{lang}/{id}", name="edit")
     */
    public function edit(Request $request, $id, $lang, TranslatorInterface $translator): Response
    {
        $this->transl($translator, $lang);
        $forums = $this->getDoctrine()->getRepository(Topic::class)->find($id);
        $form = $this->createForm(TopicType::class, $forums);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("forum", array("lang" => $lang));
        }

        return $this->render('Front/Forum/edit_Topic.twig', array('form' => $form->createView(),'data'=> $forums, "lang" => $lang));
    }
    /**
     * @Route("/editC/{lang}/{idt}/{idc}", name="editC")
     */
    public function editC(Request $request, $idt,$idc, $lang, TranslatorInterface $translator): Response
    {
        $this->transl($translator, $lang);
        $forums = $this->getDoctrine()->getRepository(Comment::class)->find($idc);
        $form = $this->createForm(TopicType::class, $forums);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("editC", array("lang" => $lang,"id"=>$idt));
        }

        return $this->render('Front/Forum/Forum_details.html.twig', array('form' => $form->createView(),'data'=> $forums, "lang" => $lang,"id"=>$idt));
    }
    /**
     * @Route("/delete/{lang}/{id}", name="delete")
     */
    public function delete($id, $lang, TranslatorInterface $translator): Response
    {
        $this->transl($translator, $lang);
        $result = $this->getDoctrine()->getRepository(Topic::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($result);
        $entityManager->flush();

        return $this->redirectToRoute("forum", array("lang" => $lang));


    }

    /**
     * @Route("/deleteC/{lang}/{idt}/{idc}", name="deleteC")
     */
    public function deleteC($idc,$idt, $lang, TranslatorInterface $translator): Response
    {
        $this->transl($translator, $lang);
        $result = $this->getDoctrine()->getRepository(Comment::class)->find($idc);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($result);
        $entityManager->flush();

        return $this->redirectToRoute("detailC", array("lang" => $lang,"idt"=>$idt));


    }


    /**
     * @Route("/love/{lang}/{id}", name="love")
     */
    public function love($lang, $id): Response
    {

        $forums = $this->getDoctrine()->getRepository(Topic::class)->find($id);
        $integer = intval($forums->getBookmark()) + 1;
        $book = new Bookmark();
        $forums->setBookmark($integer);
        $book->addTopicmark($forums);
        $book->setUserBook("Youssef");

        $em = $this->getDoctrine()->getManager();
        $em->persist($forums);
        $em->persist($book);
        $em->flush();

        return $this->redirectToRoute("forum", array("lang" => $lang));

    }

    /**
     * @Route("/unlove/{lang}/{id}", name="unlove")
     */
    public function unLove($lang, $id): Response
    {

        $forums = $this->getDoctrine()->getRepository(Topic::class)->find($id);
        $integer = intval($forums->getBookmark()) - 1;

        $forums->setBookmark($integer);


        $books = $this->getDoctrine()->getRepository(Bookmark::class)->findBook("Youssef", $id);


        $em = $this->getDoctrine()->getManager();
        $em->remove($books[0]);
        $em->flush();

        return $this->redirectToRoute("bookmark", array("lang" => $lang));

    }

    /**
     * @Route("/bookmark/{lang}", name="bookmark")
     */
    public function bookmark($lang, TranslatorInterface $translator): Response
    {
        $this->transl($translator, $lang);

        $user = "Youssef";
        $book = $this->getDoctrine()->getRepository(Bookmark::class)->findByUser($user);


        return $this->render('Front/Forum/bookmarks.html.twig', ["data" => $book, "user" => $user, "lang" => $lang]);
    }
}
