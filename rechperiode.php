<?php
if (isset($_POST['marche'])) {
    require('connexion/function.php');
    require('connexion/connectpg.php');

    $rsg = $bdd->prepare('SELECT * FROM fournisseurs, contrat WHERE fournisseurs.id_fournisseurs=contrat.id_fournisseurs and contrat.supp=0 AND id_Contrat= :m  ORDER BY id_Contrat  ASC ');
    $rsg->execute(array("m" => $_POST['marche']));
    $row = $rsg->fetch();
    if ($row){
    if (empty($row['Name_entreprise'])) $nomf =$row['nom_rep'];  else $nomf =$row['Name_entreprise'];
    ?>

    <div class="col-lg-6 input_field_sections">
        <div class="form-group">
            <label class="control-label">Fournisseur retenus </label>
            <div class="input-group">
                <input type="text" class="form-control" placeholder= id="fournisseur" readonly style="font-weight: bold;background-color: rgba(255,118,22,0.13) " name="fournisseur" value="<?= $nomf ?>">
                <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i></span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 input_field_sections">
        <div class="form-group">
            <label class="control-label">Date début </label>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="dd-mm-yyyy" id="" name="dbut" value="<?= format_date2($row['Date_signature_C']) ?>" required >
                <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i></span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 input_field_sections">
        <div class="form-group">
            <label class="control-label">Date fin </label>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="dd-mm-yyyy" id="" name="dfin" value="<?= format_date2($row['Date_achevement']) ?>" required>
                <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i></span>

            </div>
            <input type="hidden" value="<?= $row['idmarche'] ?>" name="march">
            <input type="hidden" value="<?= $row['id_fournisseurs'] ?>" name="four">
        </div>
    </div>

    <?php
}}
?>