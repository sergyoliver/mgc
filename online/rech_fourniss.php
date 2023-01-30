<?php
require('connexion/function.php');
require ('connexion/connectpg.php');
if (isset($_POST['idf'])){
        $rscag = $bdd->prepare('select * from tab_depot WHERE idmarche = :tp');
        $rscag->execute(array("tp"=>$_POST['idf']));
        $rowf = $rscag->fetch();?>
        <option selected disabled>
            Selectionner un Fournisseur

        </option>
        <?php 

          while($rowf = $rscag->fetch()) {
         $i=1;
        $idc = $rowf['id_fournisseurs'];
                $rsg = $bdd->prepare('select * from   fournisseurs WHERE id_fournisseurs = :tp');
                $rsg->execute(array("tp"=>$idc));
                    while($rowc = $rsg->fetch()) {
                                                ?>
        <option value="<?php echo $rowc['id_fournisseurs'];?>">    
        <?php  echo $rowc['Name_entreprise']; ?>      
        </option>

        <?php }
                         
       } }?>