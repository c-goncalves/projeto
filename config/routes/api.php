<?php

$router->post('/api/validar', 'ValidationController@validar');

$router->post('/api/pdf/{doc}', function($doc) {
    $controller = new PdfController();
    $controller->generate($doc);
});
