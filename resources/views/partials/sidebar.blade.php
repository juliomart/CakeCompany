<div id="wrapper">
    <div class="overlay"></div>

    <!-- Sidebar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
        <ul class="nav sidebar-nav">
            <li class="sidebar-brand">
                <a href="#">
                    Menu
                </a>
            </li>
            <li>
                <a href="/"><i class="fa fa-fw fa-home"></i> Home</a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-plus"></i> Commandes<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <div class="dropdown-header" hidden></div>
                    <li><a href="/commande/">Liste de commandes</a><br></li>
                    <li><a href="/commande/create">Nouvelle commande</a><br></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-plus"></i> Recettes<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <div class="dropdown-header" hidden></div>
                    <li><a href="/recette/">Liste de recettes</a><br></li>
                    <li><a href="/recette/create">Ajouter recette</a><br></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-plus"></i> Stock<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <div class="dropdown-header" hidden></div>
                    <li><a href="/ingredient/">Liste d'ingrédients</a><br></li>
                    <li><a href="/ingredient/create">Ajouter ingrédient</a><br></li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <button type="button" class="hamburger is-closed animated fadeInLeft" data-toggle="offcanvas">
            <span class="hamb-top"></span>
            <span class="hamb-middle"></span>
            <span class="hamb-bottom"></span>
        </button>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->