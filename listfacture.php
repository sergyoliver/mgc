<!-- global styles-->

<link type="text/css" rel="stylesheet" href="vendors/select2/css/select2.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="vendors/datatables/css/scroller.bootstrap.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="vendors/datatables/css/colReorder.bootstrap.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="vendors/datatables/css/dataTables.bootstrap.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="css/pages/dataTables.bootstrap.css?d=<?php echo time() ?>" />
<!-- end of plugin styles -->
<!--Page level styles-->
<link type="text/css" rel="stylesheet" href="css/pages/tables.css?d=<?php echo time() ?>" />



<header class="head">
    <div class="main-bar row">
        <div class="col-sm-5 col-lg-6 skin_txt">
            <h4 class="nav_top_align">
                <i class="fa fa-table"></i>
              Liste des Factures
            </h4>
        </div>
        <div class="col-sm-7 col-lg-6">
            <ol class="breadcrumb float-xs-right nav_breadcrumb_top_align">
                <li class="breadcrumb-item">
                    <a href="?page=milieu">
                        <i class="fa fa-home" data-pack="default" data-tags=""></i>
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="?page=milieu">Nouvelle Facture</a>
                </li>
                <li class="active breadcrumb-item"> Liste des Factures</li>
            </ol>
        </div>
    </div>
</header>
<div class="outer">
    <div class="inner bg-container forms">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-t-35">
                        <div class="card-header bg-white">
                            <i class="fa fa-table"></i>  Liste des Factures
                        </div>
                        <div class="card-block m-t-35">
                            <div class="card-block m-t-35">
                                        <a href="?page=ajoutfacture" id="editable_table_new" class=" btn btn-default">
                                        Réception Facture &nbsp;<i class="fa fa-plus" class="btn btn-success"></i>
                                        </a>                                     
                            </div>
                            <table id="example1"  class="table2excel display table table-stripped table-bordered">
                                <thead>
                                <tr>
                                        <th>N°</th>
                                        <th>Projet</th>
                                        <th>Entreprise</th>
                                        <th>N°Facture</th>
                                         <th>Date Réception</th>
                                        <th>Mnt facture</th>
                                        <th>Mnt Payé</th>
                                        <th>Reste à Payer</th>
                                        <th>Date Paiement</th>
                                        <th>Delai de paiement</th>              
                                        <th>Actions</th>
                                </tr>
                                </thead>

                             <tbody>
                                <?php
                                $i=1;
                                $rsg = $bdd->prepare('select * from tab_recep_facture ORDER by idrecept ASC ');
                                $rsg->execute(array());
                                while ($rowg = $rsg->fetch()){
                                ?>

                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <?php
                                $i=1;
                                $idp =$rowg['idmarche'];
                                $rsa = $bdd->prepare("select * from  tab_projet  WHERE id_projet  = :zid and supp=0");
                                $rsa->execute(array("zid"=>$idp));
                                $rowp = $rsa->fetch();

                                ?>
                                    <td><?php echo $rowp['Intitule_Contrat']; ?></td>

                                   <?php
                                $i=1;
                                $idf =$rowg['id_fournisseurs'];
                                $rsf = $bdd->prepare("select * from  fournisseurs  WHERE id_fournisseurs  = :zid");
                                $rsf->execute(array("zid"=>$idf));
                               $rowf = $rsf->fetch();
                                ?>
                                    <td><?php echo $rowf['Name_entreprise']; ?></td>

                                    <td>
                                        <?php echo $rowg['Num_Facture']; ?>
                                    </td>
                                    <td>
                                        <?php echo format_date2($rowg['date_reception']); ?>
                                    </td>
                                    <td>
                                        <?php echo number_format($rowg['Mnt_Facture']); ?>
                                    </td>
                                    <?php
                                $i=1;
                                $idr =$rowg['idrecept'];
                                $rsr = $bdd->prepare("select sum(montant) as mp from  tab_reglement_facture  WHERE idreception  = :zid");
                                $rsr->execute(array("zid"=>$idr));
                                $rowr = $rsr->fetch();
                                ?>
                                    <td><?php echo number_format($rowr['mp']); ?></td>

                                    <?php
                                $i=1;
                                $idr =$rowg['idrecept'];
                                $rsr = $bdd->prepare("select * from  facture  WHERE id_Facture  = :zid");
                                $rsf->execute(array("zid"=>$idr));
                             $rowr = $rsr->fetch()
                                ?>
                                    <td><?php echo  number_format($rowg['Mnt_Facture']-$rowr['mp']); ?></td>



                                    <td><?php echo $rowr['Mnt_regle']; ?></td>

                                    <?php
                                $i=1;
                                $idr =$rowg['idrecept'];
                                $rsr = $bdd->prepare("select * from  facture  WHERE id_Facture  = :zid");
                                $rsf->execute(array("zid"=>$idr));
                               $rowr = $rsr->fetch();
                                ?>
                                    <td><?php echo $rowr['Mnt_regle']; ?></td>
                             <td>
                                           
                                            <div class="dropdown no-bg">
                                                <a href="?page=modifrecept&id=<?php echo $rowg['idrecept']; ?>" class="todoedit">
                                                <span class="fa fa-pencil"></span>
                                              </a>
                                              <span class="dividor">|</span>
                                              <a href="#" class="tododelete redcolor">
                                                <span class="fa fa-trash"></span>
                                              </a> 

                                            <button class="btn btn-warning dropdown-toggle"
                                                    type="button" id="up1" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">

                                             </button>
                                             <div class="dropdown-menu" aria-labelledby="up1">
                                                 
                                            </div>


                                             <div class="dropdown-menu" aria-labelledby="up2">
                                               
                                                <a class="dropdown-item" href="?page=paiementfact&id=<?php echo $rowg['idrecept']; ?>" target="_blank"><i class="fa fa-sign-out"></i>
                                                    Paiement
                                                </a>
                                            </div>

                                           
                                        </div>

                                    </td>
                                </tr>
                                    <?php $i++; } ?>
                            </tbody>
                            </table>

                        </div>
                    </div>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="js/components.js"></script>
<script type="text/javascript" src="js/custom.js"></script>