<div class="sidebar-menu">

<div class="sidebar-menu-inner">

    <header class="logo-env">

        <!-- logo -->
        <div class="logo">
            <a href="index.php">
                <img src="assets/images/PS_white.png" width="120" alt="" />
            </a>
        </div>

        <?php if($_SESSION['perfil']<>6){?>

        <!-- logo collapse icon -->
        <div class="sidebar-collapse">
            <a href="#" class="sidebar-collapse-icon">

                <i class="entypo-menu"></i>
            </a>
        </div>

        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation">
                <!-- add class "with-animation" to support animation -->
                <i class="entypo-menu"></i>
            </a>
        </div>

        <?php } ?>

    </header>

    <?php if($_SESSION['perfil']<>6){?>

    <ul id="main-menu" class="main-menu">
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
    <?php if($_SESSION['perfil']==5){ 
        include './bin/select-paciente-tens.php';?>    
        <li>
            <a href="index.php?sec=paciente-tens&id=<?php echo $pacienteAsignado['paciente_id'];?>">
                <i class="entypo-cc-by"></i>
                <span class="title">Paciente</span>
            </a>
        </li>
    <?php } ?>
    <?php if($_SESSION['perfil']<>5){ ?>    
        <li>
            <a href="index.php">
                <i class="entypo-home"></i>
                <span class="title">Inicio</span>
            </a>
        </li>
    <?php } ?>
    <?php if($_SESSION['perfil']<>5){ ?>    
        <li>
            <a href="index.php?sec=lista-pacientes">
                <i class="entypo-cc-by"></i>
                <span class="title">Pacientes</span>
            </a>
        </li>
    <?php } ?>
    <?php if($_SESSION['perfil']<>5){ ?> 
        <li>
            <a href="index.php?sec=lista-insumos">
                <i class="entypo-box"></i>
                <span class="title">Insumos</span>
            </a>						
        </li>
    <?php } ?>
    <?php if($_SESSION['perfil']==1 || $_SESSION['perfil']==3){ ?>
        <li>
            <a href="index.php?sec=turnos">
                <i class="entypo-calendar"></i>
                <span class="title">Turnos</span>
            </a>						
        </li>
    <?php } ?>
    <?php if($_SESSION['perfil']==1){ ?> 
        <li>
            <a href="index.php?sec=lista-usuarios">
                <i class="entypo-user"></i>
                <span class="title">Usuarios</span>
            </a>						
        </li>
    <?php } ?>
    <?php if($_SESSION['perfil']==1){ ?> 
        <li>
            <a href="index.php?sec=asignar-tens">
                <i class="entypo-users"></i>
                <span class="title">Asignar TENS</span>
            </a>						
        </li>
    <?php } ?>
        <li>
            <a href="./bin/logout.php">
                <i class="entypo-logout"></i>
                <span class="title">Logout</span>
            </a>						
        </li>
    </ul>
    <?php } ?>
</div>

</div>