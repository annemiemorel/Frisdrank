<?php
namespace Data;
require_once 'DBConfig.php';
require_once 'Entities/Drank.php';
//require_once 'Entities/Bestelling.php';
////require_once 'Entities/Login.php';
//require_once 'Exceptions/GebruikerBestaatException.php';
//require_once 'Exceptions/FoutPaswoordException.php';
//require_once 'Exceptions/EmailBestaatNietException.php';
//require_once 'Exceptions/DatumBestaatNietException.php';
//require_once 'Exceptions/FoutEmailAdresException.php';
use Data\DBConfig;
use Entities\Drank;
//use Entities\Cursist;
//use Entities\Bestelling;
//use Exceptions\GebruikerBestaatException;
//use Exceptions\FoutPaswoordException;
//use Exceptions\EmailBestaatNietException;
//use Exceptions\DatumBestaatNietException;
//use Exceptions\FoutEmailAdresException;
use PDO;
session_start();


class DrankDAO {

 public function getAll() {  
      $sql = "select * from drank";
    $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
     
    $resultSet = $dbh->query($sql);
    $lijst = array();
    foreach ($resultSet as $rij) {
     $drank = Drank::create($rij["id"], $rij["type"], $rij["voorraad"],$rij["prijs"]);
     array_push($lijst, $drank);
    }
    $dbh = null;
    $_SESSION["velden"]=sizeof($lijst); //aantal gebruikers
    return $lijst;
}

     public function create($email) {  //nieuwe functie om boek te kunnen toevoegen
        //**foutafhandeling**//
        
        $bestaandeGebruiker = $this->getByEmail($email); //null indien nog niet bestaat, anders ?
        if (!is_null($bestaandeGebruiker)){
            throw new GebruikerBestaatException();
        }
        //**foutafhandeling**//
        $sql = "insert into cursisten (email,paswoord) values (:email, :paswoord)";
        //echo $sql;
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql); 
        
        $paswoord= sha1("Annemie".$this->maakpaswoord());
        //echo "paswoord = ".$paswoord ;
        $stmt->execute(array(':email' => $email, ':paswoord' => $paswoord));

        $gastId = $dbh->lastInsertId();
        $dbh = null; 
        
