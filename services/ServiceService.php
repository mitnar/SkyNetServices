<?php
declare(strct_types=1);

require_once '../database/Database.php';

class ServiceService
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getServices(int $user_id, int $service_id): array
    {
        $res = $this->db->query("SELECT t.title, t.link, t.speed, tarif_group_id
                                        FROM services s
                                        LEFT JOIN tarifs t ON t.ID = s.tarif_id
                                        INNER JOIN users u ON u.id = s.user_id
                                        WHERE user_id = $user_id
                                        AND s.id = $service_id");

        if(!$res)
           throw new Exception();

        $services = [];

        while($service = $res->fetch_assoc()) {
            $services[] = $service;
        };

        return $services;
    }

    public function setService(int $user_id, int $service_id, int $tarif_id): void
    {
        if(!$this->db->query("UPDATE services 
                                     SET tarif_id = $tarif_id
                                     WHERE user_id = $user_id 
                                     AND ID = $service_id"))
            throw new Exception();
    }
}