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
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class PublicController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->getLastFive();
        $tags = $em->getRepository('AppBundle:Tag')->findAll();
        return $this->render('public/index.html.twig', [
            'articles' => $articles,
            'tags' => $tags,
        ]);
    }

    /**
     * Lists all article entities.
     *
     * @Route("/search", name="public_search_article")
     * @Method("POST")
     */
    public function searchArticleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $name = $request->request->get('name');
        $reqFields = $request->request->all();

        $tags = $this->get('article_service')->getTagsSearchArray($reqFields);
        if($name != NULL)
            $result = $em->getRepository('AppBundle:Article')->getBySearchTN($tags,$name);
        else if($name == NULL && !empty($tags)){
//            dump($tags);die;
            $result = $em->getRepository('AppBundle:Article')->getBySearchT($tags);
            dump($result);die;
        } else {
            $result = $em->getRepository('AppBundle:Article')->findAll();
        }


        $tags = $em->getRepository('AppBundle:Tag')->findAll();
        return $this->render('public/index.html.twig', array(
            'articles' => $result,
            'tags' => $tags,
        ));
    }

    /**
     * Finds and displays a article entity.
     *
     * @Route("/article/{id}", name="public_article_show")
     */
    public function showAction(Article $article, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $commentaries = $em->getRepository('AppBundle:Commentary')->findByArticle($article);
        $commentary = new Commentary();
        $form = $this->createForm('AppBundle\Form\CommentaryType', $commentary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentary->setArticle($article);
            $em->persist($commentary);
            $em->flush($commentary);

            return $this->redirectToRoute('public_article_show', array('id' => $article->getId()));
        }


        return $this->render('public/article_show.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
            'commentaries' => $commentaries,
        ));
    }

    /**
     * @Route("/liste/{page}", defaults={"page"=1}, requirements={"page": "\d+"},name="public_liste_articles")
     */
    public function listeArticlesAction(Request $request,$page)
    {
        $em = $this->getDoctrine()->getManager();

        //récupération des articles
        $articles = $em->getRepository('AppBundle:Article')->findAll();

        $paginator  = $this->get('knp_paginator');
        $articles_pagination = $paginator->paginate(
            $articles, /* query */
            $request->query->get('page', $page),
            10/*limite par page*/
        );
        return $this->render('public/liste.html.twig', array(
            'articles_pagination'=>$articles_pagination,
        ));
    }


    /**
     * @Route("/category/liste", name="public_liste_category")
     */
    public function categoryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')->findAll();

        return $this->render('public/category/index.html.twig', array(
            'categories'=>$categories,
        ));

    }


    /**
     * Finds and displays a category entity.
     *
     * @Route("/category/liste/{id}", name="public_liste_category_show")
     * @Method("GET")
     */
    public function CategoryShowAction(Category $category)
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('AppBundle:Article')->findByCategory($category);
        return $this->render('public/category/show.html.twig', array(
            'articles' => $articles,
        ));
    }
}