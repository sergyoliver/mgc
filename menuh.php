<nav class="navbar navbar-static-top" >
    <div class="container-fluid">
        <a class="navbar-brand text-xs-center" href="?page=milieu">
<!--            <h4 class="text-white"><img src="../img/logo.ico?d=--><?php //echo time() ?><!--" class="admin_img" alt="logo"> Admin 21</h4>-->
        </a>
        <div class="menu">
                        <span class="toggle-left" id="menu-toggle">
                        <i class="fa fa-bars text-white"></i>
                        </span>
        </div>

        <!-- Toggle Button -->
        <div class="text-xs-right xs_menu">
            <button class="navbar-toggler hidden-xs-up" type="button" data-toggle="collapse"
                    data-target="#nav-content">
                ☰
            </button>
        </div>
        <!-- Nav Content -->
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="topnav dropdown-menu-right float-xs-right">


            <div class="btn-group">
                <div class="user-settings no-bg">
                    <button type="button" class="btn btn-default no-bg micheal_btn" data-toggle="dropdown">
                        <img src="img/defaut.jpg" class="admin_img2 rounded-circle avatar-img" alt="avatar">

                        <span class="fa fa-sort-down white_bg"></span>
                    </button>
                    <div class="dropdown-menu admire_admin">
                        <a class="dropdown-item title" href="#">
                            Bienvenu(e) <strong><?php echo $_SESSION['nom'] ?></strong> </a>

                        <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out"></i>
                           Deconnexion</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="collapse navbar-toggleable-sm col-xl-6 col-lg-6 hidden-md-down   top_menu" id="nav-content" >

    <ul class="nav navbar-nav top_menubar"  >
                <li class="nav-item">
                    <a class="nav-link text-white" href="javascript:;">
                        <i class="fa fa-inbox"></i> <span class="quick_text">BIENVENU(E) SUR L'INTERFACE ADMINISTRATEUR </span>
                    </a>
                </li>

            </ul>

        </div>
    </div>

    <!-- /.container-fluid -->
</nav>