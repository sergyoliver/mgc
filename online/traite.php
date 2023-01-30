<?php
require('connexion/function.php');
require ('connexion/connectpg.php');
if (isset($_POST['idtypre'])){

      $i=1;
         $rsg = $bdd->prepare('select * from   prestations WHERE idtype_prest = :idtypre');
          $rsg->execute(array("idtypre"=>$_POST['idtypre']));
                 while($rowg = $rsg->fetch()) {
                                           
                                          ?>      
 <option value="<?php echo $rowg['idprest'] ?>"><?php echo $rowg['libprestation'] ?></option>
<?php
}} ?>