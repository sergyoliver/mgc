<?php
error_reporting(0);
include "../connexion/connectpg.php";
include "../connexion/function.php";
if (isset($_POST['idst']) && isset($_POST['idd']) && isset($_POST['idseq']) && !empty($_POST['idst']) && !empty($_POST['idd'])) {
    $myObj = NULL;
    $id = $_POST['idseq'];
    $recupst = $bdd->prepare('select * from table_detailseqchrono ds,table_soustache r WHERE ds.id_dseq=:idd and ds.id_seq=:idse and ds.id_stache=r.idsstach and ds.id_tache=r.id_tach and ds.id_stache=:idst and ds.supp=0');
    $recupst->execute(array("idst" => $_POST['idst'], 'idse' => $id, 'idd' => $_POST['idd']));
    $row = $recupst->fetch();

    $myObj->idd = $row['id_dseq'];
    $myObj->idst = $row['idsstach'];
    $myObj->exect = $row['executant'];
    $myObj->dbut = format_date2($row['date_debut']);
    $myObj->dfin = format_date2($row['date_fin']);

    $myJSON = json_encode($myObj);
    echo $myJSON;
}
?>
