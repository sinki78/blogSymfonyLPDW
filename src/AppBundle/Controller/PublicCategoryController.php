<?php
/**
 * Created by PhpStorm.
 * User: a08995
 * Date: 20/12/2016
 * Time: 09:51
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Category;
use AppBundle\Entity\Commentary;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/category")
 */
class PublicCategoryController extends Controller
{
        /**
     * @Route("/liste", name="public_liste_category")
     */
    public function categoryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')->findAll();

        return $this->render('/category/index.html.twig', array(
            'categories'=>$categories,
        ));

    }


    /**
     * Finds and displays a category entity.
     *
     * @Route("/liste/{id}", name="public_liste_category_show")
     * @Method("GET")
     */
    public function CategoryShowAction(Category $category)
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('AppBundle:Article')->findByCategory($category);
        return $this->render('/category/show.html.twig', array(
            'articles' => $articles,
        ));
    }
}