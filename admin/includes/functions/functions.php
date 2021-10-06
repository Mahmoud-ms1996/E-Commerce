<?php 

    /*
    ** Get All Function v2.0
    ** function To Get All Records From Database table
    */

    function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC") {
        
        global $con;

        $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

        $getAll->execute();

        $all = $getAll->fetchAll();

        return $all;
    }


    /*
    ** Title Page Function v1.0
    ** Title Function That Echo The Page Title In Case The Page
    ** Has The Variable $pageTitle And Echo Defult Title For Other Pages
    */

    function getTitle(){

        global $pageTitle;

        if(isset($pageTitle)){
            
            echo $pageTitle;
        }else{

            echo 'Default';
        }
    }

    /*
    ** Home Redirect Function v2.0
    ** This Function Accept Parameters
    ** $theMsg = Echo The Message [ Error | Success | Warning ]
    ** $url = The Link You Want To Redirect To
    ** $seconds = Seconds Before Redirecting
    */

        function redirectHome ($theMsg, $url = null, $seconds = 3){

            if($url === null){
                
                $url = 'index.php';
            
                $link = 'HomePage';
            
            } else {

                
             if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){

                    $url = $_SERVER['HTTP_REFERER'];

                    $link = 'Previous Page';

                } else{
                
                    $url='index.php';

                    $link = 'HomePage';

                }
                

            }

            echo $theMsg;

            echo "<div class='alert alert-info'>You Will Be Redirected To $link After $seconds Seconds.</div>";
        
            header("refresh:$seconds;url=$url");

            exit();
        }

    /*
    ** Check Item Function v1.0
    ** Function To Check Item In DataBase[ function Accept Parameters ]
    ** $select = The Item To Select [ Example: user, item, Category ]
    ** $from = The Table To Select From [ Example: users, items, Categories ]
    ** $value = The Value Of Select [ Exampe: mhmd, Box, Electronics ]
    */

    function checkItem($select, $from, $value){

        global $con;

        $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

        $statement->execute(array($value));

        $count = $statement->rowCount();

        return $count;
    }

    /*
    ** Funcction Count Number Of Item v1.0 
    ** To Count Number Of Items Rows
    ** $item = The Item To Count
    ** $table = The Table To Choose From
    */

        function countItems($item, $table){

            global $con;

            $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

            $stmt2->execute();

            return $stmt2->fetchColumn();
        }

        /*
        ** Get Latest Records Function v1.0
        ** Function To Get Latest Items From Database [ Users, Items, Comments]
        ** $select = Field To Select
        ** $table = The Table To Choose From
        ** $order = The Desc Ordering
        ** $limit = Number Of Records To Get
        */

        function getlatest($select, $table, $order ,$limit){

            global $con;

            $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

            $getStmt->execute();

            $rows = $getStmt->fetchAll();

            return $rows;
        }