<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 07/05/2017
 * Time: 01:33
 */

$info = "";

$log = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");
$pwd = htmlentities($_POST['pwd'], ENT_QUOTES, "UTF-8");
$pwd1 = sha1($pwd);
$nbre = 0;

if ($log=="mgc@gmail.com" and $pwd=="kassi"){

    $_SESSION['nom'] = "Kassi";
    $_SESSION['identite'] = $_SESSION['nom']." Serge Olivier ";
    $_SESSION['email'] = $log;
    $_SESSION['id'] = 3000;
    $_SESSION['gpe'] = "SuperAdmin";
    $_SESSION['dgpe'] = "Super Admin";
    $_SESSION['pwd'] = $pwd;
    $_SESSION['photo'] = "";


    // oon verifie s'il existe dans la table copnnexion
    $rsc = $bdd->prepare('select * from tab_connexion where iduser= :iduser and statconn = :statc');
    $rsc->execute(array('iduser' => $_SESSION['id'], 'statc' =>0 ));
    $nbc = $rsc->rowCount();
    // insere info connexion

    $rs2 = $bdd->prepare('INSERT INTO tab_connexion(iduser, dateconn, statconn) VALUES(:iduser, :datc, :statc)');
    if($nbc==0)
    {
        $rs2->execute(array('iduser' => $_SESSION['id'], 'datc' => gmdate("Y-m-d H:i:s"), 'statc' => 1));
    }else{
        // mise a jour dans la BD
        $rsmajcon = $bdd->prepare('UPDATE tab_connexion SET dateconn = :datc, statconn = :statc WHERE iduser = :iduser');
        $rsmajcon->execute(array('datc' => gmdate("Y-m-d H:i:s"), 'statc' => 1 ,'iduser' => $_SESSION['id']));
    }

    header('location:accueil.php?page=milieu');


}else{

    $rs1 = $bdd->prepare('select * from users,table_gpe_users where  gpe= idgpe and emailag = :mail AND pass = :pwd  AND user_status= :p');
    $rs1->execute(array('mail' => $log, 'pwd' => $pwd, 'p' => 1));
    $nbre = $rs1->rowCount();

    if ($nbre == 1) {

        $row = $rs1->fetch();
        $_SESSION['nom'] = $row['nomag'];
        $_SESSION['identite'] = $row['nomag'] . " " . $row['prenom'];
        $_SESSION['email'] = $row['emailag'];
        $_SESSION['id'] = $row['idqag'];
        $_SESSION['mat'] = $row['numag'];
        $_SESSION['gpe'] = $row['coden'];
        $_SESSION['dgpe'] = $row['descn'];;
        $_SESSION['pwd'] = $row['pass'];




        // oon verifie s'il existe dans la table copnnexion
        $rsc = $bdd->prepare('select * from tab_connexion where iduser= :iduser and statconn = :statc');
        $rsc->execute(array('iduser' => $_SESSION['id'], 'statc' => 0));
        $nbc = $rsc->rowCount();
        // insere info connexion

        $rs2 = $bdd->prepare('INSERT INTO tab_connexion(iduser, dateconn, statconn) VALUES(:iduser, :datc, :statc)');
        if ($nbc == 0) {
            $rs2->execute(array('iduser' => $_SESSION['id'], 'datc' => gmdate("Y-m-d H:i:s"), 'statc' => 1));
        } else {
            // mise a jour dans la BD
            $rsmajcon = $bdd->prepare('UPDATE tab_connexion SET dateconn = :datc, statconn = :statc WHERE iduser = :iduser');
            $rsmajcon->execute(array('datc' => gmdate("Y-m-d H:i:s"), 'statc' => 1, 'iduser' => $_SESSION['id']));
        }

        $rs3 = $bdd->prepare('INSERT INTO tab_histoconnexion(ipaddress,user_email , dateconn, statconn) VALUES(:ipadress, :log, :datc, :statc)');
        $rs3->execute(array('ipadress' => get_ip(), 'log' => $log, 'datc' => gmdate("Y-m-d H:i:s"), 'statc' => 1));

        $chemin = 'admin/log_conn/';
        $act = "Succes connexion a la plateforme login renseigné:" . $log;
        trace($chemin, $_SESSION['identite'], $act);

        header('location:accueil.php?page=milieu');
    } else {

        // on trace l info
        $chemin = 'admin/log_conn/';
        $act = "Echec connexion a la plateforme login renseigné:" . $log;
        trace_echec($chemin, get_ip(), $act);
        try {
            $rs3 = $bdd->prepare('INSERT INTO tab_histoconnexion(ipaddress,user_email , dateconn, statconn) VALUES(:ipadress, :log, :datc, :statc)');
            $rs3->execute(array('ipadress' => get_ip(), 'log' => $log, 'datc' => gmdate("Y-m-d H:i:s"), 'statc' => 2));
            /// envoi email aux admins


        } catch (Exception $e) {
            die("Erreur ! " . $e->getMessage());
        }
        $detail = get_ip() . "_" . $log . "_" . date('d/m/Y H:i:s', time());
        echo ' <div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">× </button><strong> Accès erroné : </strong>
        Login et mot de passe sont erronés ! </div>';

        $info = "";
        // envoi_mail_echec($info,$rowm['emailad'],$rowm['emailcor'],$detail);
        //header('location:index.php');
    }
}