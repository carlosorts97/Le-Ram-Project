<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Cities;
use App\Entity\Countries;
use App\Entity\Sizes;
use App\Entity\Stock;
use App\Entity\Brands;
use App\Form\NewArticleType;
use App\Entity\Articles;
use App\Entity\User;
use App\Form\NewSizeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    /**
     * @Route("/article/{id}", name="app_LoadArticle")
     */
    public function loadArticle($id)
    {

        $article = $this->getDoctrine()->getRepository(Articles::class)->find($id);
        return $this->render('article/article.html.twig', array(
            'article' => $article,
        ));
    }

    /**
     * @Route("/up3Product/{id}", name="app_upload3Article")
     */
    public function uploadA3rticle(Request $Request, $id)
    {
        $article = new Sizes();
        $idUser= $this->getUser();
        $stockUpdate = null;

        //crear form
        $form = $this->createForm(NewSizeType::class, $article);
        //handle the request
        $form->handleRequest($Request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setArticle($this->getDoctrine()->getRepository(Articles::class)->find($id));

            $article->setUser($idUser);

            $stock= $this->getDoctrine()->getRepository(Sizes::class)->findOneBy([
                'size' => $article->getSize(),
                'article' => $this->getDoctrine()->getRepository(Articles::class)->find($id),
            ]);

            if($stock == null){
                $stock = new Stock();
                $stock->AddStock();
                $article->setStock($stock);
            }else{
                $stockUpdate= $stock->getStock();

                $stockUpdate->AddStock();

                $article->setStock($stockUpdate);
            }



            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            if($stockUpdate == null){
                $entityManager->persist($stock);
            }else{
                $entityManager->persist($stockUpdate);
            }
            $entityManager->flush();
            return $this->redirectToRoute('app_homepage');
        }
        //render the form
        return $this->render('article/upProduct.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/editUploadedArticle/{id}", name="app_editUpArt")
     */
    public function editArticle(Request $Request, $id)
    {

        $idUser = $this->getUser();
        $article = $this->getDoctrine()->getRepository(Sizes::class)->findOneBy([
            'article' => $id,
            'user' =>$idUser

        ]);
        //crear form
        $form = $this->createForm(NewSizeType::class, $article);
        //handle the request
        $form->handleRequest($Request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setArticle($this->getDoctrine()->getRepository(Articles::class)->find($id));

            $article->setUser($idUser);

            $stock = $this->getDoctrine()->getRepository(Sizes::class)->findOneBy([
                'size' => $article->getSize(),
                'article' => $this->getDoctrine()->getRepository(Articles::class)->find($id),
            ]);


            $stockUpdate = $stock->getStock();

            $stockUpdate->AddStock();

            $article->setStock($stockUpdate);



            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->persist($stock);
            $entityManager->flush();
            return $this->redirectToRoute('app_homepage');
        }
        //render the form
        return $this->render('article/upProduct.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("article/{id}/{size}/delete", name="app_articleSize_delete")
     */
    public function deleteArticle($id, $size)
    {
        $em = $this->getDoctrine()->getManager();
        $idUser=$this->getUser();
        $article = $this->getDoctrine()->getRepository(Sizes::class)->findOneBy([
            'article' => $id,
            'user' =>$idUser,
            'size' =>$size

        ]);
        $article->getStock()->RemoveStock();
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('app_homepage');


    }

}
