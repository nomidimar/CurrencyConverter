<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;
use App\Controller\ConvertController;
use App\Provider\YamlRateProvider;
use App\Service\CurrencyConverter;
use App\Provider\RateProviderInterface;

// Load YAML configs
$servicesFile = __DIR__ . '/../config/services.yaml';
$packagesFile = __DIR__ . '/../config/packages/currency_rates.yaml';

if (!file_exists($servicesFile) || !file_exists($packagesFile)) {
    http_response_code(500);
    echo json_encode(['error' => 'Configuration files missing']);
    exit;
}

$packages = Yaml::parseFile($packagesFile);
$services = Yaml::parseFile($servicesFile);

// Extract rates parameter
$rates = $packages['parameters']['currency_rates'] ?? [];

// Simple service wiring according to our services.yaml
$provider = new YamlRateProvider($rates);
$converter = new CurrencyConverter($provider);
$controller = new ConvertController($converter);

// Very small router for /convert
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === '/convert') {
    header('Content-Type: application/json; charset=utf-8');
    try {
        echo json_encode($controller->convert($_GET));
    } catch (\InvalidArgumentException $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

http_response_code(404);
echo json_encode(['error' => 'Not Found']);
