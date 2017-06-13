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
        console.log("checkvoorraad");
        $gDAO = new DrankDAO();
        $gDAO->haalvoorraad($type);
    }
}
