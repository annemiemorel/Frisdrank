<?php
require_once 'Business/DrankService.php';
use Business\DrankService;
session_start();

if (isset($_GET["action"]) && $_GET["action"] == "process") {
    try {
        //$type=$_POST['type'];
        $type=$_GET['type'];
        echo("type = " + $type);
        $gSvc = new DrankService();
        $_SESSION['voorraad']=$gSvc->checkVoorraad($type);
        header("location: Presentation/hoofdmenuView.php?voorraad=opgehaald");  //doeactie.php?action=stuurmail");
        exit(0);
    }
    catch(FrisdrankException $ex){
        header("location: Presentation/hoofdmenuView.php?voorraad=fout");  //doeactie.php?action=stuurmail");
        exit(0);
    }
}
if (isset($_GET["action"]) && $_GET["action"] == "betaal") {
    echo "betaal drankje";
}