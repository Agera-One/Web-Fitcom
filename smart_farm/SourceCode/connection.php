<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host = $_ENV['DB_HOST'];
$port = (int)$_ENV['DB_PORT'];
$name = $_ENV['DB_USERNAME'];
$pass = $_ENV['DB_PASSWORD'];
$data = $_ENV['DB_DATABASE'];

$connection = mysqli_connect($host, $name, $pass, $data, $port);
mysqli_set_charset($connection, 'utf8mb4');