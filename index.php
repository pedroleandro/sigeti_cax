<?php

require __DIR__ . "/vendor/autoload.php";

try {

    $connection = \App\Core\Connection::getInstance();

    var_dump($connection);

} catch (\RuntimeException $exception) {
    echo $exception->getMessage();
}
