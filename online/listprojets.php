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
              Liste des Projets
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
                    <a href="?page=creerprojet">Nouveau Projet</a>
                </li>
                <li class="active breadcrumb-item">Liste des Projets</li>
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
                            <i class="fa fa-table"></i> Listes des Projets
                        </div>
                        <div class="card-block m-t-35">
                             <div class="btn-group" style="margin-bottom: 10px;">    
                                        <a href="?page=creerprojet" id="editable_table_new" class=" btn btn-default">
                                        Creer un Projet &nbsp;<i class="fa fa-plus" ></i>
                                        </a>                                     
                                </div>
                            <table id="example1"  class="table2excel display table table-stripped table-bordered">
                                <thead>
                                <tr>
                                     <th>N°</th>
                                    <th>Projet</th>
                                     <th>N°Projet</th>
                                     <th>Prestations</th>
                                     <th>Montant PPM</th>
                                    <th>Date Debut</th>
                                    <th>Date fin</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                 <?php
                                $i=1;
                                $rsg = $bdd->prepare('select * from  tab_projet ORDER by id_projet   ASC ');
                                $rsg->execute(array());
                                while($rowg = $rsg->fetch()) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $rowg['Intitule_Contrat']; ?></td>
                                    <td><?php echo $rowg['Num_Contrat']; ?></td>
                                    <td>
                                        <?php
                                            $i=1;

                                            //var_dump($prest);
                                        $tb = explode(',',$rowg['idtypre']);
                                        foreach ($tb as $val){
                                            $rs = $bdd->prepare('select * from prestations WHERE idprest = :id');
                                            $rs->execute(array('id'=>$val));
                                            $row = $rs->fetch();

                                            echo $row ['libprestation'] .' / ';
                                        }
                                              ?>
                                       
                                            
                                    </td>
                                    <td><?php echo number_format($rowg['Mnt_passation']); ?></td>
                                    <td><?php echo $rowg['Datedebut']; ?></td>
                                    <td><?php echo $rowg['Datefin']; ?></td>

                                    <td>

                                            <a href="?page=modifprojetnew&id=<?php echo $rowg['id_projet']; ?>" class="todoedit">
                                                <span class="fa fa-pencil"></span>
                                            </a>
                                            <span class="dividor">|</span>
                                            <a href="#" class="tododelete redcolor">
                                                <span class="fa fa-trash"></span>
                                            </a>

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