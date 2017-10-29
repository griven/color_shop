<?php

use Slim\Http\Request;
use Slim\Http\Response;
//GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO "planoplan";
// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {

    /** @var PDO $db */
    $db = $this->db;
    $stmt = $db->query('SELECT * FROM goods');
    var_dump($stmt->fetchAll());

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
