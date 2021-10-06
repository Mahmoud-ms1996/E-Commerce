<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php getTitle() ?></title>
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>frontend.css"/>
    
</head>
<body>
  <div class="upper-bar">
      <div class="container">
        <?php 
            if (isset($_SESSION['user'])){ ?>
             <!-- $sessionUser from init.php -->
            
             <div class="btn-group my-info nav navbar-nav navbar-right" style="float:right;">
                <img class="img-thumbnail img-circle" src="layout/images/user_img1.png" alt="" style="width:40px"/>
                <span class="btn dropdown-toggle" data-toggle="dropdown" style="float:right;margin-top: 3px;color: #9d9d9d;">
                  <?php echo $sessionUser ?>
                  <span class="caret"></span>
                  </span>
                    <ul class="dropdown-menu">
                      <li><a href="newad.php">Add New Item</a></li>
                      <li><a href="profile.php">My Profile</a></li>
                      <li><a href="profile.php#my-ads">My Items</a></li>
                      <li><a href="logout.php">Logout</a></li>
                    </ul>
            </div>
          
        <?php      
            } else {
          ?>    
            
        <a href="login.php">
            <span class="pull-right" style="color:#9d9d9d">Login/<span class="fa fa-sign-in"></span>Signup</span>
        </a>
        <?php } ?>      
      </div>
  </div>
<nav class="navbar navbar-inverse">
  <div class="container">
   <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="indexu.php">Homepage</a>
    </div>

    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
        <?php
          foreach(getCat() as $cat){
            echo 
            '<li>
                <a href="categories.php?pageid=' . $cat['ID'] . '">
                        ' . $cat['Name'] . '
                </a>
            </li>';
          }
        ?>
      </ul>
    </div>
  </div>
</nav>    

    
