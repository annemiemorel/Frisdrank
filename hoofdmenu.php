<?php

namespace Presentation;

require_once "Business/DrankService.php";
require_once("Presentation/hoofdmenuView.php");
use Business\DrankService;

        $pl = new DrankService(); 
        $lijst = $pl->getDrankOverzicht(); 
        //print_r($lijst);
        //echo $lijst[0]->getPrijs();
//session_start();        
$_SESSION['lijst']=$lijst;   
//header("location: Presentation/hoofdmenuView.php");  //doeactie.php?action=stuurmail");
//exit(0);
?> 


