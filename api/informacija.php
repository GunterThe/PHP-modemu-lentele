<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';
use InvalidArgumentException;

use App\Repository\InformacijaRepository;
use App\Model\Informacija;

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$repo = new InformacijaRepository();
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true) ?: [];

try {
    switch ($method) {
        case 'GET':
            if (isset($_GET['teritorijos'])) {
                echo json_encode($repo->getTeritorijos());
                break;
            }
            if (isset($_GET['teikejai'])) {
                echo json_encode(['Bitė','Tele2','Telia','Pildyk','Labas','Ežys']);
                break;
            }
            if (isset($_GET['q'])) {
                $col = $_GET['col'] ?? 'Vardas_pavarde';
                $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 100;
                $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
                try {
                    echo json_encode($repo->search($col, $_GET['q'], $limit, $offset));
                } catch (InvalidArgumentException $e) {
                    http_response_code(400);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;
            }
            if (isset($_GET['id'])) {
                $item = $repo->find((int)$_GET['id']);
                if (!$item) { http_response_code(404); echo json_encode(['error' => 'Not found']); break; }
                echo json_encode($item->toArray());
            } else {
                $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 100;
                $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
                echo json_encode($repo->all($limit, $offset));
            }
            break;

        case 'POST':
            $model = Informacija::fromArray($input);
            $id = $repo->create($model);
            echo json_encode(['id' => $id]);
            break;

        case 'PUT':
            if (isset($_GET['id'])) {
                $model = Informacija::fromArray($input);
                $model->Id = (int)$_GET['id'];
                $ok = $repo->update($model);
                echo json_encode(['success' => (bool)$ok]);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Missing id']);
            }
            break;

        case 'DELETE':
            if (isset($_GET['id'])) {
                $ok = $repo->delete((int)$_GET['id']);
                echo json_encode(['success' => (bool)$ok]);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Missing id']);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
