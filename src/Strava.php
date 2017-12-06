<?php
/**
 * Created by PhpStorm.
 * User: kjell
 * Date: 11.10.17
 * Time: 11:26
 */

namespace KjellKnapen\Strava;


class Strava
{
    private $client;
    private $client_id;
    private $client_secret;
    private $redirect_uri;

    public function __construct($CID, $CSCRT, $REDURI, $GZZLC)
    {
        $this->client = $GZZLC;
        $this->client_id = $CID;
        $this->client_secret = $CSCRT;
        $this->redirect_uri = $REDURI;
    }

    public function redirect(){
        return redirect('https://www.strava.com/oauth/authorize?client_id='. $this->client_id .'&response_type=code&redirect_uri='. $this->redirect_uri .'&state=mystate');
    }

    public function tokenExchange($code){
        $url = 'https://www.strava.com/oauth/token';
        $config = [
            'form_params' => [
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'code' => $code,
            ]
        ];
        $res = $this->post($url, $config);

        return $res;
    }

    public function post($url, $config){
        $res = $this->client->post( $url, $config );

        $result = json_decode($res->getBody()->getContents());

        return $result;
    }

    public function get( $url, $config ){

        $res = $this->client->get( $url, $config );

        $result = json_decode($res->getBody()->getContents());

        return $result;
    }
}
