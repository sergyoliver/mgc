<div id="left" class="fixed" >
    <div class="menu_sction menu_scroll">
        <div class="media user-media">
            <div class="user-media-toggleHover">
                <span class="fa fa-user"></span>
            </div>
            <div class="user-wrapper bg-dark" style="display: none">
                <a class="user-link" href="#">
                    <img class="media-object img-thumbnail user-img rounded-circle admin_img3" alt="User Picture"
                         src="img/admin.jpg">
                    <p class="text-white user-info">Welcome </p>
                </a>
                <div class="search_bar col-lg-12">
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="search">
                                                <span class="input-group-btn">
                        <button class="btn without_border" type="button"><span class="fa fa-search">
                        </span></button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- #menu -->
        <ul id="menu" class="bg-blue dker">
            <li class="active">
                <a href="?page=milieu">
                    <i class="fa fa-home"></i>
                    <span class="link-title">&nbsp;Espace  <?php if(isset($_SESSION['dgpe'])) echo $_SESSION['dgpe'] ?></span>
                </a>
            </li>


             <ul id="menu" class="bg-blue dker">
                <!-- ################################ -->

                <!-- #################################-->
                   
                    <!-- ############################# -->
                    <li>
                            <a href="javascript:void(0) ;">
                                <i class="fa fa-th-large"></i>
                                <span class="link-title"> Gestion des&nbsp; Fournisseurs </span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul>
                                 <li>
                                    <a href="?page=listprojets">
                                        <i class="fa fa-angle-right"></i>
                                        &nbsp;Liste Marchés
                                    </a>
                                </li> 
                                <li>
                                    <a href="?page=listfournisseurs">
                                        <i class="fa fa-angle-right"></i>
                                        &nbsp;Liste Fournisseurs
                                    </a>

                                </li>
                                 <li>
                                    <a href="?page=listsoumission">
                                        <i class="fa fa-angle-right"></i>
                                        &nbsp;Soumission
                                    </a>

                                </li>                                 
                            </ul>
                   </li>
                    <!-- #############################-->


                   <!-- ############################# -->

                    
                     <!--##########################################-->

           

            <?php  //if (isset($_SESSION['email']) && $_SESSION['gpe']&& $_SESSION['gpe']=="SuperAdmin"  ) { ?>



            <?php  //} ?>
        </ul>
        <!-- /#menu -->
    </div>
</div>