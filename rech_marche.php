<?php
require('connexion/function.php');
require ('connexion/connectpg.php');
if (isset($_POST['idp'])){

      $i=1;
         $rsg = $bdd->prepare('select * from   tab_projet WHERE typeprojet = :tp');
          $rsg->execute(array("tp"=>$_POST['idp']));
          ?>
    <option value="all" > Tous les marchés </option>
    <?php
                 while($rowg = $rsg->fetch()) {
                                           
                                          ?>      
 <option value="<?php echo $rowg['id_projet'] ?>"><?php echo $rowg['Num_Contrat'].'-'.$rowg['Intitule_Contrat'] ?></option>
<?php
}} ?>