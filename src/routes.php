<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Calc\Calculate;
use Calc\Dao;

// Routes
$app->get('/', function (Request $request, Response $response) {
    $params = $request->getParams();
    $squareMeters = (float) ($params['square_meters'] ?? 0);

    $calc = (new Calculate(new Dao($this->db)));
    $result = $calc->calcResult($squareMeters);

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $result);
});
