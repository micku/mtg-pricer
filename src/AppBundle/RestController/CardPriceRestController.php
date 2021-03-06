<?php

namespace AppBundle\RestController;

use FOS\RestBundle\Controller\Annotations as Rest;
//use FOS\RestBundle\Controller\Annotations\View;
//use FOS\RestBundle\Controller\Annotations\Get;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Utils\MkmApiClient;

class CardPriceRestController extends Controller
{
    /**
     * @Rest\View
     * @Rest\Get("/card-price/{card_id}/{card_name}/", name="cardprice")
     */
    public function getAvarageCardPriceAction($card_id, $card_name)
    {
        $appToken           = $this->container->getParameter('mkm')['app_token'];
        $appSecret          = $this->container->getParameter('mkm')['app_secret'];
        $accessToken        = $this->container->getParameter('mkm')['access_token'];
        $accessSecret       = $this->container->getParameter('mkm')['access_secret'];

        $api = MkmApiClient::getInstance($appToken, $appSecret, $accessToken, $accessSecret);
        $apiOutput = $api->getCardPrice(urlencode($card_name));
        //return $apiOutput;

        $price = new CardPrice();
        $price->card_id = $card_id;
        $price->price = $apiOutput;
        return $price;
    }

    /**
     * @Rest\View
     * @Rest\Get("/card/{card_id}/{card_name}/", name="cardprice")
     */
    public function getCardPriceAction($card_id, $card_name)
    {
        $appToken           = $this->container->getParameter('mkm')['app_token'];
        $appSecret          = $this->container->getParameter('mkm')['app_secret'];
        $accessToken        = $this->container->getParameter('mkm')['access_token'];
        $accessSecret       = $this->container->getParameter('mkm')['access_secret'];

        $api = MkmApiClient::getInstance($appToken, $appSecret, $accessToken, $accessSecret);
        $apiOutput = $api->getCard(urlencode($card_name));

        $cards = $apiOutput[2]['product'];
        $cheapest = array_reduce($cards, function($a, $b) {
            return $a['priceGuide']['AVG'] < $b['priceGuide']['AVG'] ? $a : $b;
        }, array_shift($cards));

        $price = new CardPrice();
        $price->card_id = $card_id;
        $price->prices = $cheapest['priceGuide'];
        return $price;
        //return $apiOutput[2]['product'];
    }
}

class CardPrice
{
    public $card_id;
    public $prices;
    public $price;
}
