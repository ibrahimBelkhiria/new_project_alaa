<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/create_user",name="add_user")
     * @param Request $request
     * @return View
     */
    public function createUser(Request $request)
    {

        $em= $this->getDoctrine()->getManager();

        $user = new User();
        $user->setUsername($request->get('username'));
        $user->setUsername($request->get('email'));
        $user->setPassword($request->get('password'));

        $em->persist($user);
        $em->flush();

            return View::create($user,Response::HTTP_CREATED);

    }





}
