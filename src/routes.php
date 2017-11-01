<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Calc\Calculate;
use Calc\Dao;

// Routes
$app->get('/', function (Request $request, Response $response) {
    $params = $request->getParams();
    $squareMeters = (float) ($params['square_meters'] ?? 0);

    $result = (new Calculate(new Dao($this->db)))->calcResult($squareMeters);
    print_r((new Calculate(new Dao($this->db)))->getBestShopSet($squareMeters,'alpha'));

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $result);
});

$app->get('/goods', function () {
//    (new Calculate(new Dao($this->db)))->recalculatePricePerLiter();
    print_r((new Calculate(new Dao($this->db)))->getBestShopSet(55,'alpha'));
});
