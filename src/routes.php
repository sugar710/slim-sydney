<?php
// Routes
use App\Controllers\Admin\AuthController;

$app->get('/admin/login', AuthController::class . ':login');
$app->post('/admin/login', AuthController::class . ':doLogin');

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    $data = [];
    //获取flash-name
    $flashName = $this->flash->getMessage("name");
    $data["name"] = $flashName[0];
    return $this->view->render("index", $data);
});

$app->get('/setting', function() {
    //设置flash-name
    $this->flash->addMessage("name", "冯毅");
   return "OK";
});
