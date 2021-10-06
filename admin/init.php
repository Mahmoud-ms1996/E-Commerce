<?php
    
        include 'connect.php';

    //Routes

        $tpl = 'includes/templates/'; // Template Directory
        $lang = 'includes/languages/'; // language Directory
        $func = 'includes/functions/'; // Functions Directory
        $css = 'layout/CSS/'; // Css Directory
        $js = 'layout/js/'; // Js Directory
        
 
        //Include The Important files
        
        include $func . 'functions.php';
        include $lang . 'english.php';
        include $tpl . 'header.php';

    //Include Navbar On ALL Pages expect the page with $noNavbar Vairable

        if(!isset($noNavbar)) { include $tpl . 'navbar.php'; }
        