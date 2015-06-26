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
        $em = $this->getDoctrine()->getManager();
        $cardsqb = $em->createQueryBuilder();
        $cardsqb->select('c', 'n')
            ->from('AppBundle:Card', 'c')
            ->leftJoin('c.foreignNames', 'n')
            ->where($cardsqb->expr()->like('n.name', '?1'))
            ;
        $cardsqb->setParameters(array(1 => '%'.$term.'%'));
        $cards = $cardsqb->getQuery()->getResult();

        return $cards;
    }
}
