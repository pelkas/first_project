<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('@Front/Default/index.html.twig');
    }

    /**
     * @Route("/trakt", name="trakt_api")
     */
    public function traktApiAction()
    {
        $client_id = 'b62d6d210bd5749376767342b0e9378c49a0c96ee983f77dbecd0e8629238594';
        $client_secret = '53c8477aec4f2d649c04e59ce2bf08da79a520574e748cdf81245ceaf5acc888';
        $redirect_uri = 'http://127.0.0.1:8000/trakt';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://trakt.tv/oauth/authorize?response_type=code&client_id='.$client_id.'&redirect_uri='.$redirect_uri.'");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Content-Type:application/json"
      ));

        $response = curl_exec($ch);
        curl_close($ch);

        //var_dump($response);

        return $this->render('@Front/Default/trakt.html.twig', [
			'response' => $response
		]);
    }

    /**
     *@Route("/filmweb", name="filmweb")
     */
    public function filmwebAction()
    {
        $dir = '/var/lib/plexmediaserver/Library/Videos';

        $first_child = scandir($dir);
        unset($first_child[array_search('.', $first_child, true)]);
        unset($first_child[array_search('..', $first_child, true)]);

        $second_child = scandir($dir.'/'.$first_child[2]);
        unset($second_child[array_search('.', $second_child, true)]);
        unset($second_child[array_search('..', $second_child, true)]);

        $third_child = scandir($dir.'/'.$first_child[3]);
        unset($third_child[array_search('.', $third_child, true)]);
        unset($third_child[array_search('..', $third_child, true)]);

        $fourth_child = scandir($dir.'/'.$first_child[4]);
        unset($fourth_child[array_search('.', $fourth_child, true)]);
        unset($fourth_child[array_search('..', $fourth_child, true)]);


        return $this->render('@Front/Default/index.html.twig', [
			'movies_pl' => $first_child[2],
            'movies_subtitles' => $first_child[3],
            'tv_shows' => $first_child[4],
            'second_child' => $second_child,
            'third_child' => $third_child,
            'fourth_child' => $fourth_child
		]);
    }
}
