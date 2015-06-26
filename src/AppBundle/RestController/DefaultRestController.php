<?php

namespace AppBundle\RestController;

use FOS\RestBundle\Controller\Annotations as Rest;
#use FOS\RestBundle\Controller\Annotations\View;
#use FOS\RestBundle\Controller\Annotations\Get;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultRestController extends Controller
{
    /**
     * Route("/", name="resthomepage")
     * @Rest\Get("/", name="resthomepage")
     */
    public function getIndexAction()
    {
        $cards = $this->getDoctrine()
            ->getRepository('AppBundle:Card')
            ->findAll();

        return $cards;
    }
}
