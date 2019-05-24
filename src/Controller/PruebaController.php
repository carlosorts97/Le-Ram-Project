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
use PhpParser\Node\Expr\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PruebaController extends AbstractController
{
    /**
     * @Route("/prueba/{category}/{brand}", name="prueba")
     */
    public function index($category, $brand)
    {
        if ($brand == 0){
            $articles = $this->getDoctrine()->getRepository(Articles::class)->findBy(array('category'=>$category));
        }
        else{
            $articles = $this->getDoctrine()->getRepository(Articles::class)->findBy(array('category'=>$category,'brand'=>$brand));
        }

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'category' => $category,
            'brand' => $brand
        ]);
    }
}
