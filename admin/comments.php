<?php

    /*
    ==============================================
    ==Manage Comments Page
    ==You Can Edit | Delete | Approve Comments From here
    ==============================================
    */
    session_start();

    $pageTitle = 'Comments';

    if(isset($_SESSION['Username'])){

        include 'init.php';
        
        $do = isset($_GET['do'])? $_GET['do'] : 'Manage';

        // Start Mange Page

        if ($do == 'Manage'){ // Manage Members Page 
        
            //Select All users Except Admin

            $stmt = $con->prepare("SELECT 
                                        comments.*, items.Name AS Item_Name, users.Username AS Member
                                    FROM 
                                        comments
                                    INNER JOIN
                                        items
                                    ON
                                        items.item_ID = comments.item_id
                                    INNER JOIN
                                        users
                                    ON
                                        users.UserID = comments.user_id
                                    ORDER BY
                                        c_id DESC");
                                    
            // Execute The Statement
            $stmt->execute();
            
            // Assign To Variable

            $rows = $stmt->fetchAll();

        ?> 
            <style>
            .activate {
            margin-left: 5px;
            }
            </style>

            <h1 class="text-center">Manage Comments</h1>
                <div class="container">
                    <div class="table-responsive">
                        <table class="main text-center table table-bordered" style="box-shadow:0 3px 10px #CCC">
                            <tr >
                                <td>#ID</td>
                                <td>Comments</td>
                                <td>Item Name</td>
                                <td>User Name</td>
                                <td>Date</td>
                                <td>Control</td>
                            </tr>
                            
                            <?php 
                                foreach($rows as $row){
                                    echo"<tr>";
                                        echo "<td>" . $row['c_id'] . "</td>";
                                        echo "<td>" . $row['comment'] . "</td>";
                                        echo "<td>" . $row['Item_Name'] . "</td>";
                                        echo "<td>" . $row['Member'] . "</td>";
                                        echo "<td>" . $row['comment_date'] ."</td>";
                                        echo "<td>
                                        <a href='comments.php?do=Edit&comid=" . $row['c_id'] ."'class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                        <a href='comments.php?do=Delete&comid=" . $row['c_id'] ."' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                                             
                                        if($row['status'] == 0){
                                               
                                            echo "<a href='comments.php?do=Approve&comid=" . $row['c_id'] ."' class='btn btn-info activate'><i class='fa fa-check'></i> Approve</a>";

                                        }
                                        
                                        echo"</td>";
                                    echo"</tr>";
                                }

                            ?>

                        </table>
                    </div>
                </div>

<?php  } elseif ($do == 'Edit'){ // Edit Page 

            // Check If Get Request comments_id Is Numeric & The Integer Value of It
            
            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
            
            // Select All Data Depend On This ID
            
            $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");
            
            // Execute Query
            
            $stmt->execute(array($comid));
            
            // Fetch The Data

            $row = $stmt -> fetch();
            
            // The Row Count
            
            $Count = $stmt->rowCount();

            // If There's an ID Show The Form

            if($Count > 0) { ?>

                <h1 class="text-center">Edit Comment</h1>
                 <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="POST">
                        <input type="hidden" name="comid" value="<?php echo $comid ?>" />
                        <!-- Start Comment Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Comment</label>
                            <div class="col-sm-10 col-md-6">
                            <textarea class="form-control" name="comment"><?php echo $row['comment'] ?></textarea>  
                        </div>
                        </div>
                        <!-- End Comment Field -->
                        
                        <!-- Start Submit Field -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save" class="btn btn-primary btn-lg"/>
                            </div>
                        </div>
                        <!-- End Submit Field -->
                    </form>
                 </div>

        <?php 

                // If there's No ID Show Error Message

            } else {
                
                echo "<div class=container>";
                
                    $theMsg = '<div class="alert alert-danger">there is No ID</div>';

                    redirectHome($theMsg);

                echo"</div>";
            
            }
        
        } elseif($do == 'Update'){ //Update Page
            
            echo "<h1 class='text-center'>Update Comment</h1>";
            echo "<div class='container'>";

            if ($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Get Variables From The Form

                $comid     = $_POST['comid'];
                $comment   = $_POST['comment'];
                
                // Udate The Database with This Info

                $stmt = $con->prepare("UPDATE comments SET comment = ? WHERE c_id = ?");
                
                $stmt->execute(array($comment, $comid));

                //Echo Success Message

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
                
                    redirectHome($theMsg, 'back');
            
            }else{
                
                $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

                redirectHome($theMsg);
                
                }

            
            
        } elseif($do == 'Delete'){ // Delete button

          echo "<h1 class='text-center'>Delete Comment</h1>";
          echo "<div class='container'>";

            // Check If Get Request comid Is Numeric & The Integer Value of It
            
            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
            
            // Select All Data Depend On This ID
            
            $check = checkItem('c_id','comments',$comid);

            // If There's an ID Show The Form

            if($check > 0){

                $stmt = $con->prepare("DELETE FROM comments WHERE c_ID =  :zid"); //<- UserID= ? OR = :userid OR = :zuser  

                $stmt->bindParam(":zid", $comid);

                $stmt->execute();

                //Echo Success Message

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted</div>';                

                redirectHome($theMsg,'back');

            } else {

                $theMsg = '<div class="alert alert-danger">This ID is not Exist</div>';

                redirectHome($theMsg);

                }

            echo '</div>';

        } elseif ($do == 'Approve') {

            echo "<h1 class='text-center'>Approve Comment</h1>";
            echo "<div class='container'>";

            // Check If Get Request comid Is Numeric & The Integer Value of It
            
            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
            
            // Select All Data Depend On This ID
            
            $check = checkItem('c_id','comments', $comid);

            // If There's an ID Show The Form

            if($check > 0){

                $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");   

                $stmt->execute(array($comid));

                //Echo Success Message

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Comment Approved</div>';                

                redirectHome($theMsg,'back');

            } else {

                $theMsg = '<div class="alert alert-danger">This ID is not Exist</div>';

                redirectHome($theMsg);

                }

        }  
            
                include $tpl . 'footer.php';
        
        } else {

            header('location: index.php');
        
            exit();
        }
        
    