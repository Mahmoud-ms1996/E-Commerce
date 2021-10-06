<?php
        // Error Reporting

        include 'admin/connect.php';

        $sessionUser = '';
        if(isset($_SESSION['user'])){
            $sessionUser = $_SESSION['user'];
        }

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