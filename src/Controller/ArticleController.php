<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\NewArticleType;
use App\Entity\Articles;
use App\Entity\User;
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
     * @Route("/upProduct", name="app_uploadArticle")
     */
    public function uploadArticle(Request $Request)
    {
        $article = new Articles();
        $category = new Category();
        $category->setName("Top");
        $id= $this->getUser();
        //crear form
        $form = $this->createForm(NewArticleType::class, $article);
        //handle the request
        $form->handleRequest($Request);
        if ($form->isSubmitted() && $form->isValid()) {

            $article->setCategory($category);
            $article->setUser($id);
            $article = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('app_homepage');
        }
        //render the form
        return $this->render('article/upProduct.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
