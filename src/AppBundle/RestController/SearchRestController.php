<?php

namespace AppBundle\RestController;

use FOS\RestBundle\Controller\Annotations as Rest;
//use FOS\RestBundle\Controller\Annotations\View;
//use FOS\RestBundle\Controller\Annotations\Get;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchRestController extends Controller
{
    /**
     * @Rest\View
     * @Rest\Get("/search/{term}/", name="restsearch")
     */
    public function getSearchAction($term)
    {
        $em = $this->get('doctrine_mongodb')->getManager();
        $cardsObjs = $em->createQueryBuilder('AppBundle:Card')
            ->field('foreignNames.name')
            ->equals(new \MongoRegex('/'.$term.'/i'))
            ->getQuery()
            ->execute();

        $cards = Array();

        foreach($cardsObjs as $key => $val)
        {
            $cards[] = $val;
        }

        return $cards;
    }
}
