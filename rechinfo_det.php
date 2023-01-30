<?php
error_reporting(0);
include "connexion/connectpg.php";
include "connexion/function.php";
if (($_POST['idq'])) {
    $myObj = NULL;
    $id = $_POST['idq'];
    $recupst = $bdd->prepare('select * from table_detailseqchrono  WHERE codepl= :dt ');
    $recupst->execute(array("dt" =>$id));
    $row = $recupst->fetch();

    $myObj->tache = $row['tache'];
    $myObj->taux = $row['tauxrep'];
    $myObj->id = $row['id_dseq'];
    $myObj->idl = $row['id_pl'];
    $myJSON = json_encode($myObj);
    echo $myJSON;
}
?>
