<?php

/*
    Categories => [ Manage | Edit | Update | Add | Inser | Delete | Stats ]

    Condition ? True : False
*/
    // $do = isset($_GET['do'])? $_GET['do'] : 'Manage'; OR
    
    $do = '';

    if(isset($_GET['do'])){

        $do = $_GET['do'];
    
    }else{

        $do = 'Manage';
    
    }
    
    // If The Page Is Main Page

    if ($do == 'Manage'){

        echo 'Welcome You Are In Manage Categroy Page';
        echo '<a href="?do=Add">Add New Category+</a>';

    }elseif ($do == 'Add'){

        echo 'Welcome You Are In Add Categroy Page';

    }else{

        echo 'Error There\'s No Page With This Name';
    }