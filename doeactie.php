<?php


require_once "Business/DrankService.php";
use Business\DrankService;
session_start();

if (isset($_GET["action"]) && $_GET["action"] == "init"){
     $pl = new DrankService(); 
     $lijst = $pl->getDrankOverzicht(); 
     print_r($lijst);
        //echo $lijst[0]->getPrijs();
       
    $_SESSION['lijst']=$lijst;   
    header("location: Presentation/hoofdmenuView.php");
    exit(0);
}