<?php

namespace App\Controller;


use App\Entity\Commande;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Form\RechType;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

class ProduitController extends AbstractController
{

    /**
     * @Route("/afficherproduit",name="afficherproduit")
     */
    public function Affiche(Request $request,ProduitRepository $repository,PaginatorInterface $paginator){
        $tableprduits=$repository->listproduitparprix();
        $tableprduits = $paginator->paginate(
            $tableprduits,
            $request->query->getInt('page', 1),
            4
        );

        return $this->render('produit/afficherProduits.html.twig'
            ,['tableproduits'=>$tableprduits]);

    }

    /**
     * @Route("/ajoutproduit",name="ajoutproduit")
     */
    public function ajouterProduit(EntityManagerInterface $em,Request $request ,ProduitRepository $UserRepository,\Swift_Mailer $mailer){
        $produit= new Produit();
        $form= $this->createForm(ProduitType::class,$produit);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $new=$form->getData();
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        'back\images',
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $produit->setImage($newFilename);
            }
            $em->persist($produit);
            $em->flush();
            $message = (new \Swift_Message("Vous avez ajouté un nouveau Produit   "/*.$msg*/))

                ->setFrom('eventum20@gmail.com')
                ->setTo('zouhour.rezgui@esprit.tn')
                //message avec vue twig
                ->setBody(
                    $this->renderView(
                        'email/contact.html.twig'
                    ),
                    'text/html'
                ) ;

            $mailer->send($message);




            return $this->redirectToRoute("afficherproduit");
        }
        return $this->render("produit/ajoutProduit.html.twig",array("form"=>$form->createView()));

    }
    /**
     * @Route("/supprimerproduit/{id}",name="supprimerproduit")
     */
    public function delete($id,EntityManagerInterface $em ,ProduitRepository $repository){
        $produit=$repository->find($id);
        $em->remove($produit);
        $em->flush();

        return $this->redirectToRoute('afficherproduit');
    }

    /**
     * @Route("/{id}/modifierproduit", name="modifierproduit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produit $produit): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->add('Confirmer',SubmitType::class);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        'back\images',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $produit->setImage($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('afficherproduit');
        }

        return $this->render('produit/Modifierproduit.html.twig', [
            'produitmodif' => $produit,
            'form' => $form->createView(),
        ]);
    }







    /**
     * @Route("/produit/{id}",name="get_produit_info")
     */
    public function getById (EntityManagerInterface $entityManager,ProduitRepository $repository, Request $request  )
    {

        $id = $request->get('id');

        $produit = $repository->findOneBy(["id" => $request->get("id")]);
        $commande = new Commande();



        $commande->setProduit($produit);
        $commande->setDate(new \DateTimeImmutable());

        $entityManager->persist($commande);
        $entityManager->flush();

        return $this->render("produit/afficher1Produit.html.twig",['produit' => $produit]) ;

    }


    /**
     * @Route("/produit/{id}",name="acheter")
     */
    public function acheter (EntityManagerInterface $entityManager,ProduitRepository $repository, Request $request  )
    {


    }

    /**
     * @Route("/stat", name="stat")
     */
    public function statAction(ProduitRepository $repo)
    {
        $produits= $repo->findAll();
        $produit= [];
        $produitcommande= [];




        foreach($produits as $produit ){
            $produitnom[]=$produit->getNom();
            $produitcommande[]= count($produit->getCommande());
        }

        return $this->render('produit/dashbord.html.twig',
            [
                'produitnom' => json_encode($produitnom),
                'commande' => json_encode($produitcommande), 'base2' => 'base2',



            ]);


    }


    /**
     * @Route("/afficherproduitClient",name="afficherproduitClient")
     */
    public function AfficheProduitClients(EntityManagerInterface $entityManager,Request $request,ProduitRepository $repository,CommandeRepository $commandeRepo){

        $tableproduits=$repository->findAll();
        $form = $this->createForm(RechType::class);

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $nomproduit=$form->getData()->getNom();
            $produitResult=$this->getDoctrine()->getRepository(Produit::class)->getProdtuiPrix($nomproduit);

            return $this->render('produit/afficherproduitclient.html.twig', [
                'tableproduits'=>$tableproduits,
                'produit' => $produitResult,
                'form2' => $form->createView(),



            ]);
        }



        return $this->render('produit/afficherproduitclient.html.twig'
            ,['produit'=>$tableproduits,
                'form2' => $form->createView(),

                ]);

    }




    /*
    public function testthisplz(
        Request $request,
        ProduitRepository $coursRepo,
        EntityManagerInterface $entityManager)
    {

        $produit =$this->getDoctrine()->getRepository(Produit::class)->findAll();

        $form = $this->createForm(RechType::class);

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $nomproduit=$form->getData()->getNom();
            $produitResult=$this->getDoctrine()->getRepository(Produit::class)->getCoursByNom($nomproduit);

            return $this->render('produit/show.html.twig', [
                'produit' => $produitResult,
                'form2' => $form->createView(),



            ]);
        }
        return $this->render('cours/show.html.twig', [
            'courss' => $produit,
            'form2' => $form->createView(),

        ]);
    }
*/




}
