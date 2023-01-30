<?php
if (isset($_SESSION['num']) &&  isset($_SESSION['email']) && isset($_SESSION['gpe'])) {
    if (isset($_GET['id']) && isset($_GET['op'])){
        $idres = $_GET['id'];
        $idop = $_GET['op'];

        $reqadh = $bdd->prepare('select * from table_frais_adhesion where id_res=:idres and supp=0');
        $reqadh->execute(array('idres' => $idres));
        $nbreadh = $reqadh->rowCount();


        $rsg = $bdd->prepare('select * from table_reservationlot tr, table_dossierclient tdc WHERE  tr.idclt= tdc.iddocclt AND idop= :kjd AND idres= :lkj and tr.supp=0');
        $rsg->execute(array('kjd' => $idop, 'lkj' => $idres));
        $rowg = $rsg->fetch();
        $gid = $rowg['gidlot'];
        $civ = $rowg['civilite'];
        $name = $rowg['nomacq'];
        $mntac  = $rowg['acompte'];
        $tabop = $rowg['tabop'];
        $gilot = $rowg['gidlot'];
        $nbmois= $rowg['dureeech'];
        $mntech = $rowg['mntecheance'];
        $datedbech = $rowg['datedbecheance'];
        $avanceech= $rowg['mntecheancetot'];
        $clt = $rowg['idclt'];
        $nomclt = $rowg['nomacq'];
        $telclt= $rowg['contact'];
        $pu = $rowg['prixvente'];
        $codevers = $rowg['matreservation'];
        $supsup = $rowg['superficiesup'];

        $rsgop2 = $bdd->prepare('select * from table_operation WHERE  table_operation.idop= :idop');
        $rsgop2->execute(array("idop"=>$idop));
        $rowgop2 = $rsgop2->fetch();

        $tablot = $rowgop2['tablelot'];
        $typebien = $rowg['typebien'];
        $masse = $rowgop2['tablemasse'];
        $nomop = $rowgop2['nomop'];

        if ($typebien=='terrain'){
            $rstab = $bdd->prepare('select * from '.$tablot.'  WHERE  gid = :t ');
            $rstab->execute(array("t"=>$gid));
            $rowgtab = $rstab->fetch();
            $ilotlo = $rowgtab['nilot']."/".$rowgtab['nlot'];
            $stand =  $rowgtab['standing'];
            $st = $rowgtab['p'];
            $sup =$rowgtab['sup'];
        }else{
            $rstabmasse = $bdd->prepare('select * from '.$masse.'  WHERE  gid = :t ');
            $rstabmasse->execute(array("t"=>$gid));
            $rowtabmasse = $rstabmasse->fetch();
            $nlot = $rowtabmasse['nlot'];
            $st = $rowtabmasse['p'];
            //echo $tablot;
            try{  /// ilot
                $rslot = $bdd->prepare('select * from  '.$tablot.'  WHERE nlot =:nlot ');
                $rslot->execute(array("nlot"=> $nlot));
                $rowlot = $rslot->fetch();
            }catch(Exception $e){

                die("Erreur ! ".$e->getMessage());

            }
            $nilot =$rowlot['nilot'];
            $sup = $rowlot['sup'];
            $ilotlo = $rowlot['nilot']."/".$rowlot['nlot'];
            $stand =$rowtabmasse['standing'];
        }


        $suptot =$sup+$supsup;

//        $mnt = $bdd->prepare('select sum(mntp) as totalsom, count(*) as nbv from table_recapversement WHERE  idres= :idres and supp=0');
//        $mnt->execute(array('idres' => $idres));
//        $rowvers = $mnt->fetch();
//        $nbv = $rowvers['nbv'];


//        $montvers = $rowvers['totalsom'];

        /// total penalite du reservataire

        $prixvent = $rowg['prixvente'];

        $typdevente = '';

        if($rowg['typedevente'] == 'VD'){
            $typdevente = "VENTE DIRECTE";
        }
        else if($rowg['typedevente'] == 'PB'){
            $typdevente =  "PRET BANCAIRE ";
        }
        else if($rowg['typedevente'] == 'VE'){
            $typdevente =  "VENTE PAR ETAPE ";
        }

        $rstab = $bdd->prepare('select * from ' . $tabop . '  WHERE  gid= :t');
        $rstab->execute(array("t" => $gilot));
        $rowgtab = $rstab->fetch();
        $typmaison = $rowgtab['name'];

        $kij = $bdd->prepare('select * from table_catmaison WHERE libcat= :msdl AND idop =:mlo');
        $kij->execute(array("msdl" => $typmaison, "mlo"=>$idop));
        $kolp = $kij->fetch();
        $icat = $kolp['idcat'];
        $typ = $kolp['descriptioncat'];


        $penal = $bdd->prepare('select sum(mnt_penalite) as totlpenal, count(*) nbpnlt from table_penalite  WHERE idres = :id and supp=0 ');
        $penal->execute(array("id" => $idres));
        $rowpenal = $penal->fetch();
        $nbpnlt = $rowpenal['nbpnlt'];


        $reqrvers = $bdd->prepare('select sum(mntp) as mntp from table_recapversement where idres=:idr and supp=0');
        $reqrvers->execute(array('idr' => $idres));
        $rowrvers = $reqrvers->fetch();
        $reqrvers1 = $bdd->prepare("select * from table_recapversement where idres=:idr and supp=0 and date_part('year', dateenr)=:a");
        $reqrvers1->execute(array('idr' => $idres, 'a' => gmdate('Y')));
        $nbrervers = $reqrvers1->rowCount();


        $montarecouv = ($prixvent + $rowpenal['totlpenal']) - $mntac;
        $resteapaye = ($prixvent + $rowpenal['totlpenal']) - $rowrvers['mntp'];

        $paye = $rowrvers['mntp'];

        if ($paye <  $mntac) {
            $mntbtac = $paye;
            $mntrestac = $mntac - $paye;
        } else {
            $mntbtac = $mntac;
            $mntrestac = 0;
        }

        $reqtper = $bdd->prepare("select * from table_trop_percu where idres=:idr and supp=0 and date_part('year', datevalide)=:a");
        $reqtper->execute(array('idr' => $idres));
        $nbretp = $reqtper->rowCount();

        $reqpl = $bdd->prepare('select * from table_planningechanier where idresv=:idres and supp=0');
        $reqpl->execute(array('idres' => $idres));
        $rowpl = $reqpl->fetch();
        $nbrepl = $reqpl->rowCount();

//        $reqpl1 = $bdd->prepare('select * from table_echeancier where idres=:idres');
//        $reqpl1->execute(array('idres' => $idres));
//        $rowpl1 = $reqpl1->fetch();
//        $nbrepl1 = $reqpl1->rowCount();

      //  $reqrvers12 = $bdd->prepare("select * from table_versement where idreser=:idr and supp=0 and date_part('year', dateenr)=:a");
      //  $reqrvers12->execute(array('idr' => $idres, 'a' => gmdate('Y')));
       // $nbrev = $reqrvers12->rowCount();


    }
    ?>
    <link type="text/css" rel="stylesheet" href="vendors/jasny-bootstrap/css/jasny-bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="vendors/bootstrapvalidator/css/bootstrapValidator.min.css"/>
    <!--End of plugin styles-->
    <!--Page level styles-->
    <link type="text/css" rel="stylesheet" href="vendors/jasny-bootstrap/css/jasny-bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="vendors/bootstrapvalidator/css/bootstrapValidator.min.css"/>
    <link type="text/css" rel="stylesheet" href="vendors/inputlimiter/css/jquery.inputlimiter.css"/>
    <link type="text/css" rel="stylesheet" href="vendors/chosen/css/chosen.css"/>
    <link type="text/css" rel="stylesheet" href="vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css"/>
    <link type="text/css" rel="stylesheet" href="vendors/jquery-tagsinput/css/jquery.tagsinput.css"/>
    <link type="text/css" rel="stylesheet" href="vendors/daterangepicker/css/daterangepicker.css"/>
    <link type="text/css" rel="stylesheet" href="vendors/datepicker/css/bootstrap-datepicker.min.css"/>
    <link type="text/css" rel="stylesheet" href="vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
    <link type="text/css" rel="stylesheet" href="vendors/bootstrap-switch/css/bootstrap-switch.min.css"/>
    <link type="text/css" rel="stylesheet" href="vendors/jasny-bootstrap/css/jasny-bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="vendors/fileinput/css/fileinput.min.css"/>
    <link type="text/css" rel="stylesheet" href="css/pages/form_elements.css"/>
    <link type="text/css" rel="stylesheet" href="#" id="skin_change"/>
    <header class="head">
        <div class="main-bar row">
            <div class="col-sm-6 col-lg-5 skin_txt">
                <h4 class="nav_top_align">
                    Paiment
                </h4>
            </div>
            <div class="col-sm-6 col-lg-7">
                <ol class="breadcrumb float-xs-right nav_breadcrumb_top_align">
                    <li class="breadcrumb-item">
                        <a href="?page=milieu">
                            <i class="fa fa-home" data-pack="default" data-tags=""></i>
                            Tableau de Bord
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="?page=faireversement">
                            Nouveau versement
                        </a>
                    </li>
                    <li class="active breadcrumb-item">Faire versement</li>
                </ol>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container forms">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-inverse">
                        <div class="card-header card-info">
                            &nbsp; Informations reservataire
                        </div>
                        <div class="card-block" style="background-color: #b7b2b2; color: #000000; font-size: 12pt">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            Projet : <b><?php echo ucwords($nomop); ?></b>
                                        </div>
                                        <div class="col-lg-12">
                                            Numero reservation : <b><?php echo $rowg['matreservation']; ?></b>
                                        </div>
                                        <div class="col-lg-12" style="font-size: 16px;">
                                            Type de bien : <b><?php if ($typebien=="terrain") echo $typebien; else {echo "Maison(".$typ.")";}?></b>
                                        </div>
                                        <div class="col-lg-12">
                                            Standing : <b><?= $stand ?> </b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            Reservataire :  <b><?php echo $rowg['nomacq']; ?></b>
                                        </div>
                                        <div class="col-lg-12">
                                            Ilot/Lot : <b> <?php echo $ilotlo ;?></b>
                                        </div>
                                        <div class="col-lg-12">
                                            Type de vente : <b><?php  echo $typdevente; ?></b>
                                        </div>
                                        <div class="col-lg-12">
                                            Superficie : <b><?php  echo $suptot; ?> m²</b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            prix d'acquisition : <b><?php  echo separer_montant($prixvent)." FCFA"; ?></b>
                                        </div>
                                        <?php if ($mntbtac==$mntac) { ?>
                                        <?php } else { ?>
                                            <div class="col-lg-12">
                                                Apport initial :  <b><?php echo separer_montant($mntac). " F CFA" ?></b>
                                            </div>
                                        <?php }?>
                                        <?php if ($nbreadh==0) { ?>
                                            <div class="col-lg-12">
                                                Frais adhésion :  <b><?php echo separer_montant($rowg['mntdoc']). " F CFA" ?></b>
                                            </div>
                                        <?php }?>
                                        <div class="col-lg-12">
                                            Payé : <b> <?php echo separer_montant($paye) ;?> FCFA</b>
                                        </div>
                                        <div class="col-lg-12">
                                            Reste à payer : <b> <?php if ($resteapaye<0) echo 0; else echo separer_montant($resteapaye)." Fcfa"; ?> FCFA</b>
                                        </div>
                                        <?php if ($nbrepl>0) { ?>
                                            <div class="col-lg-12">
                                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#echeancier">échéancier</button>
                                            </div>
                                        <?php } ?>
                                        <!--- responsive model -->
                                        <div class="modal fade in display_none" id="echeancier" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title text-white">
                                                            Echéancier
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card">
                                                                    <div class="card-block">
                                                                        <h3 class="text-gray-dark">Type échéance : <?= $rowpl['typechean'] ?></h3>
                                                                        <div class="table-responsive m-t-35">
                                                                            <table class="table table-bordered">
                                                                                <?php
                                                                                $rsgs = $bdd->prepare('select * from table_detailsplannech  WHERE idplannech= :idp AND sup = 0 ORDER BY iddetails ASC ' );
                                                                                $rsgs->execute(array("idp"=>$rowpl['idplech']));
                                                                                ?>
                                                                                <thead>
                                                                                <tr>
                                                                                <tr>
                                                                                    <th>N°</th>
                                                                                    <?php if ($rowpl['typechean'] == "par etape"){ ?>
                                                                                        <th>Evolution</th>
                                                                                        <th>Taux</th>
                                                                                    <?php }else{ ?>
                                                                                        <th>Date d'échéance</th>
                                                                                    <?php } ?>
                                                                                    <th>Montant</th>

                                                                                </tr>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php
                                                                                $i = 1;
                                                                                while ($rowech = $rsgs->fetch()) {
                                                                                    $reqt = $bdd->prepare('select * from table_configtaux tc, table_detailsconfigtaux tdc where tdc.evol=:evl and tc.supp=0 and tc.idproj=:op and tc.idtypb=:tp and tc.idconfig=tdc.idconfigtaux');
                                                                                    $reqt->execute(array('op' => $idop, 'tp' => $icat, 'evl' => $rowech['evolution_proj']));
                                                                                    $rowtaux = $reqt->fetch();
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td><?php echo $i; ?></td>
                                                                                        <?php if ($rowpl['typechean'] == "par etape"){
                                                                                            $rsp = $bdd->prepare('select * from table_etapecheancier_1 WHERE idetapech = :pol');
                                                                                            $rsp->execute(array("pol"=>$rowech['evolution_proj']));
                                                                                            $rowp = $rsp->fetch();
                                                                                            ?>
                                                                                            <td>
                                                                                                <?php echo ucwords($rowp['libech']); ?>
                                                                                            </td>

                                                                                            <td>
                                                                                                <?= $rowtaux['taux']; ?> %
                                                                                            </td>

                                                                                        <?php }else{ ?>
                                                                                            <td><?php echo date('d-m-Y', strtotime($rowech['datevers'])); ?></td>
                                                                                        <?php } ?>
                                                                                        <td> <b><?php echo separer_montant($rowech['montantvers']); ?> FCFA</b> </td>
                                                                                    </tr>
                                                                                    <?php $i++;
                                                                                    $total += $rowech['montantvers'];
                                                                                    $totaltx +=$rowtaux['taux'];
                                                                                } ?>
                                                                                <tr>
                                                                                    <th colspan="2" style="background-color: #c8c8ce">TOTAL</th>
                                                                                    <?php if ($rowpl['typechean'] == "par etape"){ ?>
                                                                                        <td  style="background-color: #c8c8ce"><b style="color: #fd0000;"><?php  echo  $totaltx ;?> %</b></td>
                                                                                    <?php  }?>
                                                                                    <td colspan="2" style="background-color: #c8c8ce"><b style="color: #fd0000;"><?php  echo  separer_montant($total) ;?> FCFA</b></td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" data-dismiss="modal" class="btn btn-primary">Femer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END modal-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <!--                        <div class="card-header bg-white">-->
                        <!--                            Nouvelle depense (--><?php // echo $rowg['obs'] ?><!--): reste à payer  --><?php // echo separer_montant($resteapayer) ?><!-- Fcfa-->
                        <!--                        </div>-->
                        <div class="card-block">
                            <?php

                            $datejr = gmdate("Y-m-d H:i:s");
                            if (isset($_POST['ok'])){
                                require ('connexion/connectpg.php');
//                            require('connexion/function.php');
                                $photo = $_FILES['doc']['name'];
                                $modep = $_POST['mdp'];
                                $mntp = $_POST['mntp'];
                                $compensateur = $_POST['compensateur'];
                                $num_bq = $_POST['num_bq'];

                                if (empty($_POST['datevers'])) {
                                    $datevers = $datejr;
                                } else {
                                    $datevers = $_POST['datevers'];
                                }
                                if (empty($_POST['datevers_bq'])) {
                                    $datevers_bq = "0000-00-00 00:00:00";;
                                } else {
                                    $datevers_bq = $_POST['datevers_bq'];
                                }

                                $matricule = $_SESSION['mat'];
                                $id_bq_emet = $_POST['b_emet'];
                                $id_bq_recep = $_POST['id_bq'];

                                if (empty($_POST['b_emet'])) {
                                    $id_bq_emet = 0;
                                }
                                if (empty($_POST['id_bq'])) {
                                    $id_bq_emet = 0;
                                }

                                $idenr = $_SESSION['num'];
                                $numversement = "ADH".date('y').$idres."-".initial($rowg['nomacq']);
                               // $numacpt = "ACPT".date('y').$idres."-".initial($rowg['nomacq'])."-".numauto($nbreac+1);
                              //  $numverse = "VERS".date('y').$idres."-".initial($rowg['nomacq'])."-".numauto($nbrev+1);
                               $numvers = "VERS".date('y'). $idres."-".initial($rowg['nomacq'])."-".numauto($nbrervers+1);
                               $numtpercu = "TPERCU".date('y').$idres."-".initial($rowg['nomacq'])."-".numauto($nbretp+1);

                                if (!empty($photo) ) {
                                    $tab = explode(".", $photo);
                                    $ph1 = ajoutitret($tab[0]);
                                    $ph2 = $tab[1];
                                    $photor = "scanbord" . pwd_aleatoire(4) . "." . $ph2;

                                    $content_dir = 'img/bordereau/'; // dossier o� sera d�plac� le fichier
                                    $tmp_ph = $_FILES['doc']['tmp_name'];

                                    // INSERTION DU VERSEMENT DES FRAIS DE DOSSIER
                                    if ($_POST['typeregle'] == "frais_adhesion") {
                                        try {
                                            $nomtab_ad = "table_frais_adhesion";
                                            $tab_ad = array('modp' => $modep, 'mntp' => $mntp, 'id_bq_recep' => $id_bq_recep, 'id_bq_emet' =>$id_bq_emet, 'datevers_banque' => formatinv_date($datevers_bq), 'datevers' => formatinv_date($datevers), 'num_fadh' => $numversement, 'matricule' => $matricule, 'id_res' => $idres, 'valide' => 1, 'datevalide' => $datejr, 'idenr' => $idenr, 'bordereau' => $photor, 'num_paie' => $num_bq, 'compensateur' => $compensateur, 'dateenr' => $datejr);
                                            $stmt_ad = insert_tab($nomtab_ad, $tab_ad);
                                            $reqs = $bdd->prepare($stmt_ad);
                                            $reqs->execute($tab_ad);

                                            $rsvers12 = $bdd->prepare('UPDATE table_reservationlot  SET validefrais =:vf, datevalidation =:dv, datepaiement=:dtp, modep=:modep  WHERE  idres =:idres');
                                            $tabvers12 = array('vf' => 1,'dv' => $datejr, 'dtp' =>formatinv_date($datevers) , 'modep' =>$modep, 'idres' => $idres);
                                            $rsvers12->execute($tabvers12);
                                        } catch (Exception $e) {
                                            echo 'Erreur : ' . $e->getMessage() . '<br />';
                                            echo 'N° : ' . $e->getCode();
                                        }
                                        move_uploaded_file($tmp_ph, 'img/bordereau/'.$photor);

                                        header("location:?page=listeversementclientcais&codevers=" . $codevers);

                                        // FIN INSERTION DU VERSEMENT DES FRAIS DE DOSSIER

                                    }
                                    // traitements des versements (Acompte ou versement
                                    else {
                                        // INSERTION DU MONTANT GLOBALE DU VERSEMENT AVANT LE TRAITEMENT
                                        $nomtab11 = "table_recapversement";
                                        $tab11 = array("idres" =>$idres, "num_recu" => $numvers,"mntp"=>$mntp,"modep"=>$modep, "num_paie"=>$num_bq, "id_bq_emet"=>$id_bq_emet, "dateverse_bq"=>formatinv_date($datevers_bq), "datevers"=>formatinv_date($datevers),"idenr"=> $idenr,"matricule"=> $matricule, "dateenr"=> $datejr, 'bordereau' => $photor, 'id_bq_recep' => $id_bq_recep, 'compensateur' => $compensateur, 'typever' => 'Réduction de solde') ;
                                        //   var_dump($tab);
                                        $st11 = insert_tab($nomtab11, $tab11);
                                        $sql11 = $bdd->prepare($st11);
                                        $sql11->execute($tab11);

                                        $reqmx = $bdd->prepare('select max(id_rverse) as id_rverse from table_recapversement where idres=:idr and supp=0');
                                        $reqmx->execute(array('idr' => $idres));
                                        $rowmx = $reqmx->fetch();
                                        $idrvers = $rowmx['id_rverse'];

                                        // INSERTION DANS LA TABLE VERSEMENT QUAND L'ACOMPTE EST SOLDE
                                        if ($mntac==$mntbtac) {
                                            if ($mntp > $resteapaye) {
                                                $mntropp1 = $mntp - $resteapaye;
                                                // INSERTION DU TROP PERCU
                                                $nomtab = "table_trop_percu";
                                                $tab = array("idres"=>$idres,"mnt"=>$mntropp1, "datevers"=>formatinv_date($datevers),"idenr"=> $idenr,"matricule"=> $matricule, 'dateenr' => $datejr, 'id_recapvers' => $idrvers, "id_bq_emet"=>$id_bq_emet, 'id_bq_recep' => $id_bq_recep, 'num_paie' => $num_bq, 'compensateur' => $compensateur, 'bordereau' => $photor, 'modepay' => $modep, 'dateverse_bq' => formatinv_date($datevers_bq));
                                                //   var_dump($tab);
                                                $st = insert_tab($nomtab, $tab);
                                                $sql = $bdd->prepare($st);
                                                $sql->execute($tab);

                                                $rtp = $bdd->prepare('UPDATE table_reservationlot  SET solder =1, datesolde =:datesolde WHERE idres =:idres');
                                                $tabtp = array('datesolde' => $datejr, 'idres' => $idres);
                                                $rtp->execute($tabtp);


                                                /// ENVOI DE NOTIF PAR SMS
                                                $t="";
                                                $sms="Client : ".$nomclt." Projet : " .$nomop." Statut : Versement du bien soldé ";
                                                // on envoi sms aux dc,commercial adminvente et resp info
                                                $rssms = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND niveau.libabonne <>'com'  and typenotif =:tn ");
                                                $rssms->execute(array("tn"=>"ACOMPTE"));
                                                while ($rowsms = $rssms->fetch()){
                                                    $key = "225".$rowsms['contact'];
                                                    $m =str_replace(' ','',$key) ;
                                                    $m =str_replace('.','',$m) ;
                                                    $m =str_replace('-','',$m) ;
                                                    $nbcarac = strlen($m);
                                                    if ($nbcarac==13){
                                                        $tabnum[$i1] = $m;
                                                        $i1++;
                                                        try{
                                                            $nomtabsms = "table_smsacompte";
                                                            $tabsms = array('numenvoi' => $m, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                            $stsms = insert_tab($nomtabsms, $tabsms);
                                                            $sqlsms = $bdd->prepare($stsms);
                                                            $sqlsms->execute($tabsms);
                                                        }
                                                        catch(Exception $e){
                                                            die("Erreur ! ".$e->getMessage());
                                                        }
                                                    }

                                                }
                                                // on ajoute le commerciale  la liste des sms
                                                $rssms1 = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND tab_usercompte.matricule =:mat   and typenotif =:tn ");
                                                $rssms1->execute(array("tn"=>"ACOMPTE","mat"=>$matricule));
                                                $rowsms1 = $rssms1->fetch();

                                                $key1 = "225".$rowsms1['contact'];
                                                $m1 =str_replace(' ','',$key1) ;
                                                $m1 =str_replace('.','',$m1) ;
                                                $m1 =str_replace('-','',$m1) ;
                                                $nbcarac1 = strlen($m1);
                                                if ($nbcarac1==13){
//                         $t.= trim($m,"+.-").", ";
//                        $t2 = "'".$m."',";
                                                    $i1++;
                                                    $tabnum[$i1] = $m1;
                                                    $nomtabsms1 = "table_smsacompte";
                                                    $tabsms1 = array('numenvoi' => $m1, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                    $stsms1 = insert_tab($nomtabsms1, $tabsms1);
                                                    $sqlsms1 = $bdd->prepare($stsms1);
                                                    $sqlsms1->execute($tabsms1);
                                                }
                                                //// ajout du client
                                                $key2 = "225".$telclt;
                                                $m2 =str_replace(' ','',$key2) ;
                                                $m2 =str_replace('.','',$m2) ;
                                                $m2 =str_replace('-','',$m2) ;
                                                $nbcarac2 = strlen($m2);
                                                if ($nbcarac2==13){
                                                    $i1++;
                                                    $tabnum[$i1] = $m2;
                                                }
                                                // $numok =  rtrim($t,",");
                                                $param = array(
                                                    'username' => $usersms,
                                                    'password' => $passwordsms,
                                                    'sender' => $sendersms,
                                                    'text' => $sms,
                                                    'type' => 'text',
                                                    //'datetime' => $dt,
                                                );
                                                $recipients = $tabnum;
                                                var_dump($recipients);
                                                $post = 'to=' . implode(';', $recipients);
                                                foreach ($param as $key => $val) {
                                                    $post .= '&' . $key . '=' . rawurlencode($val);
                                                }
                                                $url = "http://3hsms.egici.net/api/api_http.php";
                                                $ch = curl_init();
                                                curl_setopt($ch, CURLOPT_URL, $url);
                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
                                                $result = curl_exec($ch);
                                                if(curl_errno($ch)) {
                                                    $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
                                                } else {
                                                    $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                                    switch($returnCode) {
                                                        case 200 :
                                                            break;
                                                        default :
                                                            $result = "HTTP ERROR: " . $returnCode;
                                                    }
                                                }
                                                curl_close($ch);
                                                print $result;


                                                move_uploaded_file($tmp_ph, 'img/bordereau/'.$photor);

                                            }
                                            else {
                                                if ($mntp>=$resteapaye) {
                                                    $mnttp = $mntp - $resteapaye;
                                                    $nomtab = "table_trop_percu";
                                                    $tab = array("idres"=>$idres,"mnt"=>$mnttp, "datevers"=>formatinv_date($datevers),"idenr"=> $idenr,"matricule"=> $matricule, 'dateenr' => $datejr, 'id_recapvers' => $idrvers, "id_bq_emet"=>$id_bq_emet, 'id_bq_recep' => $id_bq_recep, 'num_paie' => $num_bq, 'compensateur' => $compensateur, 'bordereau' => $photor, 'modepay' => $modep, 'dateverse_bq' => formatinv_date($datevers_bq));
                                                    //   var_dump($tab);
                                                    $st = insert_tab($nomtab, $tab);
                                                    $sql = $bdd->prepare($st);
                                                    $sql->execute($tab);

                                                    $rsvers212 = $bdd->prepare('UPDATE table_reservationlot  SET solder =:solder, datesolde =:datesolde  WHERE  idres =:idres');
                                                    $tabvers212 = array('solder' => 1,'datesolde' => gmdate("Y-m-d H:i:s"),'idres' => $idres);
                                                    //var_dump($tabvers12);
                                                    $rsvers212->execute($tabvers212);

                                                    /// ENVOI DE NOTIF PAR SMS
                                                    $t="";
                                                    $sms="Client : ".$nomclt." Projet : " .$nomop." Statut : Versement du bien soldé ";
                                                    // on envoi sms aux dc,commercial adminvente et resp info
                                                    $rssms = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND niveau.libabonne <>'com'  and typenotif =:tn ");
                                                    $rssms->execute(array("tn"=>"ACOMPTE"));
                                                    while ($rowsms = $rssms->fetch()){
                                                        $key = "225".$rowsms['contact'];
                                                        $m =str_replace(' ','',$key) ;
                                                        $m =str_replace('.','',$m) ;
                                                        $m =str_replace('-','',$m) ;
                                                        $nbcarac = strlen($m);
                                                        if ($nbcarac==13){
                                                            $tabnum[$i1] = $m;
                                                            $i1++;
                                                            try{
                                                                $nomtabsms = "table_smsacompte";
                                                                $tabsms = array('numenvoi' => $m, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                                $stsms = insert_tab($nomtabsms, $tabsms);
                                                                $sqlsms = $bdd->prepare($stsms);
                                                                $sqlsms->execute($tabsms);
                                                            }
                                                            catch(Exception $e){
                                                                die("Erreur ! ".$e->getMessage());
                                                            }
                                                        }

                                                    }
                                                    // on ajoute le commerciale  la liste des sms
                                                    $rssms1 = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND tab_usercompte.matricule =:mat   and typenotif =:tn ");
                                                    $rssms1->execute(array("tn"=>"ACOMPTE","mat"=>$matricule));
                                                    $rowsms1 = $rssms1->fetch();

                                                    $key1 = "225".$rowsms1['contact'];
                                                    $m1 =str_replace(' ','',$key1) ;
                                                    $m1 =str_replace('.','',$m1) ;
                                                    $m1 =str_replace('-','',$m1) ;
                                                    $nbcarac1 = strlen($m1);
                                                    if ($nbcarac1==13){
//                         $t.= trim($m,"+.-").", ";
//                        $t2 = "'".$m."',";
                                                        $i1++;
                                                        $tabnum[$i1] = $m1;
                                                        $nomtabsms1 = "table_smsacompte";
                                                        $tabsms1 = array('numenvoi' => $m1, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                        $stsms1 = insert_tab($nomtabsms1, $tabsms1);
                                                        $sqlsms1 = $bdd->prepare($stsms1);
                                                        $sqlsms1->execute($tabsms1);
                                                    }
                                                    //// ajout du client
                                                    $key2 = "225".$telclt;
                                                    $m2 =str_replace(' ','',$key2) ;
                                                    $m2 =str_replace('.','',$m2) ;
                                                    $m2 =str_replace('-','',$m2) ;
                                                    $nbcarac2 = strlen($m2);
                                                    if ($nbcarac2==13){
                                                        $i1++;
                                                        $tabnum[$i1] = $m2;
                                                    }
                                                    // $numok =  rtrim($t,",");
                                                    $param = array(
                                                        'username' => $usersms,
                                                        'password' => $passwordsms,
                                                        'sender' => $sendersms,
                                                        'text' => $sms,
                                                        'type' => 'text',
                                                        //'datetime' => $dt,
                                                    );
                                                    $recipients = $tabnum;
                                                    var_dump($recipients);
                                                    $post = 'to=' . implode(';', $recipients);
                                                    foreach ($param as $key => $val) {
                                                        $post .= '&' . $key . '=' . rawurlencode($val);
                                                    }
                                                    $url = "http://3hsms.egici.net/api/api_http.php";
                                                    $ch = curl_init();
                                                    curl_setopt($ch, CURLOPT_URL, $url);
                                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                                    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
                                                    $result = curl_exec($ch);
                                                    if(curl_errno($ch)) {
                                                        $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
                                                    } else {
                                                        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                                        switch($returnCode) {
                                                            case 200 :
                                                                break;
                                                            default :
                                                                $result = "HTTP ERROR: " . $returnCode;
                                                        }
                                                    }
                                                    curl_close($ch);
                                                    print $result;

                                                }
                                                move_uploaded_file($tmp_ph, 'img/bordereau/'.$photor);
                                            }
                                            header("location:?page=listeversementclientcais&codevers=". $codevers);
                                        }
                                        else {
                                            // INSERTION DANS LA TABLE ACOMPTE POUR LE SOLDE ATTEINT
                                            if ($mntp>=$mntrestac) {
                                                $mntpplus = $mntp - $mntrestac;

                                                // Mise à jour du plan de masse et du plan parcelaire
                                                if ($typebien=="terrain"){
                                                    /// son statut passe de l'option a reservé
                                                    $rsqlstatlot = $bdd->prepare('UPDATE '.$tablot.'  SET  p = :p WHERE gid = :id');
                                                    $rsqlstatlot->execute(array('p' => 2,'id' => $gid));
                                                }else{
                                                    /// son statut passe de l'option a reservé
                                                    $rsqlstatlot = $bdd->prepare('UPDATE '.$masse.'  SET  p = :p WHERE gid = :id');
                                                    $rsqlstatlot->execute(array('p' => 2,'id' => $gid));
                                                }

                                                $rsql = $bdd->prepare('UPDATE table_reservationlot  SET statuplot = :stlot, statacompte = :statacq, dateacompte = :da  WHERE idres = :id');
                                                $rsql->execute(array('da' => formatinv_date($datevers), 'statacq' => 1,'stlot' => 2,'id' => $idres));

                                                if ($mntpplus !=0) {
                                                    if ($mntpplus > $montarecouv) {
                                                        $mntropp1 = $mntpplus - $montarecouv;
                                                        // INSERTION DU TROP PERCU
                                                        $nomtab = "table_trop_percu";
                                                        $tab = array("idres"=>$idres,"mnt"=>$mntropp1, "datevers"=>formatinv_date($datevers),"idenr"=> $idenr,"matricule"=> $matricule, 'dateenr' => $datejr, 'id_recapvers' => $idrvers, "id_bq_emet"=>$id_bq_emet, 'id_bq_recep' => $id_bq_recep, 'num_paie' => $num_bq, 'compensateur' => $compensateur, 'bordereau' => $photor, 'modepay' => $modep, 'dateverse_bq' => formatinv_date($datevers_bq));
                                                        //   var_dump($tab);
                                                        $st = insert_tab($nomtab, $tab);
                                                        $sql = $bdd->prepare($st);
                                                        $sql->execute($tab);

                                                        $rtp = $bdd->prepare('UPDATE table_reservationlot  SET solder =1, datesolde =:datesolde WHERE idres =:idres');
                                                        $tabtp = array('datesolde' => $datejr, 'idres' => $idres);
                                                        $rtp->execute($tabtp);


                                                        /// ENVOI DE NOTIF PAR SMS
                                                        $t="";
                                                        $sms="Client : ".$nomclt." Projet : " .$nomop." Statut : Versement du bien soldé ";
                                                        // on envoi sms aux dc,commercial adminvente et resp info
                                                        $rssms = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND niveau.libabonne <>'com'  and typenotif =:tn ");
                                                        $rssms->execute(array("tn"=>"ACOMPTE"));
                                                        while ($rowsms = $rssms->fetch()){
                                                            $key = "225".$rowsms['contact'];
                                                            $m =str_replace(' ','',$key) ;
                                                            $m =str_replace('.','',$m) ;
                                                            $m =str_replace('-','',$m) ;
                                                            $nbcarac = strlen($m);
                                                            if ($nbcarac==13){
                                                                $tabnum[$i1] = $m;
                                                                $i1++;
                                                                try{
                                                                    $nomtabsms = "table_smsacompte";
                                                                    $tabsms = array('numenvoi' => $m, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                                    $stsms = insert_tab($nomtabsms, $tabsms);
                                                                    $sqlsms = $bdd->prepare($stsms);
                                                                    $sqlsms->execute($tabsms);
                                                                }
                                                                catch(Exception $e){
                                                                    die("Erreur ! ".$e->getMessage());
                                                                }
                                                            }

                                                        }
                                                        // on ajoute le commerciale  la liste des sms
                                                        $rssms1 = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND tab_usercompte.matricule =:mat   and typenotif =:tn ");
                                                        $rssms1->execute(array("tn"=>"ACOMPTE","mat"=>$matricule));
                                                        $rowsms1 = $rssms1->fetch();

                                                        $key1 = "225".$rowsms1['contact'];
                                                        $m1 =str_replace(' ','',$key1) ;
                                                        $m1 =str_replace('.','',$m1) ;
                                                        $m1 =str_replace('-','',$m1) ;
                                                        $nbcarac1 = strlen($m1);
                                                        if ($nbcarac1==13){
//                         $t.= trim($m,"+.-").", ";
//                        $t2 = "'".$m."',";
                                                            $i1++;
                                                            $tabnum[$i1] = $m1;
                                                            $nomtabsms1 = "table_smsacompte";
                                                            $tabsms1 = array('numenvoi' => $m1, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                            $stsms1 = insert_tab($nomtabsms1, $tabsms1);
                                                            $sqlsms1 = $bdd->prepare($stsms1);
                                                            $sqlsms1->execute($tabsms1);
                                                        }
                                                        //// ajout du client
                                                        $key2 = "225".$telclt;
                                                        $m2 =str_replace(' ','',$key2) ;
                                                        $m2 =str_replace('.','',$m2) ;
                                                        $m2 =str_replace('-','',$m2) ;
                                                        $nbcarac2 = strlen($m2);
                                                        if ($nbcarac2==13){
                                                            $i1++;
                                                            $tabnum[$i1] = $m2;
                                                        }
                                                        // $numok =  rtrim($t,",");
                                                        $param = array(
                                                            'username' => $usersms,
                                                            'password' => $passwordsms,
                                                            'sender' => $sendersms,
                                                            'text' => $sms,
                                                            'type' => 'text',
                                                            //'datetime' => $dt,
                                                        );
                                                        $recipients = $tabnum;
                                                        var_dump($recipients);
                                                        $post = 'to=' . implode(';', $recipients);
                                                        foreach ($param as $key => $val) {
                                                            $post .= '&' . $key . '=' . rawurlencode($val);
                                                        }
                                                        $url = "http://3hsms.egici.net/api/api_http.php";
                                                        $ch = curl_init();
                                                        curl_setopt($ch, CURLOPT_URL, $url);
                                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                                                        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                                        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
                                                        $result = curl_exec($ch);
                                                        if(curl_errno($ch)) {
                                                            $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
                                                        } else {
                                                            $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                                            switch($returnCode) {
                                                                case 200 :
                                                                    break;
                                                                default :
                                                                    $result = "HTTP ERROR: " . $returnCode;
                                                            }
                                                        }
                                                        curl_close($ch);
                                                        print $result;


                                                        move_uploaded_file($tmp_ph, 'img/bordereau/'.$photor);

                                                    }
                                                    else {
                                                        if ($mntpplus>=$resteapaye) {
                                                            $mnttp = $mntpplus - $resteapaye;
                                                            $nomtab = "table_trop_percu";
                                                            $tab = array("idres"=>$idres,"mnt"=>$mnttp, "datevers"=>formatinv_date($datevers),"idenr"=> $idenr,"matricule"=> $matricule, 'dateenr' => $datejr, 'id_recapvers' => $idrvers, "id_bq_emet"=>$id_bq_emet, 'id_bq_recep' => $id_bq_recep, 'num_paie' => $num_bq, 'compensateur' => $compensateur, 'bordereau' => $photor, 'modepay' => $modep, 'dateverse_bq' => formatinv_date($datevers_bq));
                                                            //   var_dump($tab);
                                                            $st = insert_tab($nomtab, $tab);
                                                            $sql = $bdd->prepare($st);
                                                            $sql->execute($tab);


                                                            $rsvers212 = $bdd->prepare('UPDATE table_reservationlot  SET solder =:solder, datesolde =:datesolde  WHERE  idres =:idres');
                                                            $tabvers212 = array('solder' => 1,'datesolde' => gmdate("Y-m-d H:i:s"),'idres' => $idres);
                                                            //var_dump($tabvers12);
                                                            $rsvers212->execute($tabvers212);

                                                            /// ENVOI DE NOTIF PAR SMS
                                                            $t="";
                                                            $sms="Client : ".$nomclt." Projet : " .$nomop." Statut : Versement du bien soldé ";
                                                            // on envoi sms aux dc,commercial adminvente et resp info
                                                            $rssms = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND niveau.libabonne <>'com'  and typenotif =:tn ");
                                                            $rssms->execute(array("tn"=>"ACOMPTE"));
                                                            while ($rowsms = $rssms->fetch()){
                                                                $key = "225".$rowsms['contact'];
                                                                $m =str_replace(' ','',$key) ;
                                                                $m =str_replace('.','',$m) ;
                                                                $m =str_replace('-','',$m) ;
                                                                $nbcarac = strlen($m);
                                                                if ($nbcarac==13){
                                                                    $tabnum[$i1] = $m;
                                                                    $i1++;
                                                                    try{
                                                                        $nomtabsms = "table_smsacompte";
                                                                        $tabsms = array('numenvoi' => $m, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                                        $stsms = insert_tab($nomtabsms, $tabsms);
                                                                        $sqlsms = $bdd->prepare($stsms);
                                                                        $sqlsms->execute($tabsms);
                                                                    }
                                                                    catch(Exception $e){
                                                                        die("Erreur ! ".$e->getMessage());
                                                                    }
                                                                }

                                                            }
                                                            // on ajoute le commerciale  la liste des sms
                                                            $rssms1 = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND tab_usercompte.matricule =:mat   and typenotif =:tn ");
                                                            $rssms1->execute(array("tn"=>"ACOMPTE","mat"=>$matricule));
                                                            $rowsms1 = $rssms1->fetch();

                                                            $key1 = "225".$rowsms1['contact'];
                                                            $m1 =str_replace(' ','',$key1) ;
                                                            $m1 =str_replace('.','',$m1) ;
                                                            $m1 =str_replace('-','',$m1) ;
                                                            $nbcarac1 = strlen($m1);
                                                            if ($nbcarac1==13){
//                         $t.= trim($m,"+.-").", ";
//                        $t2 = "'".$m."',";
                                                                $i1++;
                                                                $tabnum[$i1] = $m1;
                                                                $nomtabsms1 = "table_smsacompte";
                                                                $tabsms1 = array('numenvoi' => $m1, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                                $stsms1 = insert_tab($nomtabsms1, $tabsms1);
                                                                $sqlsms1 = $bdd->prepare($stsms1);
                                                                $sqlsms1->execute($tabsms1);
                                                            }
                                                            //// ajout du client
                                                            $key2 = "225".$telclt;
                                                            $m2 =str_replace(' ','',$key2) ;
                                                            $m2 =str_replace('.','',$m2) ;
                                                            $m2 =str_replace('-','',$m2) ;
                                                            $nbcarac2 = strlen($m2);
                                                            if ($nbcarac2==13){
                                                                $i1++;
                                                                $tabnum[$i1] = $m2;
                                                            }
                                                            // $numok =  rtrim($t,",");
                                                            $param = array(
                                                                'username' => $usersms,
                                                                'password' => $passwordsms,
                                                                'sender' => $sendersms,
                                                                'text' => $sms,
                                                                'type' => 'text',
                                                                //'datetime' => $dt,
                                                            );
                                                            $recipients = $tabnum;
                                                            var_dump($recipients);
                                                            $post = 'to=' . implode(';', $recipients);
                                                            foreach ($param as $key => $val) {
                                                                $post .= '&' . $key . '=' . rawurlencode($val);
                                                            }
                                                            $url = "http://3hsms.egici.net/api/api_http.php";
                                                            $ch = curl_init();
                                                            curl_setopt($ch, CURLOPT_URL, $url);
                                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                                                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
                                                            $result = curl_exec($ch);
                                                            if(curl_errno($ch)) {
                                                                $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
                                                            } else {
                                                                $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                                                switch($returnCode) {
                                                                    case 200 :
                                                                        break;
                                                                    default :
                                                                        $result = "HTTP ERROR: " . $returnCode;
                                                                }
                                                            }
                                                            curl_close($ch);
                                                            print $result;

                                                        }

                                                        move_uploaded_file($tmp_ph, 'img/bordereau/'.$photor);
                                                    }
                                                }
                                                move_uploaded_file($tmp_ph, 'img/bordereau/'.$photor);
                                                // Génération de l'échéancier automatique
                                                for ($i=0; $i< $nbmois; $i++){
                                                    $datepp = date('Y-m-d',strtotime('+'.$i.'month',strtotime($datedbech)));

                                                    $nomtab = "table_echeancier";
                                                    $tab = array('idres' => $idres, 'dateecheance' => $datepp,'datevers' => formatinv_date($datevers), 'mntaverse' => $avanceech,'mntverse' => 0, 'idclt' => $clt,  'modeversement' => $modep);
                                                    $st = insert_tab($nomtab, $tab);
                                                    $sql = $bdd->prepare($st);
                                                    $sql->execute($tab);//                                                        if ($avanceech < $mntech ){
//                                                            if ($avanceech>0){
//
//                                                            }else{
//                                                                $nomtab = "table_echeancier";
//                                                                $tab = array('idres' => $idres, 'dateecheance' => $datepp,'datevers' => formatinv_date($datevers), 'mntaverse' => $mntech,'mntverse' => 0, 'idclt' => $clt, 'idacompte' => $_POST['idacompte']);
//                                                                $st = insert_tab($nomtab, $tab);
//                                                                $sql = $bdd->prepare($st);
//                                                                $sql->execute($tab);
//                                                            }
//
//                                                        }
//                                                        else{
//                                                            $nomtab = "table_echeancier";
//                                                            $tab = array('idres' => $idres, 'dateecheance' => $datepp, 'datevers' => formatinv_date($datevers),'mntaverse' => $mntech,  'mntverse' => $mntech, 'idclt' => $clt, 'idacompte' => $_POST['idacompte'],'modeversement' => $modep);
//                                                            $st = insert_tab($nomtab, $tab);
//                                                            $sql = $bdd->prepare($st);
//                                                            $sql->execute($tab);
//                                                        }
                                                }

                                                /// ENVOI DE NOTIF PAR SMS
                                                $t="";
                                                $sms="Client : ".$nomclt." Projet : " .$nomop." Statut : Acompte soldé ";
                                                // on envoi sms aux dc,commercial adminvente et resp info
                                                $rssms = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND niveau.libabonne <>'com'  and typenotif =:tn ");
                                                $rssms->execute(array("tn"=>"ACOMPTE"));
                                                while ($rowsms = $rssms->fetch()){
                                                    $key = "225".$rowsms['contact'];
                                                    $m =str_replace(' ','',$key) ;
                                                    $m =str_replace('.','',$m) ;
                                                    $m =str_replace('-','',$m) ;
                                                    $nbcarac = strlen($m);
                                                    if ($nbcarac==13){
                                                        $tabnum[$i1] = $m;
                                                        $i1++;
                                                        try{
                                                            $nomtabsms = "table_smsacompte";
                                                            $tabsms = array('numenvoi' => $m, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                            $stsms = insert_tab($nomtabsms, $tabsms);
                                                            $sqlsms = $bdd->prepare($stsms);
                                                            $sqlsms->execute($tabsms);
                                                        }
                                                        catch(Exception $e){
                                                            die("Erreur ! ".$e->getMessage());
                                                        }
                                                    }

                                                }
                                                // on ajoute le commerciale  la liste des sms
                                                $rssms1 = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND tab_usercompte.matricule =:mat   and typenotif =:tn ");
                                                $rssms1->execute(array("tn"=>"ACOMPTE","mat"=>$matricule));
                                                $rowsms1 = $rssms1->fetch();

                                                $key1 = "225".$rowsms1['contact'];
                                                $m1 =str_replace(' ','',$key1) ;
                                                $m1 =str_replace('.','',$m1) ;
                                                $m1 =str_replace('-','',$m1) ;
                                                $nbcarac1 = strlen($m1);
                                                if ($nbcarac1==13){
//                         $t.= trim($m,"+.-").", ";
//                        $t2 = "'".$m."',";
                                                    $i1++;
                                                    $tabnum[$i1] = $m1;
                                                    $nomtabsms1 = "table_smsacompte";
                                                    $tabsms1 = array('numenvoi' => $m1, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                    $stsms1 = insert_tab($nomtabsms1, $tabsms1);
                                                    $sqlsms1 = $bdd->prepare($stsms1);
                                                    $sqlsms1->execute($tabsms1);
                                                }
                                                //// ajout du client
                                                $key2 = "225".$telclt;
                                                $m2 =str_replace(' ','',$key2) ;
                                                $m2 =str_replace('.','',$m2) ;
                                                $m2 =str_replace('-','',$m2) ;
                                                $nbcarac2 = strlen($m2);
                                                if ($nbcarac2==13){
                                                    $i1++;
                                                    $tabnum[$i1] = $m2;
                                                }
                                                // $numok =  rtrim($t,",");
                                                $param = array(
                                                    'username' => $usersms,
                                                    'password' => $passwordsms,
                                                    'sender' => $sendersms,
                                                    'text' => $sms,
                                                    'type' => 'text',
                                                    //'datetime' => $dt,
                                                );
                                                $recipients = $tabnum;
                                                var_dump($recipients);
                                                $post = 'to=' . implode(';', $recipients);
                                                foreach ($param as $key => $val) {
                                                    $post .= '&' . $key . '=' . rawurlencode($val);
                                                }
                                                $url = "http://3hsms.egici.net/api/api_http.php";
                                                $ch = curl_init();
                                                curl_setopt($ch, CURLOPT_URL, $url);
                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
                                                $result = curl_exec($ch);
                                                if(curl_errno($ch)) {
                                                    $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
                                                } else {
                                                    $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                                    switch($returnCode) {
                                                        case 200 :
                                                            break;
                                                        default :
                                                            $result = "HTTP ERROR: " . $returnCode;
                                                    }
                                                }
                                                curl_close($ch);
                                                print $result;

                                                header("location:?page=listeversementclientcais&codevers=". $codevers);

                                            }
                                            else {
                                                if ($mntrestac > $mntp) {
                                                    $rsql = $bdd->prepare('UPDATE table_reservationlot  SET  dateacompte = :da  WHERE idres = :id');
                                                    $rsql->execute(array('da' => formatinv_date($datevers),'id' => $idres));
                                                    move_uploaded_file($tmp_ph, 'img/bordereau/'.$photor);

                                                    header("location:?page=listeversementclientcais&codevers=". $codevers);
                                                }

                                            }
                                        }
                                    }
                                }
                                else {
                                    // INSERTION DU VERSEMENT DES FRAIS DE DOSSIER
                                    if ($_POST['typeregle'] == "frais_adhesion") {
                                        try {
                                            $nomtab_ad = "table_frais_adhesion";
                                            $tab_ad = array('modp' => $modep, 'mntp' => $mntp, 'id_bq_recep' => $id_bq_recep, 'id_bq_emet' =>$id_bq_emet, 'datevers_banque' => formatinv_date($datevers_bq), 'datevers' => formatinv_date($datevers), 'num_fadh' => $numversement, 'matricule' => $matricule, 'id_res' => $idres, 'valide' => 1, 'datevalide' => $datejr, 'idenr' => $idenr, 'num_paie' => $num_bq, 'compensateur' => $compensateur, 'dateenr' => $datejr);
                                            $stmt_ad = insert_tab($nomtab_ad, $tab_ad);
                                            $reqs = $bdd->prepare($stmt_ad);
                                            $reqs->execute($tab_ad);

                                            $rsvers12 = $bdd->prepare('UPDATE table_reservationlot  SET validefrais =:vf, datevalidation =:dv, datepaiement=:dtp, modep=:modep  WHERE  idres =:idres');
                                            $tabvers12 = array('vf' => 1,'dv' => $datejr, 'dtp' =>formatinv_date($datevers) , 'modep' =>$modep, 'idres' => $idres);
                                            $rsvers12->execute($tabvers12);
                                        } catch (Exception $e) {
                                            echo 'Erreur : ' . $e->getMessage() . '<br />';
                                            echo 'N° : ' . $e->getCode();
                                        }
                                        header("location:?page=listeversementclientcais&codevers=" . $codevers);

                                        // FIN INSERTION DU VERSEMENT DES FRAIS DE DOSSIER

                                    }
                                    // traitements des versements (Acompte ou versement
                                    else {
                                        // INSERTION DU MONTANT GLOBALE DU VERSEMENT AVANT LE TRAITEMENT
                                        $nomtab11 = "table_recapversement";
                                        $tab11 = array("idres" =>$idres, "num_recu" => $numvers,"mntp"=>$mntp,"modep"=>$modep, "num_paie"=>$num_bq, "id_bq_emet"=>$id_bq_emet, "dateverse_bq"=>formatinv_date($datevers_bq), "datevers"=>formatinv_date($datevers),"idenr"=> $idenr,"matricule"=> $matricule, "dateenr"=> $datejr, 'id_bq_recep' => $id_bq_recep, 'compensateur' => $compensateur, 'typever' => 'Réduction de solde') ;
                                        //   var_dump($tab);
                                        $st11 = insert_tab($nomtab11, $tab11);
                                        $sql11 = $bdd->prepare($st11);
                                        $sql11->execute($tab11);

                                        $reqmx = $bdd->prepare('select max(id_rverse) as id_rverse from table_recapversement where idres=:idr and supp=0');
                                        $reqmx->execute(array('idr' => $idres));
                                        $rowmx = $reqmx->fetch();
                                        $idrvers = $rowmx['id_rverse'];

                                        // INSERTION DANS LA TABLE VERSEMENT QUAND L'ACOMPTE EST SOLDE
                                        if ($mntac==$mntbtac) {
                                            if ($mntp > $resteapaye) {
                                                $mntropp1 = $mntp - $resteapaye;
                                                // INSERTION DU TROP PERCU
                                                $nomtab = "table_trop_percu";
                                                $tab = array("idres"=>$idres,"mnt"=>$mntropp1, "datevers"=>formatinv_date($datevers),"idenr"=> $idenr,"matricule"=> $matricule, 'dateenr' => $datejr, 'id_recapvers' => $idrvers, "id_bq_emet"=>$id_bq_emet, 'id_bq_recep' => $id_bq_recep, 'num_paie' => $num_bq, 'compensateur' => $compensateur, 'modepay' => $modep, 'dateverse_bq' => formatinv_date($datevers_bq));
                                                //   var_dump($tab);
                                                $st = insert_tab($nomtab, $tab);
                                                $sql = $bdd->prepare($st);
                                                $sql->execute($tab);

                                                $rtp = $bdd->prepare('UPDATE table_reservationlot  SET solder =1, datesolde =:datesolde WHERE idres =:idres');
                                                $tabtp = array('datesolde' => $datejr, 'idres' => $idres);
                                                $rtp->execute($tabtp);


                                                /// ENVOI DE NOTIF PAR SMS
                                                $t="";
                                                $sms="Client : ".$nomclt." Projet : " .$nomop." Statut : Versement du bien soldé ";
                                                // on envoi sms aux dc,commercial adminvente et resp info
                                                $rssms = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND niveau.libabonne <>'com'  and typenotif =:tn ");
                                                $rssms->execute(array("tn"=>"ACOMPTE"));
                                                while ($rowsms = $rssms->fetch()){
                                                    $key = "225".$rowsms['contact'];
                                                    $m =str_replace(' ','',$key) ;
                                                    $m =str_replace('.','',$m) ;
                                                    $m =str_replace('-','',$m) ;
                                                    $nbcarac = strlen($m);
                                                    if ($nbcarac==13){
                                                        $tabnum[$i1] = $m;
                                                        $i1++;
                                                        try{
                                                            $nomtabsms = "table_smsacompte";
                                                            $tabsms = array('numenvoi' => $m, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                            $stsms = insert_tab($nomtabsms, $tabsms);
                                                            $sqlsms = $bdd->prepare($stsms);
                                                            $sqlsms->execute($tabsms);
                                                        }
                                                        catch(Exception $e){
                                                            die("Erreur ! ".$e->getMessage());
                                                        }
                                                    }

                                                }
                                                // on ajoute le commerciale  la liste des sms
                                                $rssms1 = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND tab_usercompte.matricule =:mat   and typenotif =:tn ");
                                                $rssms1->execute(array("tn"=>"ACOMPTE","mat"=>$matricule));
                                                $rowsms1 = $rssms1->fetch();

                                                $key1 = "225".$rowsms1['contact'];
                                                $m1 =str_replace(' ','',$key1) ;
                                                $m1 =str_replace('.','',$m1) ;
                                                $m1 =str_replace('-','',$m1) ;
                                                $nbcarac1 = strlen($m1);
                                                if ($nbcarac1==13){
//                         $t.= trim($m,"+.-").", ";
//                        $t2 = "'".$m."',";
                                                    $i1++;
                                                    $tabnum[$i1] = $m1;
                                                    $nomtabsms1 = "table_smsacompte";
                                                    $tabsms1 = array('numenvoi' => $m1, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                    $stsms1 = insert_tab($nomtabsms1, $tabsms1);
                                                    $sqlsms1 = $bdd->prepare($stsms1);
                                                    $sqlsms1->execute($tabsms1);
                                                }
                                                //// ajout du client
                                                $key2 = "225".$telclt;
                                                $m2 =str_replace(' ','',$key2) ;
                                                $m2 =str_replace('.','',$m2) ;
                                                $m2 =str_replace('-','',$m2) ;
                                                $nbcarac2 = strlen($m2);
                                                if ($nbcarac2==13){
                                                    $i1++;
                                                    $tabnum[$i1] = $m2;
                                                }
                                                // $numok =  rtrim($t,",");
                                                $param = array(
                                                    'username' => $usersms,
                                                    'password' => $passwordsms,
                                                    'sender' => $sendersms,
                                                    'text' => $sms,
                                                    'type' => 'text',
                                                    //'datetime' => $dt,
                                                );
                                                $recipients = $tabnum;
                                                var_dump($recipients);
                                                $post = 'to=' . implode(';', $recipients);
                                                foreach ($param as $key => $val) {
                                                    $post .= '&' . $key . '=' . rawurlencode($val);
                                                }
                                                $url = "http://3hsms.egici.net/api/api_http.php";
                                                $ch = curl_init();
                                                curl_setopt($ch, CURLOPT_URL, $url);
                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
                                                $result = curl_exec($ch);
                                                if(curl_errno($ch)) {
                                                    $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
                                                } else {
                                                    $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                                    switch($returnCode) {
                                                        case 200 :
                                                            break;
                                                        default :
                                                            $result = "HTTP ERROR: " . $returnCode;
                                                    }
                                                }
                                                curl_close($ch);
                                                print $result;
                                            }
                                            else {
                                                if ($mntp>=$resteapaye) {
                                                    $mnttp = $mntp - $resteapaye;
                                                    $nomtab = "table_trop_percu";
                                                    $tab = array("idres"=>$idres,"mnt"=>$mnttp, "datevers"=>formatinv_date($datevers),"idenr"=> $idenr,"matricule"=> $matricule, 'dateenr' => $datejr, 'id_recapvers' => $idrvers, "id_bq_emet"=>$id_bq_emet, 'id_bq_recep' => $id_bq_recep, 'num_paie' => $num_bq, 'compensateur' => $compensateur, 'modepay' => $modep, 'dateverse_bq' => formatinv_date($datevers_bq));
                                                    //   var_dump($tab);
                                                    $st = insert_tab($nomtab, $tab);
                                                    $sql = $bdd->prepare($st);
                                                    $sql->execute($tab);


                                                    $rsvers212 = $bdd->prepare('UPDATE table_reservationlot  SET solder =:solder, datesolde =:datesolde  WHERE  idres =:idres');
                                                    $tabvers212 = array('solder' => 1,'datesolde' => gmdate("Y-m-d H:i:s"),'idres' => $idres);
                                                    //var_dump($tabvers12);
                                                    $rsvers212->execute($tabvers212);

                                                    /// ENVOI DE NOTIF PAR SMS
                                                    $t="";
                                                    $sms="Client : ".$nomclt." Projet : " .$nomop." Statut : Versement du bien soldé ";
                                                    // on envoi sms aux dc,commercial adminvente et resp info
                                                    $rssms = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND niveau.libabonne <>'com'  and typenotif =:tn ");
                                                    $rssms->execute(array("tn"=>"ACOMPTE"));
                                                    while ($rowsms = $rssms->fetch()){
                                                        $key = "225".$rowsms['contact'];
                                                        $m =str_replace(' ','',$key) ;
                                                        $m =str_replace('.','',$m) ;
                                                        $m =str_replace('-','',$m) ;
                                                        $nbcarac = strlen($m);
                                                        if ($nbcarac==13){
                                                            $tabnum[$i1] = $m;
                                                            $i1++;
                                                            try{
                                                                $nomtabsms = "table_smsacompte";
                                                                $tabsms = array('numenvoi' => $m, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                                $stsms = insert_tab($nomtabsms, $tabsms);
                                                                $sqlsms = $bdd->prepare($stsms);
                                                                $sqlsms->execute($tabsms);
                                                            }
                                                            catch(Exception $e){
                                                                die("Erreur ! ".$e->getMessage());
                                                            }
                                                        }

                                                    }
                                                    // on ajoute le commerciale  la liste des sms
                                                    $rssms1 = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND tab_usercompte.matricule =:mat   and typenotif =:tn ");
                                                    $rssms1->execute(array("tn"=>"ACOMPTE","mat"=>$matricule));
                                                    $rowsms1 = $rssms1->fetch();

                                                    $key1 = "225".$rowsms1['contact'];
                                                    $m1 =str_replace(' ','',$key1) ;
                                                    $m1 =str_replace('.','',$m1) ;
                                                    $m1 =str_replace('-','',$m1) ;
                                                    $nbcarac1 = strlen($m1);
                                                    if ($nbcarac1==13){
//                         $t.= trim($m,"+.-").", ";
//                        $t2 = "'".$m."',";
                                                        $i1++;
                                                        $tabnum[$i1] = $m1;
                                                        $nomtabsms1 = "table_smsacompte";
                                                        $tabsms1 = array('numenvoi' => $m1, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                        $stsms1 = insert_tab($nomtabsms1, $tabsms1);
                                                        $sqlsms1 = $bdd->prepare($stsms1);
                                                        $sqlsms1->execute($tabsms1);
                                                    }
                                                    //// ajout du client
                                                    $key2 = "225".$telclt;
                                                    $m2 =str_replace(' ','',$key2) ;
                                                    $m2 =str_replace('.','',$m2) ;
                                                    $m2 =str_replace('-','',$m2) ;
                                                    $nbcarac2 = strlen($m2);
                                                    if ($nbcarac2==13){
                                                        $i1++;
                                                        $tabnum[$i1] = $m2;
                                                    }
                                                    // $numok =  rtrim($t,",");
                                                    $param = array(
                                                        'username' => $usersms,
                                                        'password' => $passwordsms,
                                                        'sender' => $sendersms,
                                                        'text' => $sms,
                                                        'type' => 'text',
                                                        //'datetime' => $dt,
                                                    );
                                                    $recipients = $tabnum;
                                                    var_dump($recipients);
                                                    $post = 'to=' . implode(';', $recipients);
                                                    foreach ($param as $key => $val) {
                                                        $post .= '&' . $key . '=' . rawurlencode($val);
                                                    }
                                                    $url = "http://3hsms.egici.net/api/api_http.php";
                                                    $ch = curl_init();
                                                    curl_setopt($ch, CURLOPT_URL, $url);
                                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                                    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
                                                    $result = curl_exec($ch);
                                                    if(curl_errno($ch)) {
                                                        $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
                                                    } else {
                                                        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                                        switch($returnCode) {
                                                            case 200 :
                                                                break;
                                                            default :
                                                                $result = "HTTP ERROR: " . $returnCode;
                                                        }
                                                    }
                                                    curl_close($ch);
                                                    print $result;

                                                }
                                            }
                                            header("location:?page=listeversementclientcais&codevers=". $codevers);
                                        }
                                        else {
                                            // INSERTION DANS LA TABLE ACOMPTE POUR LE SOLDE ATTEINT
                                            if ($mntp>=$mntrestac) {
                                                $mntpplus = $mntp - $mntrestac;

                                                // Mise à jour du plan de masse et du plan parcelaire
                                                if ($typebien=="terrain"){
                                                    /// son statut passe de l'option a reservé
                                                    $rsqlstatlot = $bdd->prepare('UPDATE '.$tablot.'  SET  p = :p WHERE gid = :id');
                                                    $rsqlstatlot->execute(array('p' => 2,'id' => $gid));
                                                }else{
                                                    /// son statut passe de l'option a reservé
                                                    $rsqlstatlot = $bdd->prepare('UPDATE '.$masse.'  SET  p = :p WHERE gid = :id');
                                                    $rsqlstatlot->execute(array('p' => 2,'id' => $gid));
                                                }

                                                $rsql = $bdd->prepare('UPDATE table_reservationlot  SET statuplot = :stlot, statacompte = :statacq, dateacompte = :da  WHERE idres = :id');
                                                $rsql->execute(array('da' => formatinv_date($datevers), 'statacq' => 1,'stlot' => 2,'id' => $idres));

                                                if ($mntpplus !=0) {
                                                    if ($mntpplus > $montarecouv) {
                                                        $mntropp1 = $mntpplus - $montarecouv;
                                                        // INSERTION DU TROP PERCU
                                                        $nomtab = "table_trop_percu";
                                                        $tab = array("idres"=>$idres,"mnt"=>$mntropp1, "datevers"=>formatinv_date($datevers),"idenr"=> $idenr,"matricule"=> $matricule, 'dateenr' => $datejr, 'id_recapvers' => $idrvers, "id_bq_emet"=>$id_bq_emet, 'id_bq_recep' => $id_bq_recep, 'num_paie' => $num_bq, 'compensateur' => $compensateur, 'modepay' => $modep, 'dateverse_bq' => formatinv_date($datevers_bq));
                                                        //   var_dump($tab);
                                                        $st = insert_tab($nomtab, $tab);
                                                        $sql = $bdd->prepare($st);
                                                        $sql->execute($tab);


                                                        $rtp = $bdd->prepare('UPDATE table_reservationlot  SET solder =1, datesolde =:datesolde WHERE idres =:idres');
                                                        $tabtp = array('datesolde' => $datejr, 'idres' => $idres);
                                                        $rtp->execute($tabtp);


                                                        /// ENVOI DE NOTIF PAR SMS
                                                        $t="";
                                                        $sms="Client : ".$nomclt." Projet : " .$nomop." Statut : Versement du bien soldé avec un trop perçu de " . $mntropp1;
                                                        // on envoi sms aux dc,commercial adminvente et resp info
                                                        $rssms = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND niveau.libabonne <>'com'  and typenotif =:tn ");
                                                        $rssms->execute(array("tn"=>"ACOMPTE"));
                                                        while ($rowsms = $rssms->fetch()){
                                                            $key = "225".$rowsms['contact'];
                                                            $m =str_replace(' ','',$key) ;
                                                            $m =str_replace('.','',$m) ;
                                                            $m =str_replace('-','',$m) ;
                                                            $nbcarac = strlen($m);
                                                            if ($nbcarac==13){
                                                                $tabnum[$i1] = $m;
                                                                $i1++;
                                                                try{
                                                                    $nomtabsms = "table_smsacompte";
                                                                    $tabsms = array('numenvoi' => $m, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                                    $stsms = insert_tab($nomtabsms, $tabsms);
                                                                    $sqlsms = $bdd->prepare($stsms);
                                                                    $sqlsms->execute($tabsms);
                                                                }
                                                                catch(Exception $e){
                                                                    die("Erreur ! ".$e->getMessage());
                                                                }
                                                            }

                                                        }
                                                        // on ajoute le commerciale  la liste des sms
                                                        $rssms1 = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND tab_usercompte.matricule =:mat   and typenotif =:tn ");
                                                        $rssms1->execute(array("tn"=>"ACOMPTE","mat"=>$matricule));
                                                        $rowsms1 = $rssms1->fetch();

                                                        $key1 = "225".$rowsms1['contact'];
                                                        $m1 =str_replace(' ','',$key1) ;
                                                        $m1 =str_replace('.','',$m1) ;
                                                        $m1 =str_replace('-','',$m1) ;
                                                        $nbcarac1 = strlen($m1);
                                                        if ($nbcarac1==13){
//                         $t.= trim($m,"+.-").", ";
//                        $t2 = "'".$m."',";
                                                            $i1++;
                                                            $tabnum[$i1] = $m1;
                                                            $nomtabsms1 = "table_smsacompte";
                                                            $tabsms1 = array('numenvoi' => $m1, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                            $stsms1 = insert_tab($nomtabsms1, $tabsms1);
                                                            $sqlsms1 = $bdd->prepare($stsms1);
                                                            $sqlsms1->execute($tabsms1);
                                                        }
                                                        //// ajout du client
                                                        $key2 = "225".$telclt;
                                                        $m2 =str_replace(' ','',$key2) ;
                                                        $m2 =str_replace('.','',$m2) ;
                                                        $m2 =str_replace('-','',$m2) ;
                                                        $nbcarac2 = strlen($m2);
                                                        if ($nbcarac2==13){
                                                            $i1++;
                                                            $tabnum[$i1] = $m2;
                                                        }
                                                        // $numok =  rtrim($t,",");
                                                        $param = array(
                                                            'username' => $usersms,
                                                            'password' => $passwordsms,
                                                            'sender' => $sendersms,
                                                            'text' => $sms,
                                                            'type' => 'text',
                                                            //'datetime' => $dt,
                                                        );
                                                        $recipients = $tabnum;
                                                        var_dump($recipients);
                                                        $post = 'to=' . implode(';', $recipients);
                                                        foreach ($param as $key => $val) {
                                                            $post .= '&' . $key . '=' . rawurlencode($val);
                                                        }
                                                        $url = "http://3hsms.egici.net/api/api_http.php";
                                                        $ch = curl_init();
                                                        curl_setopt($ch, CURLOPT_URL, $url);
                                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                                                        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                                        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
                                                        $result = curl_exec($ch);
                                                        if(curl_errno($ch)) {
                                                            $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
                                                        } else {
                                                            $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                                            switch($returnCode) {
                                                                case 200 :
                                                                    break;
                                                                default :
                                                                    $result = "HTTP ERROR: " . $returnCode;
                                                            }
                                                        }
                                                        curl_close($ch);
                                                        print $result;

                                                    }
                                                    else {
                                                        if ($mntpplus>=$resteapaye) {
                                                            $mnttp = $mntpplus - $resteapaye;
                                                            $nomtab = "table_trop_percu";
                                                            $tab = array("idres"=>$idres,"mnt"=>$mnttp, "datevers"=>formatinv_date($datevers),"idenr"=> $idenr,"matricule"=> $matricule, 'dateenr' => $datejr, 'id_recapvers' => $idrvers, "id_bq_emet"=>$id_bq_emet, 'id_bq_recep' => $id_bq_recep, 'num_paie' => $num_bq, 'compensateur' => $compensateur, 'modepay' => $modep, 'dateverse_bq' => formatinv_date($datevers_bq));
                                                            //   var_dump($tab);
                                                            $st = insert_tab($nomtab, $tab);
                                                            $sql = $bdd->prepare($st);
                                                            $sql->execute($tab);


                                                            $rsvers212 = $bdd->prepare('UPDATE table_reservationlot  SET solder =:solder, datesolde =:datesolde  WHERE  idres =:idres');
                                                            $tabvers212 = array('solder' => 1,'datesolde' => gmdate("Y-m-d H:i:s"),'idres' => $idres);
                                                            //var_dump($tabvers12);
                                                            $rsvers212->execute($tabvers212);

                                                            /// ENVOI DE NOTIF PAR SMS
                                                            $t="";
                                                            $sms="Client : ".$nomclt." Projet : " .$nomop." Statut : Versement du bien soldé.";
                                                            // on envoi sms aux dc,commercial adminvente et resp info
                                                            $rssms = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND niveau.libabonne <>'com'  and typenotif =:tn ");
                                                            $rssms->execute(array("tn"=>"ACOMPTE"));
                                                            while ($rowsms = $rssms->fetch()){
                                                                $key = "225".$rowsms['contact'];
                                                                $m =str_replace(' ','',$key) ;
                                                                $m =str_replace('.','',$m) ;
                                                                $m =str_replace('-','',$m) ;
                                                                $nbcarac = strlen($m);
                                                                if ($nbcarac==13){
                                                                    $tabnum[$i1] = $m;
                                                                    $i1++;
                                                                    try{
                                                                        $nomtabsms = "table_smsacompte";
                                                                        $tabsms = array('numenvoi' => $m, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                                        $stsms = insert_tab($nomtabsms, $tabsms);
                                                                        $sqlsms = $bdd->prepare($stsms);
                                                                        $sqlsms->execute($tabsms);
                                                                    }
                                                                    catch(Exception $e){
                                                                        die("Erreur ! ".$e->getMessage());
                                                                    }
                                                                }

                                                            }
                                                            // on ajoute le commerciale  la liste des sms
                                                            $rssms1 = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND tab_usercompte.matricule =:mat   and typenotif =:tn ");
                                                            $rssms1->execute(array("tn"=>"ACOMPTE","mat"=>$matricule));
                                                            $rowsms1 = $rssms1->fetch();

                                                            $key1 = "225".$rowsms1['contact'];
                                                            $m1 =str_replace(' ','',$key1) ;
                                                            $m1 =str_replace('.','',$m1) ;
                                                            $m1 =str_replace('-','',$m1) ;
                                                            $nbcarac1 = strlen($m1);
                                                            if ($nbcarac1==13){
//                         $t.= trim($m,"+.-").", ";
//                        $t2 = "'".$m."',";
                                                                $i1++;
                                                                $tabnum[$i1] = $m1;
                                                                $nomtabsms1 = "table_smsacompte";
                                                                $tabsms1 = array('numenvoi' => $m1, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                                $stsms1 = insert_tab($nomtabsms1, $tabsms1);
                                                                $sqlsms1 = $bdd->prepare($stsms1);
                                                                $sqlsms1->execute($tabsms1);
                                                            }
                                                            //// ajout du client
                                                            $key2 = "225".$telclt;
                                                            $m2 =str_replace(' ','',$key2) ;
                                                            $m2 =str_replace('.','',$m2) ;
                                                            $m2 =str_replace('-','',$m2) ;
                                                            $nbcarac2 = strlen($m2);
                                                            if ($nbcarac2==13){
                                                                $i1++;
                                                                $tabnum[$i1] = $m2;
                                                            }
                                                            // $numok =  rtrim($t,",");
                                                            $param = array(
                                                                'username' => $usersms,
                                                                'password' => $passwordsms,
                                                                'sender' => $sendersms,
                                                                'text' => $sms,
                                                                'type' => 'text',
                                                                //'datetime' => $dt,
                                                            );
                                                            $recipients = $tabnum;
                                                            var_dump($recipients);
                                                            $post = 'to=' . implode(';', $recipients);
                                                            foreach ($param as $key => $val) {
                                                                $post .= '&' . $key . '=' . rawurlencode($val);
                                                            }
                                                            $url = "http://3hsms.egici.net/api/api_http.php";
                                                            $ch = curl_init();
                                                            curl_setopt($ch, CURLOPT_URL, $url);
                                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                                                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
                                                            $result = curl_exec($ch);
                                                            if(curl_errno($ch)) {
                                                                $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
                                                            } else {
                                                                $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                                                switch($returnCode) {
                                                                    case 200 :
                                                                        break;
                                                                    default :
                                                                        $result = "HTTP ERROR: " . $returnCode;
                                                                }
                                                            }
                                                            curl_close($ch);
                                                            print $result;

                                                        }
                                                    }
                                                }
                                                // Génération de l'échéancier automatique
                                                for ($i=0; $i< $nbmois; $i++){
                                                    $datepp = date('Y-m-d',strtotime('+'.$i.'month',strtotime($datedbech)));

                                                    //                                                    if ($avanceech < $mntech ){
//                                                        if ($avanceech>0){
//                                                            $nomtab = "table_echeancier";
//                                                            $tab = array('idres' => $idres, 'dateecheance' => $datepp,'datevers' => formatinv_date($datevers), 'mntaverse' => $mntech,'mntverse' => 0, 'idclt' => $clt, 'idacompte' => $_POST['idacompte'], 'modeversement' => $modep);
//                                                            $st = insert_tab($nomtab, $tab);
//                                                            $sql = $bdd->prepare($st);
//                                                            $sql->execute($tab);
//                                                        }else{
//                                                            $nomtab = "table_echeancier";
//                                                            $tab = array('idres' => $idres, 'dateecheance' => $datepp,'datevers' => formatinv_date($datevers), 'mntaverse' => $mntech,'mntverse' => 0, 'idclt' => $clt, 'idacompte' => $_POST['idacompte']);
//                                                            $st = insert_tab($nomtab, $tab);
//                                                            $sql = $bdd->prepare($st);
//                                                            $sql->execute($tab);
//                                                        }
//
//                                                    }
//                                                    else{
//                                                        $nomtab = "table_echeancier";
//                                                        $tab = array('idres' => $idres, 'dateecheance' => $datepp, 'datevers' => formatinv_date($datevers),'mntaverse' => $mntech,  'mntverse' => $mntech, 'idclt' => $clt, 'idacompte' => $_POST['idacompte'],'modeversement' => $modep);
//                                                        $st = insert_tab($nomtab, $tab);
//                                                        $sql = $bdd->prepare($st);
//                                                        $sql->execute($tab);
//                                                    }
//                                                    $avanceech = $avanceech - $mntech;
                                                    $nomtab = "table_echeancier";
                                                    $tab = array('idres' => $idres, 'dateecheance' => $datepp,'datevers' => formatinv_date($datevers), 'mntaverse' => $avanceech,'mntverse' => 0, 'idclt' => $clt,  'modeversement' => $modep);
                                                    $st = insert_tab($nomtab, $tab);
                                                    $sql = $bdd->prepare($st);
                                                    $sql->execute($tab);
                                                    //                                                        if ($avanceech < $mntech ){
//                                                            if ($avanceech>0){
//
//                                                            }else{
//                                                                $nomtab = "table_echeancier";
//                                                                $tab = array('idres' => $idres, 'dateecheance' => $datepp,'datevers' => formatinv_date($datevers), 'mntaverse' => $mntech,'mntverse' => 0, 'idclt' => $clt, 'idacompte' => $_POST['idacompte']);
//                                                                $st = insert_tab($nomtab, $tab);
//                                                                $sql = $bdd->prepare($st);
//                                                                $sql->execute($tab);
//                                                            }
//
//                                                        }
//                                                        else{
//                                                            $nomtab = "table_echeancier";
//                                                            $tab = array('idres' => $idres, 'dateecheance' => $datepp, 'datevers' => formatinv_date($datevers),'mntaverse' => $mntech,  'mntverse' => $mntech, 'idclt' => $clt, 'idacompte' => $_POST['idacompte'],'modeversement' => $modep);
//                                                            $st = insert_tab($nomtab, $tab);
//                                                            $sql = $bdd->prepare($st);
//                                                            $sql->execute($tab);
//                                                        }
                                                }


                                                /// ENVOI DE NOTIF PAR SMS
                                                $t="";
                                                $sms="Client : ".$nomclt." Projet : " .$nomop." Statut : Acompte soldé ";
                                                // on envoi sms aux dc,commercial adminvente et resp info
                                                $rssms = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND niveau.libabonne <>'com'  and typenotif =:tn ");
                                                $rssms->execute(array("tn"=>"ACOMPTE"));
                                                while ($rowsms = $rssms->fetch()){
                                                    $key = "225".$rowsms['contact'];
                                                    $m =str_replace(' ','',$key) ;
                                                    $m =str_replace('.','',$m) ;
                                                    $m =str_replace('-','',$m) ;
                                                    $nbcarac = strlen($m);
                                                    if ($nbcarac==13){
                                                        $tabnum[$i1] = $m;
                                                        $i1++;
                                                        try{
                                                            $nomtabsms = "table_smsacompte";
                                                            $tabsms = array('numenvoi' => $m, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                            $stsms = insert_tab($nomtabsms, $tabsms);
                                                            $sqlsms = $bdd->prepare($stsms);
                                                            $sqlsms->execute($tabsms);
                                                        }
                                                        catch(Exception $e){
                                                            die("Erreur ! ".$e->getMessage());
                                                        }
                                                    }

                                                }
                                                // on ajoute le commerciale  la liste des sms
                                                $rssms1 = $bdd->prepare("select * from tab_usercompte,table_notification,niveau WHERE tab_usercompte.passlevel=niveau.idtypeb AND tab_usercompte.iduser=table_notification.idadmin AND pourcom>0 and user_status >0 AND tab_usercompte.matricule =:mat   and typenotif =:tn ");
                                                $rssms1->execute(array("tn"=>"ACOMPTE","mat"=>$matricule));
                                                $rowsms1 = $rssms1->fetch();

                                                $key1 = "225".$rowsms1['contact'];
                                                $m1 =str_replace(' ','',$key1) ;
                                                $m1 =str_replace('.','',$m1) ;
                                                $m1 =str_replace('-','',$m1) ;
                                                $nbcarac1 = strlen($m1);
                                                if ($nbcarac1==13){
//                         $t.= trim($m,"+.-").", ";
//                        $t2 = "'".$m."',";
                                                    $i1++;
                                                    $tabnum[$i1] = $m1;
                                                    $nomtabsms1 = "table_smsacompte";
                                                    $tabsms1 = array('numenvoi' => $m1, 'dateenvoi' => gmdate("Y-m-d H:i:s"), 'msg' => $sms);
                                                    $stsms1 = insert_tab($nomtabsms1, $tabsms1);
                                                    $sqlsms1 = $bdd->prepare($stsms1);
                                                    $sqlsms1->execute($tabsms1);
                                                }
                                                //// ajout du client
                                                $key2 = "225".$telclt;
                                                $m2 =str_replace(' ','',$key2) ;
                                                $m2 =str_replace('.','',$m2) ;
                                                $m2 =str_replace('-','',$m2) ;
                                                $nbcarac2 = strlen($m2);
                                                if ($nbcarac2==13){
                                                    $i1++;
                                                    $tabnum[$i1] = $m2;
                                                }
                                                // $numok =  rtrim($t,",");
                                                $param = array(
                                                    'username' => $usersms,
                                                    'password' => $passwordsms,
                                                    'sender' => $sendersms,
                                                    'text' => $sms,
                                                    'type' => 'text',
                                                    //'datetime' => $dt,
                                                );
                                                $recipients = $tabnum;
                                                var_dump($recipients);
                                                $post = 'to=' . implode(';', $recipients);
                                                foreach ($param as $key => $val) {
                                                    $post .= '&' . $key . '=' . rawurlencode($val);
                                                }
                                                $url = "http://3hsms.egici.net/api/api_http.php";
                                                $ch = curl_init();
                                                curl_setopt($ch, CURLOPT_URL, $url);
                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
                                                $result = curl_exec($ch);
                                                if(curl_errno($ch)) {
                                                    $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
                                                } else {
                                                    $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                                    switch($returnCode) {
                                                        case 200 :
                                                            break;
                                                        default :
                                                            $result = "HTTP ERROR: " . $returnCode;
                                                    }
                                                }
                                                curl_close($ch);
                                                print $result;

                                                header("location:?page=listeversementclientcais&codevers=". $codevers);

                                            }
                                            else {
                                                if ($mntrestac > $mntp) {
                                                    $rsql = $bdd->prepare('UPDATE table_reservationlot  SET  dateacompte = :da  WHERE idres = :id');
                                                    $rsql->execute(array('da' => formatinv_date($datevers),'id' => $idres));

                                                    header("location:?page=listeversementclientcais&codevers=". $codevers);
                                                }

                                            }
                                        }
                                    }
                                }
                            }
                            ?>
                            <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6 input_field_sections">
                                        <h5 style="text-align: center">Type de Reglement</h5>
                                        <div class="col-lg-12 push-lg-1">
                                            <label for="radio3" class="custom-control custom-radio signin_radio3"
                                                   style="margin-left: 100px">
                                                <input id="radio3" type="radio" class="custom-control-input" name="typeregle" value="frais_adhesion">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description"> Frais d'adhésion</span>
                                            </label>
                                            <label for="radio4" class="custom-control custom-radio signin_radio4">
                                                <input type="radio" id="radio4" class="custom-control-input" name="typeregle" value="versement">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description"> Versement</span>
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-header bg-white">
                                    MODE DE PAIEMENT
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 input_field_sections" >
                                        <!--                                    <h5 style="text-align:center">Mode de paiement</h5>-->
                                        <div class="col-lg-12">
                                            <label for="radio6" class="custom-control custom-radio signin_radio3" style="">
                                                <input id="radio6"  type="radio" class="custom-control-input"   name="mdp"  value="Compensation"  onclick="affiche(this.value)" required>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Compensation</span>
                                            </label>
                                            <label for="radio7" class="custom-control custom-radio signin_radio4">
                                                <input  type="radio"   id="radio7"   class="custom-control-input"   name="mdp"  value="Chèque" onclick="affiche(this.value)" required>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description" > Chèque</span>
                                            </label>
                                            <label for="radio71" class="custom-control custom-radio signin_radio4">
                                                <input  type="radio"   id="radio71"  class="custom-control-input"  name="mdp"  value="Virement"  onclick="affiche(this.value)" required>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description" > Virement</span>
                                            </label>
                                            <label for="radio722" class="custom-control custom-radio signin_radio4">
                                                <input  type="radio"   id="radio722"   class="custom-control-input"   name="mdp"  value="Compte"  onclick="affiche(this.value)" required>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Compte</span>
                                            </label>
                                            <label for="radio72" class="custom-control custom-radio signin_radio4">
                                                <input  type="radio"   id="radio72"   class="custom-control-input"   name="mdp"  value="Espèces"  onclick="affiche(this.value)" required>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Espèces</span>
                                            </label>
                                            <label for="radio272" class="custom-control custom-radio signin_radio4">
                                                <input  type="radio"   id="radio272"   class="custom-control-input"   name="mdp"  value="Transfert fonds"  onclick="affiche(this.value)" required>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Transfert fonds</span>
                                            </label>
                                        </div>

                                    </div>
                                    <div style="display: none" id="comp_block" class="row container">
                                        <div class="col-lg-4 input_field_sections" >
                                            <h5>Compensateur</h5>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="compensateur" id="compensateur" placeholder=" "  >
                                                <span class="input-group-addon text-primary">N°</i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: none" id="blockk" class="row container">
                                        <div class="col-lg-4 input_field_sections">
                                            <h5 id="numtext">Numéro chèque</h5>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="num_bq" id="num_blockk" placeholder=" "  >
                                                <span class="input-group-addon text-primary">N°</i></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 input_field_sections" id="bq_espece">
                                            <h5>Banque émettrice</h5>
                                            <div class="input-group">
                                                <select class="form-control chzn-select" id="b_emet" name="b_emet">
                                                    <option disabled selected>Selectionner la banque émettrice</option>
                                                    <?php
                                                    $i=1;
                                                    $rbe = $bdd->prepare('select * from table_banque ORDER BY nombanque DESC ');
                                                    $rbe->execute();
                                                    while($rowbe = $rbe->fetch()) { ?>
                                                        <option value="<?php echo $rowbe['idbanque'] ?>">
                                                            <?php if (!empty($rowbe['nombanque']) && !empty($rowbe['nomabrege'])) { echo $rowbe['nombanque'] . '('. $rowbe['nomabrege'] .') '; }
                                                            elseif (empty($rowbe['nombanque'])) { echo $rowbe['nomabrege']; }
                                                            else { echo $rowbe['nomabrege']; }
                                                            ?>
                                                        </option>
                                                        <?php $i++;}  ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row container">
                                        <div class="col-lg-4 input_field_sections">
                                            <h5>Montant</h5>
                                            <div class="input-group">
                                                <span class="input-group-addon"> <i class="fa fa-dollar text-primary"></i></span>
                                                <input type="text" class="form-control" id="mntp" name="mntp" onkeyup="turnon('<?= $rowg['mntdoc'] ?>');" required>
                                            </div>
                                            <span class="text-primary" id="erromsg"></span>
                                        </div>
                                        <div class="col-lg-4 input_field_sections" id="recep_bq">
                                            <h5>Banque receptrice</h5>
                                            <div class="input-group">
                                                <select class="form-control chzn-select" id="id_bq" name="id_bq" required>
                                                    <option disabled selected>Selectionner la banque émettrice</option>
                                                    <?php
                                                    $i=1;
                                                    $rbe = $bdd->prepare('select * from table_banque ORDER BY nombanque DESC ');
                                                    $rbe->execute();
                                                    while($rowbe = $rbe->fetch()) { ?>
                                                        <option value="<?php echo $rowbe['idbanque'] ?>">
                                                            <?php if (!empty($rowbe['nombanque']) && !empty($rowbe['nomabrege'])) { echo $rowbe['nombanque'] . '('. $rowbe['nomabrege'] .') '; }
                                                            elseif (empty($rowbe['nombanque'])) { echo $rowbe['nomabrege']; }
                                                            else { echo $rowbe['nomabrege']; }
                                                            ?>
                                                        </option>
                                                        <?php $i++;}  ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 input_field_sections" style="display: none">
                                            <h5>Numero de compte emetrice</h5>
                                            <div class="input-group">
                                                <span class="input-group-addon"> <i class="fa fa-tag text-primary"></i></span>
                                                <input type="text" class="form-control" name="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="dvers_bq" class="col-lg-4 input_field_sections">
                                        <h5>Date versement banque</h5>
                                        <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                        </span>
                                            <input autocomplete="off" type="text" class="form-control" placeholder="dd-mm-yyyy"  id="dp3" name="datevers_bq">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 input_field_sections">
                                        <h5>Date enregistrement</h5>
                                        <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                        </span>
                                            <input autocomplete="off" type="text" class="form-control" placeholder="dd-mm-yyyy"  id="dp4" name="datevers" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="courfile">
                                    <div class="col-lg-4 input_field_sections">
                                        <h5>Bordereau ou courier</h5>
                                        <input id="input-41" name="doc" type="file"  class="file-loading" style="display: block">
                                    </div>
                                </div>
                                <br />
                                <hr />
                                <div class="form-group row">
                                    <div class="container">
                                        <button id="validd" class="btn btn-success" type="submit" name="ok">
                                            <i class="fa fa-check"></i>
                                            Valider
                                        </button>
                                        <button class="btn btn-primary" type="reset" id="clear">
                                            <i class="fa fa-refresh"></i>
                                            Annuler
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/form.js"></script>
    <script type="text/javascript" src="js/pages/form_validation2.js"></script>
    <script type="text/javascript" src="js/pluginjs/jasny-bootstrap.js"></script>

    <script type="text/javascript" src="js/components.js?d=<?php echo time() ?>"></script>
    <script type="text/javascript" src="js/custom.js?d=<?php echo time() ?>"></script>
    <script>
        function affiche(str) {
            // console.log($('input[name=mdp]:checked').val());
            //  console.log(str);
            if (str =="Chèque"){
                $('#blockk').removeAttr('style');
                $('#b_emet').attr("required", "true");
                $('#num_blockk').attr("required", "true");
                $('#numtext').text("Numéro chèque");
                $('#bq_espece').removeAttr('style');
                $('#comp_block').css("display", "none");
                $('#recep_bq').css("display", "block");
                $('#dvers_bq').css("display", "block");
                $('#courfile').css("display", "block");
            }else if(str =="Virement"){
                $('#recep_bq').css("display", "block");
                $('#dvers_bq').css("display", "block");
                $('#blockk').removeAttr('style');
                $('#b_emet').attr("required", "true");
                $('#num_blockk').attr("required", "false");
                $('#numtext').text("Numéro virement");
                $('#bq_espece').removeAttr('style');
                $('#comp_block').css("display", "none");
                $('#courfile').css("display", "block");
            }
            else if(str =="Compte"){
                $('#recep_bq').css("display", "block");
                $('#dvers_bq').css("display", "block");
                $('#blockk').removeAttr('style');
                $('#b_emet').attr("required", "false");
                $('#num_blockk').val("");
                $('#numtext').text("Numéro bordereau");
                $('#bq_espece').css("display", "none");
                $('#comp_block').css("display", "none");
                $('#courfile').css("display", "block");

            }
            else if(str =="Espèces"){
                $('#recep_bq').css("display", "block");
                $('#bq_espece').css("display", "none");
                $('#dvers_bq').css("display", "block");
                $('#blockk').removeAttr('style');
                $('#num_blockk').attr("required", "false");
                $('#numtext').text("Numéro bordereau");
                $('#comp_block').css("display", "none");
                $('#courfile').css("display", "block");

            }
            else if(str == 'Transfert fonds'){
                $('#recep_bq').css("display", "none");
                $('#bq_espece').css("display", "none");
                $('#dvers_bq').css("display", "none");
                $('#blockk').css("display", "none");
                $('#courfile').css("display", "none");
                $('#num_blockk').val("");
                $('#compensateur').attr("required", "false");
                $('#num_blockk').attr("required", "false");
                $('#comp_block').css("display", "none");

            } else if(str =="Compensation"){
                $('#recep_bq').css("display", "none");
                $('#dvers_bq').css("display", "none");
                $('#bq_espece').css("display", "none");
                $('#comp_block').removeAttr('style');
                $('#compensateur').attr("required", "true");
                $('#blockk').css("display", "none");
                $('#num_blockk').val("");
            }
            else {
                $('#b_emet').removeAttr("required", "false");
                $('#num_blockk').removeAttr("required", "false");
                $('#num_blockk').val("");
                $('#numtext').text("");
                $('#recep_bq').removeAttr("style");
                $('#dvers_bq').removeAttr("style");
                $('#recep_bq').removeAttr("style");
                $('#courfile').removeAttr("style");

            }
        }
        // function affichecomp(str) {
        //     // console.log($('input[name=mdp]:checked').val());
        //     //  console.log(str);
        //     if(str =="Compensation"){
        //         $('#comp_block').removeAttr('style');
        //         $('#compensateur').attr("required", "true");
        //         $('#blockk').css("display", "none");
        //         $('#num_blockk').val("");
        //
        //     }
        //     else {
        //         $('#compensateur').attr("required", "false");
        //         $('#compensateur').val("");
        //     }
        // }


        function turnon (str) {
            var err = $('#erromsg')
            var mntp = $('#mntp')
            var butt = $('#validd')
            var fadh = $("input[name='typeregle']:checked")
            if (fadh.val() == "frais_adhesion") {
                if (parseInt(mntp.val())===parseInt(str)) {
                    butt.prop("disabled", false);
                    err.text("");
                } else {
                    err.text("Montant frais dossier inégal à " + str)
                    butt.prop("disabled", true);
                }
            }

        }


    </script>
<?php } else{ header("location:index.php");} ?>
