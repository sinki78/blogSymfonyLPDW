<?php
/**
 * Created by PhpStorm.
 * User: a08995
 * Date: 20/12/2016
 * Time: 09:51
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
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
        $tag = $request->request->get('tag');
        dump($name);
        dump($tag);die;

        $articles = $em->getRepository('AppBundle:Article')->findBy();

        return $this->render('article/index.html.twig', array(
            'articles' => $articles,
        ));
    }

    /**
     * Finds and displays a article entity.
     *
     * @Route("/article/{id}", name="public_article_show")
     * @Method("GET")
     */
    public function showAction(Article $article)
    {
        return $this->render('public/article_show.html.twig', array(
            'article' => $article,
        ));
    }

    /**
     * @Route("/liste/{page}", defaults={"page"=1}, requirements={"page": "\d+"},name="public_liste_articles")
     */
    public function listeArticlesAction(Request $request,$page)
    {
        $em = $this->getDoctrine()->getManager();

        //récupération des jeux
        $articles = $em->getRepository('AppBundle:Article')->findAll();

        $paginator  = $this->get('knp_paginator');
        $articles_pagination = $paginator->paginate(
            $articles, /* query */
            $request->query->get('page', $page),
            5/*limite par page*/
        );
        return $this->render('public/liste.html.twig', array(
            'articles_pagination'=>$articles_pagination,
        ));
    }
}