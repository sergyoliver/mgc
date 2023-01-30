<?php
session_start();
ob_start();


       require 'connexion/connectpg.php';
       require('connexion/function.php');


        // oon verifie s'il existe dans la table copnnexion
        $rsc = $bdd->prepare('select * from tab_connexion where iduser= :iduser and statconn = :statc');
        $rsc->execute(array('iduser' => $_SESSION['id'], 'statc' =>1));
        $nbc = $rsc->rowCount();
        // insere info connexion
    // on reccupere l email des admin


        if($nbc==0)
        {
            $rs2 = $bdd->prepare('INSERT INTO tab_connexion(iduser, dateconn, statconn) VALUES(:iduser, :datc, :statc)');
            $rs2->execute(array('iduser' => $_SESSION['id'], 'datc' => gmdate("Y-m-d H:i:s"), 'statc' => 0));
        }else{
            // mise a jour dans la BD
            $rsmajcon = $bdd->prepare('UPDATE tab_connexion SET dateconn = :datc, statconn = :statc WHERE iduser = :iduser');
            $rsmajcon->execute(array('datc' => gmdate("Y-m-d H:i:s"), 'statc' => 0 ,'iduser' => $_SESSION['id']));
        }

        $rs3 = $bdd->prepare('INSERT INTO tab_histoconnexion(ipaddress, user_email, dateconn, statconn) VALUES(:ipadress, :log, :datc, :statc)');
        $rs3->execute(array('ipadress' => get_ip(), 'log' => $_SESSION['email'] ,'datc' => gmdate("Y-m-d H:i:s"), 'statc' => 0));


    unset($_SESSION['nom']);
    unset($_SESSION['identite']);
    unset($_SESSION['email']);
    unset($_SESSION['id']);
    unset($_SESSION['gpe']);
    unset($_SESSION['dgpe']);
    unset($_SESSION['mat']);
    unset($_SESSION['pwd']);
    unset($_SESSION['zoneid']);
    unset($_SESSION['zone']);
    unset($_SESSION['photo']);

    session_destroy();/**/

    header("location:index.php");

ob_end_flush() ;
?>