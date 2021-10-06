<?php 
    
    session_start();
    
    $pageTitle = 'Create New Item';
    
    include 'init.php';
    
    if (isset($_SESSION['user'])) {


        if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $formErrors = array();

        $name       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $desc       = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $price      = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $country    = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
        $status     = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
        $categroy   = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
        $tags       = filter_var($_POST['tags'], FILTER_SANITIZE_STRING);
        if (strlen($name) < 4){

            $formErrors[] = 'Item Title Must Be At Least 4 Characters';
        }
        
        if (strlen($desc) < 10){

            $formErrors[] = 'Item description Must Be At Least 10 Characters';
        }

        if (strlen($country) < 2){

            $formErrors[] = 'Item country Must Be At Least 2 Characters';
        }

        if (empty($price)){

            $formErrors[] = 'Item Price Must Be No Empty';
        }

        if (empty($status)){

            $formErrors[] = 'Item Status Must Be No Empty';
        }

        if (empty($categroy)){

            $formErrors[] = 'Item Categroy Must Be No Empty';
        }

        // Check If There's No Error Proceed The Update Operation

        if(empty($formErrors)){


        // Insert userinfo In Database

        $stmt = $con->prepare("INSERT INTO
                            items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID, tags)
                            VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember, :ztags)");

        $stmt->execute(array(

            'zname'     => $name,
            'zdesc'     => $desc,
            'zprice'    => $price,
            'zcountry'  => $country,
            'zstatus'   => $status,
            'zcat'      => $categroy,
            'zmember'   => $_SESSION['uid'],
            'ztags'     => $tags
        ));                    

        //Echo Success Message

            if ($stmt){

                $successMsg = 'Item Has Been Added';
                
            }
        
        }

    }
?>                             
    <h1 class="title text-center"><?php echo $pageTitle ?></h1>                      
    <div class="create-ad block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading"><?php echo $pageTitle ?></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form class="form-horizontal main-form" action=<?php echo $_SERVER['PHP_SELF'] ?> method="POST" style="margin: 25px 0px 0px 0px;">
                            <!-- Start Name Field -->
                            <div class="form-group form-group-lg" sytle="margin-bottom: 15px;">
                                <label class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10 col-md-10">
                                    <input
                                        pattern=".{4,}"
                                        title="This Filed is Requried At Least 4 characters"
                                        type="text" 
                                        name="name" 
                                        class="form-control live-title" 
                                        autocomplete="off" 
                                        required="required"
                                        placeholder="Name of the Item"
                                        required/>
                                </div>
                            </div>
                            <!-- End Name Field -->
                            <!-- Start Description Field -->
                            <div class="form-group form-group-lg" sytle="margin-bottom: 15px;">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10 col-md-10">
                                    <textarea 
                                        pattern=".{10,}"
                                        title="This Filed is Requried At Least 10 characters"
                                        name="description" 
                                        class="form-control live-desc" 
                                        autocomplete="off" 
                                        required="required"
                                        placeholder="Describe of Item">
                                    </textarea>
                                </div>
                            </div>
                            <!-- End Description Field -->
                            <!-- Start Price Field -->
                            <div class="form-group form-group-lg" sytle="margin-bottom: 15px;">
                                <label class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-10 col-md-10">
                                    <input 
                                        type="text" 
                                        name="price" 
                                        class="form-control live-price" 
                                        autocomplete="off" 
                                        placeholder="Price of Item"
                                        required/>
                                </div>
                            </div>
                            <!-- End Price Field -->
                            <!-- Start Country Field -->
                            <div class="form-group form-group-lg" sytle="margin-bottom: 15px;">
                                <label class="col-sm-2 control-label">Country</label>
                                <div class="col-sm-10 col-md-10">
                                    <input 
                                    type="text" 
                                    name="country" 
                                    class="form-control" 
                                    autocomplete="off" 
                                    placeholder="Country of Made"
                                    required/>
                                </div>
                            </div>
                            <!-- End Country Field -->
                            <!-- Start Status Field -->
                            <div class="form-group form-group-lg" sytle="margin-bottom: 15px;">
                                <label class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-10 col-md-10">
                                    <select name="status" required>
                                        <option value="">...</option>
                                        <option value="1">New</option>
                                        <option value="2">Like New</option>
                                        <option value="3">Used</option>
                                        <option value="4">Very Old</option>
                                    </select>
                                </div>
                            </div>
                            <!-- End Status Field -->
                            <!-- Start Category Field -->
                            <div class="form-group form-group-lg" sytle="margin-bottom: 15px;">
                                <label class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-10 col-md-10">
                                    <select name="category" required>
                                        <option value="">...</option>
                                        <?php
                                            $cats = getAllFrom('*', 'categories', '', '', 'ID');
                                            foreach($cats as $cat){

                                                echo "<option value='" . $cat['ID'] ."'> ". $cat['Name'] ." </option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- End Category Field -->
                            <!-- Start tags Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">tags</label>
                                <div class="col-sm-10">
                                    <input 
                                    type="text" 
                                    name="tags" 
                                    class="form-control" 
                                    autocomplete="off"
                                    placeholder="Separate Tags With Comma (,)"
                                    />
                                </div>
                            </div>
                            <!-- End tags Field -->                
                            <!-- Start Submit Field -->
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10" >
                                    <input 
                                    type="submit"  
                                    value="Add Item" 
                                    class="btn btn-primary" 
                                    style="margin-top: 25px;"/>
                                </div>
                            </div>
                            <!-- End Submit Field -->
                        </form>
                    </div>
                        <div class="col-md-4">
                            <div class="thumbnail item-box live-preview" style="margin-bottom: 0px;">
                            <span class="price-tag">$0</span>
                            <img class="img-responsive" src="./layout/images/image.png" alt=""/>
                            <div class="caption">
                            <h3>title</h3>
                            <p>Description</p>
                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Looping Through Errors -->
                    <?php 
                        if(! empty($formErrors)){
                            foreach ($formErrors as $error) {
                                echo '<div class="alert alert-danger">' . $error . '</div>';
                            }
                        }
                        if (isset($successMsg)){

                            echo '<div class="alert alert-success">' . $successMsg . '</div>';
                        }
                    ?>
                    <!-- End Looping Through Errors -->
                </div>
            </div>    
        </div>
    </div>



<?php

    }else{

        header('Location:login.php');

        exit();
        
    }
 include $tpl . 'footer.php'; 
 
 ?>        