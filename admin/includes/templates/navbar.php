<nav class="navbar navbar-inverse">
  <div class="container">
   <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php">Home</a>
    </div>

    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="categories.php">Categories</a></li>
        <li><a href="items.php">Items</a></li>
        <li><a href="members.php">Members</a></li>
        <li><a href="comments.php">Comments</a></li>
        <li><a href="#">Statistics</a></li>
        <li><a href="#">Logs</a></li>
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <img class="img-thumbnail img-circle" src="layout/images/user_img1.png" alt="" style="width: 39px ; margin: 5px 10px 5px;"/>
            <span href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="float: right ; margin-top: 14px  ;color: #9d9d9d;"><?php echo $_SESSION['Username']; ?></a>
            <span class="caret" ></span>
            </span>
          <ul class="dropdown-menu">
            <li><a href="../indexu.php">Visit Shop</a></li>
            <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>">Edit Profile</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="logout.php">Logout</a></li> 
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>