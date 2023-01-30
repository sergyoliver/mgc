<?php
session_start();
error_reporting(0);
include 'connexion/connectpg.php';
include 'connexion/function.php';
include 'connexion/functionpchronoseq.php';

if(!empty($_POST['t'])   && !empty($_POST['db1']) && !empty($_POST['df1'])  && $_POST['taux']>=0) {
    $code = passAlea(3);

    $select = array();
    $select['code'] =$code;
    $select['tache'] =$_POST['t'];
    $select['taux'] =intval($_POST['taux']);
    $select['id_sstach'] = $_POST['st'];
    $select['date_debut'] = $_POST['db1'];
    $select['date_fin'] = $_POST['df1'];
var_dump($select);
    ajout($select);

    $nbreart = count($_SESSION['panier']['id_sstach']);

    $n1 = $pn1 = 0;
    $t = 1;


    ?>
    <div class="form-group row">
        <div class="col-lg-9 input_field_sections"></div>
        <div class="col-lg-3">
            <input class="btn btn-primary  mb-0-25 waves-effect waves-light" onclick="vide()" type="button" value="Vider le tableau ">
        </div>
    </div>
    <br />
    <div class="input-group">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-advance table-hover table_status_padding">
                <thead>
                <tr>
                    <th>#</th>
                    <th>
                        Rubrique
                    </th>
                    <th>
                        taux %
                    </th>
                    <th>
                        Sous Rubrique
                    </th>

                    <th class="hidden-xs">
                        Date début
                    </th>
                    <th class="hidden-xs">
                        Date fin
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                // echo $nbreart;
                // var_dump($_SESSION['panier']['prix']);
                for($si1 = 0; $si1 < $nbreart; $si1++) {

                    ?>
                    <tr style="vertical-align: middle;">
                        <th><?php echo $t ?></th>
                        <td><?php echo $_SESSION['panier']['tache'][$n1]; ?></td>
                        <td><?php echo $_SESSION['panier']['taux'][$n1]; ?></td>
                        <td><?php echo $_SESSION['panier']['id_sstach'][$n1]; ?></td>
                        <td><?php echo $_SESSION['panier']['date_debut'][$n1]; ?></td>
                        <td><?php echo $_SESSION['panier']['date_fin'][$n1]; ?></td>
                        <td onclick="fctClick(this)">
                            <input type="hidden" id="input_<?php echo $n1 ?>" value="<?php echo $_SESSION['panier']['code'][$n1] ?>">
                            <input class="btn btn-success" type="button" value="Supprimer">
                        </td>
                    </tr>
                    <?php
                    $n1++;
                    $t++;
                } ?>

                </tbody>
            </table>
        </div>
    </div>
    <?php
}else{
    echo '<span style="color: red">Veuillez renseigner les champs Obligatoires</span>';
}
?>