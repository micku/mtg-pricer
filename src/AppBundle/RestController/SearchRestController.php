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
        $cardsqb->select('c, n'
            /*
            'c.id',
            'c.name',
            'c.manaCost as mana_cost',
            'c.cmc',
            'c.type',
            'c.text',
            'c.flavor',
            'c.artist',
            'c.number',
            'c.power',
            'c.toughness',
            'c.layout',
            'c.multiverseId as multiverse_id',
            'c.imageName as image_name',
            'r.name as rarity',
            'l.name as lang_found',
            'n.name as lang_found_name'
             */
        )
            ->from('AppBundle:Card', 'c')
            ->leftJoin('c.foreignNames', 'n')
            ->leftJoin('n.language', 'l')
            ->leftJoin('c.rarity', 'r')
            ->where($cardsqb->expr()->like('n.name', '?1'))
            ;
            //'c.colors',
            //'c.superTypes as super_types',
            //'c.types',
            //'c.subTypes as sub_types',
            //'c.legalities',
            //'c.rulings',
            //'c.sets',
        $cardsqb->setParameters(array(1 => '%'.$term.'%'));
        $cards = $cardsqb->getQuery()->getResult();

        return $cards;
    }
}