        $gebruiker = Cursist::create($gastId, $email, $paswoord);
        return $gebruiker;
   } 
    
   public function veranderpaswoord($email){
//       $id=$this->getByEmail($email);
//       if(!$id==null){
        // if(!$this->getByEmail($email)==null){
           $sql="update cursisten set paswoord= :paswoord where email= :email";
           $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
            $stmt = $dbh->prepare($sql);
            //maakpaswoord();
            $paswoord= sha1("Annemie".$this->maakpaswoord());
           $stmt->execute(array(':email' => $email, ':paswoord'=> $paswoord));
           $dbh=null;
//           $gebruiker = Cursist::create($gastId, $email, $paswoord);
//        return $gebruiker;
       
           return;
//       }
//       else{
//          throw new FoutEmailAdresException();
//           //echo "fout emailadres";
//       }
   } 
   public function delete($id) {   //nieuwe functie om boek te verwijderen
    $sql = "delete from gasten where id = :id" ; 
    $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
//    $dbh = new PDO("mysql:host=localhost;dbname=cursusphp;charset=utf8;port=3307","cursusgebruiker","cursuspwd");//;DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
    $stmt = $dbh->prepare($sql);
      $stmt->execute(array(':id' => $id)); 
//    $dbh = null;
    $sql = "delete from login where id = :id" ; 
    $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
//    $dbh = new PDO("mysql:host=localhost;dbname=cursusphp;charset=utf8;port=3307","cursusgebruiker","cursuspwd");//;DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
    $stmt = $dbh->prepare($sql);
      $stmt->execute(array(':id' => $id)); 
    $dbh = null;
   }  
   public function checklogin($email,$paswoord){ //functie die controleert of paswoord past bij voornaam gast
        $sql="SELECT id FROM cursisten WHERE email= :email and paswoord= :paswoord";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
        $stmt = $dbh->prepare($sql);
        $paswoord= sha1("Annemie".$paswoord);
       $stmt->execute(array(':email' => $email, ':paswoord'=> $paswoord));
       $rij = $stmt->fetch(PDO::FETCH_ASSOC);

       if (!$rij) {  //niets gevonden
        //echo "false";
        throw new FoutPaswoordException();
        
       } else {
//        $genre = Genre::create($rij["genre_id"], $rij["genre"]);
//        $boek = Boek::create($rij["boek_id"], $rij["titel"], $genre);
       
       // $_SESSION["gast"]=$rij["id"];
       // echo $_SESSION["gast"]; 
        $dbh = null;
        return true; //wel boek gevonden met titel $titel
       }
   }
    public function getByEmail($email){  //functie om na te gaan of er reeds een boek met deze titel bestaat (foutafhandeling)
        $sql = "select id from cursisten where email = :email" ;
     $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
     $stmt = $dbh->prepare($sql);
       $stmt->execute(array(':email' => $email));
       $rij = $stmt->fetch(PDO::FETCH_ASSOC);
        $dbh = null;
       if (!$rij) {  //niets gevonden
        return null;
       } else {
        $cursist = "bestaat"; //Cursist::create($rij["id"], $rij["email"], $paswoord);
        
        
        return $rij["id"]; //wel boek gevonden met titel $titel
       }

    }  
    
    public function plaatsbestelling($email,$paswoord){
        if(!$this->getByEmail($email)==null){
        if($this->checklogin($email,$paswoord)){
            $bestaandeGebruiker=$this->getByEmail($email);
            //echo $bestaandeGebruiker;
            for($x=0;$x<$_SESSION["aantalbroodjes"];$x++){
                
                $bestelling= $_SESSION["bestellingcursist"][$x][0];
                $prijs= $_SESSION["bestellingcursist"][$x][1];
       
             $sql = "insert into bestellingen (datum,cursist,bestelling,prijs) values (:datum, :cursist, :bestelling, :prijs)";
            //echo $sql;
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $stmt = $dbh->prepare($sql); 
            $datum = date("Y-m-d");

            $stmt->execute(array(':datum' => $datum, ':cursist' => $bestaandeGebruiker, ':bestelling' => $bestelling, ':prijs' => $prijs));
        }}
         $dbh = null;
        return;}
        else{
            throw new EmailBestaatNietException();
        }
    }  
    
    public function haalvoorraad($type){
        //console.log("haalvoorraad");
        $sql = "select voorraad from drank where type= :type";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
      
        //$lijst = array();
        $stmt = $dbh->prepare($sql);
       $stmt->execute(array(':type' => $type));
       $rij = $stmt->fetch(PDO::FETCH_ASSOC);
       
       //echo print_r($resultSet);
       //echo "totaal = ".count($resultSet);
        $dbh = null;
        
       if (!$rij) {  //niets gevonden
           //console.log("fout type");
        throw new FrisDrankException();
       } else {
//       
           $voorraad=$rij['voorraad'];
           
         return $voorraad;
        }
}
public function haalprijs($type){
        //console.log("haalvoorraad");
        $sql = "select prijs from drank where type= :type";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
      
        //$lijst = array();
        $stmt = $dbh->prepare($sql);
       $stmt->execute(array(':type' => $type));
       $rij = $stmt->fetch(PDO::FETCH_ASSOC);
       
       //echo print_r($resultSet);
       //echo "totaal = ".count($resultSet);
        $dbh = null;
        
       if (!$rij) {  //niets gevonden
           //console.log("fout type");
        throw new FrisDrankException();
       } else {
//       
           $prijs=$rij['prijs'];
           
         return $prijs;
        }
}
       }
        