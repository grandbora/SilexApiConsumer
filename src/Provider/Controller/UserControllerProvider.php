<?php

namespace Provider\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserControllerProvider implements ControllerProviderInterface {

    public function connect(Application $app) {

        $config = $app['wisdom']->get('config.json');
        $controllers = $app['controllers'];

        $controllers->get('/get/{id}', function ($id) use ($app, $config) {

                    $endpoint = $config['api']['endpoint'] . 'users/' . $id;
                    $apiResponse = $app['buzz']->get($endpoint);
                    if ($apiResponse->isSuccessful()) {
                        $response = new JsonResponse();
                        $response->setContent($apiResponse->getContent());
                        return $response;
                    } else {
                        return new Response($apiResponse->getContent(), $apiResponse->getStatusCode());
                    }
                })->assert('id', '\d+');
        $controllers->get('/delete/{id}', function ($id) use ($app, $config) {

                    $endpoint = $config['api']['endpoint'] . 'users/' . $id;
                    $apiResponse = $app['buzz']->delete($endpoint);
                    if ($apiResponse->isSuccessful()) {
                        $response = new JsonResponse();
                        $response->setContent($apiResponse->getContent());
                        return $response;
                    } else {
                        return new Response($apiResponse->getContent(), $apiResponse->getStatusCode());
                    }
                })->assert('id', '\d+');
        $controllers->get('/put/{id}', function ($id) use ($app, $config) {

                    $endpoint = $config['api']['endpoint'] . 'users/' . $id;
                    $apiResponse = $app['buzz']->post($endpoint, array(), array('fbId' => 6));

                    if ($apiResponse->isSuccessful()) {
                        $response = new JsonResponse();
                        $response->setContent($apiResponse->getContent());
                        return $response;
                    } else {
                        return new Response($apiResponse->getContent(), $apiResponse->getStatusCode());
                    }
                })->assert('id', '\d+');
        $controllers->get('/post', function () use ($app, $config) {

                    $endpoint = $config['api']['endpoint'] . 'users/';
                    $apiResponse = $app['buzz']->post($endpoint, array(), array('fbId' => '112', 'type' => 'type', 'position' => 'position'));
                    if ($apiResponse->isSuccessful()) {
                        $response = new JsonResponse();
                        $response->setContent($apiResponse->getContent());
                        return $response;
                    } else {
                        return new Response($apiResponse->getContent(), $apiResponse->getStatusCode());
                    }
                });

        return $controllers;
    }

}