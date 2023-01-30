<?php
/*
 $dbname = "lotiges_bcp";
  $host = "localhost";
  $dbuser = "lotiges_rootbcp";
  $dbpass = "XqKkzx-b1YEg";

*/
$dbname = "bcp_new";
$host = "localhost";
$dbuser = "root";
$dbpass = "";

try{
        $bdd = new PDO ("mysql:host=".$host.";dbname=".$dbname."", "".$dbuser."", "".$dbpass."") or die(print_r($bdd->errorInfo()));


    }

    catch(Exception $e){
        die("Erreur ! ".$e->getMessage());
    }





/*
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=a2cmimbo_bd;charset=utf8', 'a2cmimbo_user1', 'vaH8dfM6L2Fb',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)

{

    echo 'Erreur : '.$e->getMessage().'<br />';

    echo 'N° : '.$e->getCode();

}*/
?>