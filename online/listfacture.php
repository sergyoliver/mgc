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
                    <a href="?page=creerprojet">Nouvelle Facture</a>
                </li>
                <li class="active breadcrumb-item">Liste des Factures</li>
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
                            <i class="fa fa-table"></i> Liste des Factures
                        </div>
                        <div class="card-block m-t-35">
                             <div class="btn-group" style="margin-bottom: 10px;">    
                                        <a href="?page=ajoutfacture" id="editable_table_new" class=" btn btn-default">
                                       Réception Facture &nbsp;<i class="fa fa-plus" ></i>
                                        </a>                                     
                                </div>
                            <table id="example1"  class="table2excel display table table-stripped table-bordered">
                                <thead>
                                <tr>
                                        <th>N°</th>
                                        <th>Projet</th>
                                        <th>Entreprise</th>
                                        <th>Facture</th>
                                        <th>Mnt facture</th>
                                        <th>Mnt Payé</th>
                                        <th>Reste à Payer</th>
                                        <th>Date Réception</th>
                                        <th>Date Paiement</th>             
                                        <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Actions</th>
                                </tr>
                                </thead>

                             <tbody>
                                <?php
                                $i=1;
                                $rsg = $bdd->prepare('select * from tab_recep_facture ORDER by idrecept ASC ');
                                $rsg->execute(array());
                                while($rowg = $rsg->fetch()) {
                                
                                $idr =$rowg['idrecept'];
                                $rsr = $bdd->prepare("select * from  facture  WHERE idrecept  = :tp");
                                $rsr->execute(array("tp"=>$idr));
                                $rowrf = $rsr->fetch();

                                ?>

                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <!--#################-->
                                    <?php
                                $i=1;
                                $idp =$rowg['Idprojet'];
                                $rsa = $bdd->prepare("select * from  type_projet  WHERE Id_typep  = :zid");
                                $rsa->execute(array("zid"=>$idp));
                                //$rowp = $rsa->fetch();
                                while($rowp = $rsa->fetch()) {
                                ?>
                                    <td><?php echo $rowp['Nom_Projet']; ?></td>
                                <?php }?>
                                 <!--#################-->
                                   <?php
                                $i=1;
                                $idf =$rowg['id_fournisseurs'];
                                $rsf = $bdd->prepare("select * from  fournisseurs  WHERE id_fournisseurs  = :zid");
                                $rsf->execute(array("zid"=>$idf));
                                while($rowf = $rsf->fetch()) {
                                ?>
                                    <td><?php echo $rowf['Name_entreprise']; ?></td>
                                <?php }?>
                                 <!--#################-->
                                    <td>
                                        <?php echo $rowg['Num_Facture']; ?>
                                    </td>
                                     <!--#################-->
                                    <td>
                                        <?php echo $rowg['Mnt_Facture']; ?>
                                    </td>
                                     <!--#################-->
                                   
                                    <td><?php echo $rowrf['Mnt_regle']; ?></td>
                               
                                 <!--#################-->                                  
                                  
                                    <td>
                                        <?php

                                        $restp = $rowg['Mnt_Facture']-$rowrf['Mnt_regle'];
                                         echo $restp; ?>
                                            
                                        </td>
                                
                                 <!--#################-->                                
                                    <td>
                                        <?php echo $rowg['date_reception']; ?>
                                    </td>
                                    <!--#################--> 
                                   
                                    <td><?php echo $rowrf['Date_Paiement_Fact']; ?></td>
                                    
                               
                                <!--#################-->
                                    
                                        <td>   
                                            <div class="dropdown no-bg">
                                                <a href="?page=modifrecept&id=<?php echo $rowg['idrecept']; ?>" class="todoedit">
                                                <span class="fa fa-pencil"></span>
                                              </a>
                                              <span class="dividor">|</span>
                                              <a href="#" class="tododelete redcolor">
                                                <span class="fa fa-trash"></span>
                                              </a> 

                                            <?php 
                                            $restp1 = $rowg['Mnt_Facture']-$rowrf['Mnt_regle'];
                                            if ($restp1 <= 0) {?>
                                                <button class="btn btn-success"
                                                    type="button" id="up2" 
                                                    aria-haspopup="true" aria-expanded="false">
                                                Soldé
                                                 <i class="fa-li fa fa-check-square"></i>
                                                 </div>
                                                </button>
                                                
                                            <?php    
                                            }else{
                                          
                                             ?>
                                            <button class="btn btn-warning dropdown-toggle"
                                                    type="button" id="up1" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">

                                            </button>                                         
                                            <div class="dropdown-menu" aria-labelledby="up2">
                                               
                                                <a class="dropdown-item" href="?page=paiementfact&id=<?php echo $rowg['idrecept']; ?>" target="_blank"><i class="fa fa-sign-out"></i>
                                                    Paiement
                                                </a>
                                            </div><?php } ?>

                                           
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