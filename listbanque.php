<!-- global styles-->

<link type="text/css" rel="stylesheet" href="vendors/select2/css/select2.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="vendors/datatables/css/scroller.bootstrap.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="vendors/datatables/css/colReorder.bootstrap.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="vendors/datatables/css/dataTables.bootstrap.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="css/pages/dataTables.bootstrap.css?d=<?php echo time() ?>" />
<!-- end of plugin styles -->
<!--Page level styles-->
<link type="text/css" rel="stylesheet" href="css/pages/tables.css?d=<?php echo time() ?>" />
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->

<header class="head">
    <div class="main-bar row">
        <div class="col-sm-5 col-lg-6 skin_txt">
            <h4 class="nav_top_align">
                <i class="fa fa-table"></i>
              Liste des Banques
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
                    <a href="?page=ajoutbanque">Nouvelle Banque</a>
                </li>
                <li class="active breadcrumb-item">Liste des Banques</li>
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
                            <i class="fa fa-table"></i> Listes des Banques
                        </div>
                        <div class="card-block m-t-35">
                            <div class="btn-group" style="margin-bottom: 10px;">    
                                        <a href="?page=ajoutbanque" id="editable_table_new" class=" btn btn-default">
                                        Ajouter une Banque &nbsp;<i class="fa fa-plus" class="btn btn-primary"></i>
                                        </a>                                     
                                </div>

                            <table id="example1"  class="table2excel display table table-stripped table-bordered">
                                <thead>
                                <tr>
                                   
                                    <th>N° D'ordre</th>
                                    <th>Sigle</th>
                                    <th>Capital social</th>
                                    <th>Contact</th>
                                    <th>Responsable</th>  
                                    <th>Actionnaire</th>                        
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                              <?php
                                $i=1;
                                $rsg = $bdd->prepare('select * from banque ORDER by id_bank   ASC ');
                                $rsg->execute(array());
                                while($rowg = $rsg->fetch()) {
                                ?>

                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $rowg['sigleb']; ?></td>
                                    <td><?php echo $rowg['capitalb']; ?></td>
                                    <td><?php echo $rowg['contactb']; ?></td>
                                    <td><?php echo $rowg['respob']; ?></td>
                                    <td><?php echo $rowg['actionnaire']; ?></td>
                                    <td>

                                        
                                            <a href="?page=modifbank&id=<?php echo $rowg['id_bank']; ?>" class="todoedit">
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