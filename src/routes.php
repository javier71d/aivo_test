<?php
// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    //$this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    //return $this->renderer->render($response, 'index.phtml', $args);
    $result = array('status' => 'Nothing to do here');
    return $response->write(json_encode($result));
});
