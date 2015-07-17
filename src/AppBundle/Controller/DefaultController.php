<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function indexAction()
    {
        $cards = $this->get('doctrine_mongodb')
            ->getRepository('AppBundle:BlockSet')
            ->findAll();

        return $this->render('default/index.html.twig', array(
            'cards' => $cards
        ));
    }
}
