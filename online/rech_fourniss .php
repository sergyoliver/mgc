<?php
require('connexion/function.php');
require ('connexion/connectpg.php');
if (isset($_POST['idf'])){

      $i=1;
           $idf1 = $_POST['idf']);
           $rscag = $bdd->prepare('select * from   tab_depot WHERE idmarche = :idf1');
           $rscag->execute();
           $idc = $rscag['id_fournisseurs'];
           $rsg = $bdd->prepare('select * from   fournisseurs WHERE id_fournisseurs = :idc');
            $rsg->execute(array("tp"=>$idc));

          ?>
    <option value="all" > Tous les fournisseurs</option>
    <?php
                 while($rowgf = $rsg->fetch()) {
                         ?>      
 <option value="<?php echo $rowgf['id_fournisseurs'] ?>" <?php if(isset($rscag['id_fournisseurs']) && $rscag['id_fournisseurs']==$rowgf['id_fournisseurs']){ echo "selected";} ?>>
   <?php echo $rowgf['Name_entreprise']; ?>
      
</option>
<?php
}} ?>