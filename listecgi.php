<?php
include 'connexion/connectpg.php';
include 'connexion/function.php';

if (isset($_POST['typed'])){


      $rsg = $bdd->prepare("SELECT * FROM agencecgi  ");
      $rsg->execute();
      while($rowg = $rsg->fetch()) {

          echo '<option  value="'.$rowg['idcgi'].'">'.$rowg['nomcgi'].'</option>';
      }



}