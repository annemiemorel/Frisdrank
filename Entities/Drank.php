<?php
namespace Entities;
use Entities\Drank;

class Drank {

 private static $idMap = array();  //bevat alle reeds aangemaakte objecten van klasse Voornaam; static: slechts 1 lijst voor alle Voornaam-objecten   
 private $id;
 private $type;
 private $voorraad;
 private $prijs;

 private function __construct($id, $type, $voorraad,$prijs) {
 $this->id = $id;
 $this->type = $type;
 $this->voorraad = $voorraad;
 $this->prijs= $prijs;
 
}

 public static function create($id, $type, $voorraad, $prijs){
     if (!isset(self::$idMap[$id])) {  //geindexeerd met id van Boek-object: snel controleren of Boek-object met bepaalde id werd aangemaakt zonder hele array te overlopen
   self::$idMap[$id] = new Drank($id, $type, $voorraad, $prijs);  //indien er nog geen Boek-object met dit id bestaat, dan nieuw Boek-object aanmaken via constructor en aan lijst toevoegen
  } 
  return self::$idMap[$id];  //indien er wel Boek-object met dit id bestaat, dan wordt het bestaande object teruggegeven
 }
 
 public function getId() {
  return $this->id;
 }
 
 public function getType() {
  return $this->type;
 }
 
 public function getVoorraad(){
     return $this->voorraad;
 }
 
public function getPrijs(){
    return $this->prijs;
}
 public function setType($type) {
  $this->type = $type;
 }
 
 public function setVoorraad($voorraad){
     $this->voorraad=$voorraad;
}
public function setPrijs($prijs){
    $this->prijs=$prijs;
}
 
}