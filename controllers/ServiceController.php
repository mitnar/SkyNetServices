<?php
declare (strict_types=1);

require_once '../database/Database.php';
require_once '../services/ServiceService.php';
require_once '../services/TarifService.php';

class ServiceController {

    private $serviceService;
    private $tarifService;

    public function __construct()
    {
        $this->serviceService = new ServiceService();
        $this->tarifService = new TarifService();
    }

    public function getTarifs(int $user_id, int $service_id): string
    {
        $result = ['result' => 'ok'];

        try {
            $result['tarifs'] = $this->serviceService->getServices($user_id, $service_id);

            foreach($result['tarifs'] as &$tarif) {
                $tarif['tarifs'] = $this->tarifService->getTarifs($tarif['tarif_group_id']);
                unset($tarif['tarif_group_id']);
            }

        } catch(Exception $e) {
            return json_encode(['result' => 'error']);
        }

        return json_encode($result);
    }

    public function setTarif(int $user_id, int $service_id)
    {
        $_PUT = json_decode(file_get_contents("php://input"), true); // получаем данные с put-запроса

        try {
            $this->serviceService->setService($user_id, $service_id, $_PUT['tarif_id']);
        } catch(Exception $e) {
            return json_encode(['result' => 'error']);
        }

        return json_encode(['result' => 'ok']);
    }
}














