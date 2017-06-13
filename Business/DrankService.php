<?php

namespace Business;
require_once 'Data/DrankDAO.php';
use Data\DrankDAO;


Class DrankService{

    public function getDrankOverzicht() {
        $dDAO = new DrankDAO();
        $lijst = $dDAO->getAll();
        return $lijst;
   }
    public function checkVoorraad($type){
        //console.log("checkvoorraad");
        $gDAO = new DrankDAO();
        $voorraad=$gDAO->haalvoorraad($type);
        return $voorraad;
    }
    public function haalPrijs($type){
        //console.log("checkvoorraad");
        $gDAO = new DrankDAO();
        $prijs=$gDAO->haalprijs($type);
        return $prijs;
    }
}
