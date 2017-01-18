<?php
/**
 * Created by PhpStorm.
 * User: a08995
 * Date: 19/12/2016
 * Time: 15:29
 */

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Article controller.
 *
 * @Route("administration")
 */
class AdminController extends Controller
{
    /**
     * Lists all article entities.
     *
     * @Route("/", name="administration_homepage")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('admin/index.html.twig');
    }

}