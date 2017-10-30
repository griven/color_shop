<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/', function (Request $request, Response $response) {
    $params = $request->getParams();
    $squareMeters = (float) ($params['square_meters'] ?? 0);

    $result = (new \Models\Calculate($this->db))->calcResult($squareMeters);

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $result);
});

$app->get('/goods', function () {
    (new \Models\Calculate($this->db))->recalculatePricePerMeter();
});
