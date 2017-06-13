<?php
require_once 'Business/DrankService.php';
use Business\DrankService;
//session_start();

if (isset($_GET["action"]) && $_GET["action"] == "process") {
    try {
        //$type=$_POST['type'];
        $type=$_GET['type'];
        //echo "type = " . $type;
        $gSvc = new DrankService();
        $_SESSION['voorraad']=$gSvc->checkVoorraad($type);
        $_SESSION['prijs']=$gSvc->haalPrijs($type);
        //echo "voorraad = ".$_SESSION['voorraad'];
        $_SESSION['betaald']=0;
        header("location: Presentation/hoofdmenuView.php?voorraad=opgehaald&type=$type");  //doeactie.php?action=stuurmail");
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