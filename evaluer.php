<?php
session_start();
error_reporting(0);
include "connexion/connectpg.php";
include "connexion/function.php";
if (($_POST['idd'])) {
    $nomtab10 = "table_evaluation";
    $tab10 = array('idchro' => $_POST['idpl'], 'iddetail' => $_POST['idd'],'rapport' => $_POST['com'],'datedb' => formatinv_date($_POST['db']),'datefin' =>formatinv_date($_POST['df']), 'Taux' => $_POST['taux'], 'dateenr' =>  gmdate("Y-m-d H:i:s"), 'idenr' =>  $_SESSION['id']);
    //var_dump($tab10);
    $sql = insert_tab($nomtab10, $tab10);
    $sql->execute($tab10);
}
?>
