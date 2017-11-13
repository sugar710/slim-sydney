<?php
// Routes

foreach (['web' => 'web', 'passport' => 'passport', 'admin' => 'system', 'wap' => 'wap'] as $key => $filename) {
    if (isDomain($key) && is_file($routerFile = __DIR__ . '/Routers/' . $filename . '.php')) {
        require $routerFile;
    }
}

require __DIR__ . '/Routers/install.php';