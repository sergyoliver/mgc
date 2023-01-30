<?php
require('connexion/function.php');
require ('connexion/connectpg.php');
if (isset($_POST['idp'])){

         $i=1;
         $id = $_POST['idp'];
         $rsg = $bdd->prepare('select * from   tab_projet WHERE typeprojet = :tp');
          $rsg->execute(array("tp"=>$_POST['idp']));

          ?>
    <option value="all" > Tous les marchés </option>
    <?php
                 while($rowgf = $rsg->fetch()) {
                                          
                                          ?>      
 <option value="<?php echo $rowgf['id_projet'] ?>">
   <?php echo $rowgf['Num_Contrat'].'-'.$rowgf['Intitule_Contrat'] ?>
      
   </option>
<?php
}} ?>