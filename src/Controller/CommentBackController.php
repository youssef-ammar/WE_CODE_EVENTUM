<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Utilisateur;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentBackController extends AbstractController
{


    /**
     * @Route("/comment", name="comment", methods={"GET"})
     */
    public function comment(CommentRepository $commentRepository): Response
    {
        return $this->render('Front/comment/index.html.twig', [
            'voyages' => $commentRepository->findAll(),
        ]);
    }


    /**
     * @Route("comment/{id}/edit", name="commentEdit", methods={"GET", "POST"})
     */
    public function edit(Request $request, $id): Response
    {

        $comment= $this->getDoctrine()->getRepository(Comment::class)->find($id);
       // $user= $this->getDoctrine()->getRepository(Utilisateur::class)->findUser($id);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('comment');
        }


        return $this->render('Front/comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("comment/delete/{id}", name="commentDelete")
     */
    public function delete(Request $request, $id)
    {

        $result = $this->getDoctrine()->getRepository(Comment::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($result);
        $entityManager->flush();

        return $this->redirectToRoute('comment');


    }
}
