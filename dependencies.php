<?php

use DI\ContainerBuilder;
use App\Domain\Repositories\ClienteRepositoryInterface;
use App\Infrastructure\Persistence\ClienteRepository;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        PDO::class => function () {
            $host = $_ENV['DB_HOST'];
            $port = $_ENV['DB_PORT'];
            $dbname = $_ENV['DB_DATABASE'];
            $username = $_ENV['DB_USERNAME'];
            $password = $_ENV['DB_PASSWORD'];

            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

            return new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        },
        ClienteRepositoryInterface::class => function (PDO $pdo) {
            return new ClienteRepository($pdo);
        },
    ]);
};
