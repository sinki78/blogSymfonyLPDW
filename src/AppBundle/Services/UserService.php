<?php
/**
 * Created by PhpStorm.
 * User: a08995
 * Date: 20/01/2017
 * Time: 09:08
 */

namespace AppBundle\Services;

use AppBundle\Entity\Role;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserService
{
    /**
     * @var EntityManager
     */
    private $doctrine;
    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }



    /** Generate defaults groups */
    public function generateGroups(EntityManager $em){

        $role_admin = new Role();
        $role_admin->setName('ROLE_ADMIN');

        $em->persist($role_admin);

        $em->flush();
    }
}