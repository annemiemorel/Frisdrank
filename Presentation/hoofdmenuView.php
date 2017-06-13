<?php
session_start();

//$prijscola=$lijst[0]->getPrijs();
$voorraad="";
$_SESSION['betaald']=0;

?> 
<!DOCTYPE html>
<html>
    <head>
        <link href="../styles/main.css" rel="stylesheet" type="text/css"> 
        <title>Frisdrank - Hoofdmenu</title>
    </head>
    <body>
         
        <h1>Frisdrank</h1>
        <div style="border: 2px #3399CC solid; padding-left: 1em">
        <p>Maak een keuze en kies een betaalmunt. </p></div>
        
        <br><br>
        <article id="main">
            <form action="" method="POST" action="../hoofdmenuView.php?action=betaal">
        <table><tbody class="overzicht">
                
                <tr>
                    <td>&euro;<input type="submit" value="0.10" name="munt"> </td>
                    <td>&euro;<input type="submit" value="0.20" name="munt"> </td>
                    <td>&euro;<input type="submit" value="0.50" name="munt"> </td>
                    <td>&euro;<input type="submit" value="1" name="munt"> </td>
                    <td>&euro;<input type="submit" value="2" name="munt"> </td>
               
                </tr>
             
         </tbody></table></form>  
                                   
        <!--<form action="" method="POST" action="../kiesfrisdrank.php?action=process">-->
        <table><tbody class="automaat">
                <!--<tr> <td> </td><td><input type="submit" style="font-size:1em" value="Kies" class="kaderknop"></td><td></td></tr>-->
             <tr> <td>Coca Cola</td><td><a href="../kiesfrisdrank.php?action=process&type=cola"><img src="../images/coca-cola.png"  border="1" ></a></td><td><?php print($voorraad); ?></td> </tr>
             <tr> <td>Fanta</td><td><a href="../kiesfrisdrank.php?action=process&type=fanta"><img src="../images/fanta.png" width="3" border="1" ></a></td><td><?php print($voorraad); ?></td></tr>
             <tr> <td>Sprite</td><td><a href="../kiesfrisdrank.php?action=process&type=sprite"><img src="../images/sprite.png" width="3" border="1"></a></td><td><?php print($voorraad); ?></td> </tr>
             <tr> <td>Spa</td><td><a href="../kiesfrisdrank.php?action=process&type=spa"><img src="../images/spa.png" width="3" border="1"></a></td><td><?php print($voorraad); ?></td></tr>
            </tbody></table>
            
        <!--</form>-->
      
         </article>
        <aside style="color:red" id="sidebar">
           
          
        <?php if (isset($_GET["voorraad"]) && $_GET["voorraad"] == "fout") {
        ?>
        
        <p style="color:red">Type drank niet in automaat! </p>
        <?php } 
        if (isset($_GET["voorraad"]) && $_GET["voorraad"] == "opgehaald") {
        ?>
            
        <p style="color:red">Voorraad <?php print($_GET['type']); ?> = <?php print($_SESSION['voorraad']); ?>
            <br> Een <?php print($_GET['type']); ?> kost <?php print($_SESSION['prijs']); ?> &euro;
          <?php   
          if($_SESSION['voorraad']<=0){$voorraad="uitgeput";} ?> </p>
        <?php } 
         if (isset($_GET["action"]) && $_GET["action"] == "betaal") {
            while($_SESSION['betaald']<$_SESSION['prijs']){
            $_SESSION['betaald']+=$_GET['munt'];
            ?><p style="color:red"> Nog <?php ($_SESSION['prijs'] - $_SESSION['betaald']) ?> betalen.</p>
           <?php }
        }
        ?>
        </aside>
        <br>
            
           
    
    </body>
</html>