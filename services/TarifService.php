<?php

class TarifService
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getTarifs($tarif_group_id)
    {
        $res = $this->db->query("SELECT ID, title, price, pay_period, speed
                                        FROM tarifs
                                        WHERE tarif_group_id = $tarif_group_id");
        if(!$res)
            throw new Exception();

        $tarifs = [];

        while($tarif = $res->fetch_assoc()) {

            $tarif['newpayday'] = strtotime('today') + $tarif['pay_period'] * 24 * 3600 . date('O');
            $tarifs[] = $tarif;
        }

        return $tarifs;
    }
}