<?php
//starting session
session_start();

// make connection
$conn   = mysqli_connect('localhost','root','','finpro');

//Login
if(isset($_POST['login'])){
    //iniate var
    $username   =$_POST['username'];
    $password   =$_POST['password'];
    

    $check      = mysqli_query($conn,"select * from user where username='$username' and us_pass='$password'");
    $count      = mysqli_num_rows($check);
    
    if($count>0){
        //if found data
        //succes login

        $_SESSION['login'] = 'TRUE';
        $_SESSION['username'] = $username;
        header("location:login.php");
    }

    else{
        //data not found
        echo '
        <script>alert("Username or Password invalid!");
        window.location.href="login.php"
        </script>
        
        ';
    }

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
    }
}





if(isset($_POST['register'])){
    $username =$_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $email    = $_POST['email'];
    $role      =$_POST['role'];

    $insert = mysqli_query($conn,"insert into user(username,us_pass,us_name,us_email,us_role) values('$username','$password','$name','$email','$role')");

    if($insert){
        echo 'Register Succesfully';
        header("location:manageuser.php");
    }else{
        echo 'Register Failed';
    }
}

if(isset($_POST['registercustomer'])){
    $username =$_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $email    = $_POST['email'];
    $role      =$_POST['role'];

    $insert = mysqli_query($conn,"insert into user(username,us_pass,us_name,us_email,us_role) values('$username','$password','$name','$email','$role')");

    if($insert){
        echo 'Register Succesfully';
        header("location:manageuser.php");
    }else{
        echo 'Register Failed';
    }
}



if(isset($_POST['newitem'])){
    $productname    = $_POST['productname'];
    $description    = $_POST['description'];
    $price          = $_POST['price'];
    $stock          = $_POST['stock'];

    $insert         = mysqli_query($conn,"insert into product(productname,description,price,stock) values ('$productname','$description',
    '$price','$stock')");

    if($insert){
        header('location:stock.php');
    }else{
        echo '
        <script>alert("failed to add new item");
        window.location.href="stock.php"
        </script>
        
        ';
    }
}

if(isset($_POST['newcustomer'])){
    $customername    = $_POST['customername'];
    $phonenumber    = $_POST['phonenumber'];
    $address          = $_POST['address'];

    $insert         = mysqli_query($conn,"insert into customer(customername,phonenumber,address) values ('$customername','$phonenumber',
    '$address')");

    if($insert){
        header('location:customer.php');
    }else{
        echo '
        <script>alert("failed to add new customer");
        window.location.href="customer.php"
        </script>
        
        ';
    }
}

if(isset($_POST['neworder'])){
    $idcustomer    = $_POST['idcustomer'];

    $insert         = mysqli_query($conn,"insert into orders(idcustomer) values ('$idcustomer')");

    if($insert){
        header('location:index.php');
    }else{
        echo '
        <script>alert("failed to add new order");
        window.location.href="index.php"
        </script>
        
        ';
    }
}

//product choosen in order
if(isset($_POST['addproduct'])){
    $idproduct    = $_POST['idproduct'];
    $idp           = $_POST['idp']; //idorder
    $qty          = $_POST['qty'];  //amount to sell

   //count the current stock
   $count1       = mysqli_query($conn,"select * from product where idproduct='$idproduct'");
   $count2       = mysqli_fetch_array($count1);
   $currentstock = $count2['stock']; //current stock

   if($currentstock>=$qty){

        $difference     = $currentstock - $qty;
     //stock is okay
        $insert         = mysqli_query($conn,"insert into orderdetail(idorder,idproduct,qty) values ('$idp','$idproduct','$qty')");
        $update         = mysqli_query($conn,"update product set stock='$difference' where idproduct='$idproduct'");
        
        if($insert&&$update){
            // echo $idproduct;
            header('location:view.php?idp='.$idp);
        }else{
            echo '
            <script>alert("failed to add new order");
            window.location.href="view.php?idp='.$idp.'"    
            </script>
            
            ';
        }
   }else{
    //stock not okay
        echo '
        <script>alert("Innuficient Stock");
        window.location.href="view.php?idp='.$idp.'"
        </script>
        
        ';
   }
}


//adding new item
if(isset($_POST['newproduct'])){
    $idproduct  = $_POST['idproduct'];
    $qty        = $_POST['qty'];

    //check current stock
    $checkstock         = mysqli_query($conn,"select * from product where idproduct='$idproduct'");
    $checkstock2        = mysqli_fetch_array($checkstock);
    $currentstock       = $checkstock2['stock'];
    
    //count 
    $newstock            = $currentstock+$qty;

    $insertnewproduct           = mysqli_query($conn,"insert into newproduct (idproduct,qty) values('$idproduct','$qty')");
    $updatenewproduct           = mysqli_query($conn,"update product set stock='$newstock' where idproduct='$idproduct'");
    
    if($insertnewproduct&&$updatenewproduct){
        header('location:newitem.php');
    }else{
        echo '
        <script>alert("Failed!");
        window.location.href="newitem.php   "
        </script>
        
        ';
    }
}

//deleteorderproduct
if(isset($_POST['deleteproduct'])){
    $idp  =$_POST['idp']; //idorderdetail
    $idpr = $_POST['idpr'];
    $idorder =$_POST['idorder'];

    //check current qty
    $check1 = mysqli_query($conn,"select * from orderdetail where idorderdetail='$idp'");
    $check2 = mysqli_fetch_array($check1);
    $qtysekarang = $check2['qty'];

    //check current stock
    $check3 = mysqli_query($conn,"select * from product where idproduct='$idpr'");
    $check4 = mysqli_fetch_array($check3);
    $stocksekarang   = $check4['stock'];

    $hitung = $stocksekarang+$qtysekarang;

    $update = mysqli_query($conn,"update product set stock='$hitung' where idproduct='$idpr'"); //updating stock
    $hapus  = mysqli_query($conn,"delete from orderdetail where idproduct='$idpr' and idorderdetail='$idp'");

    if($update&&$hapus){
         header('location:view.php?idp='.$idorder);
    }else{
        echo '
        <script>alert("Failed delete item");
        window.location.href="view.php?idp='.$idorder.'"
        </script>
        
        ';
    }
}

    //edit item/ product
    if(isset($_POST['editproduct'])){
        $productname    = $_POST['productname'];
        $description    = $_POST['description'];
        $price          = $_POST['price'];
        $idp            = $_POST['idp']; //idproduct

        $query          = mysqli_query($conn,"update product set productname='$productname', description='$description', price='$price' where idproduct='$idp'");
        
        if($query){
            header('location:stock.php');
        }else{
            echo '
            <script>alert("Failed!");
            window.location.href="stock.php   "
            </script>
            
            ';
        }
    }

    //delete item/prodcuct
    if(isset($_POST['deleteproduct'])){
        $idp    = $_POST['idp'];

        $query  = mysqli_query($conn,"delete from product where idproduct='$idp'");
         
        if($query){
            header('location:stock.php');
        }else{
            echo '
            <script>alert("Failed!");
            window.location.href="stock.php   "
            </script>
            
            ';
        }
    }

    //edit customer
    if(isset($_POST['editcustomer'])){
        $customername       = $_POST['customername'];
        $phonenumber        = $_POST['phonenumber'];
        $address            = $_POST['address'];
        $id                 = $_POST['idcst'];

        $query          = mysqli_query($conn,"update customer set customername='$customername', phonenumber='$phonenumber', address='$address' where idcustomer='$id'");
        
        if($query){
            header('location:customer.php');
        }else{
            echo '
            <script>alert("Failed!");
            window.location.href="customer.php   "
            </script>
            
            ';
        }

    }

    //delete customert
    if(isset($_POST['deletecustomer'])){
        $idcst    = $_POST['idcst'];

        $query  = mysqli_query($conn,"delete from customer where idcustomer='$idcst'");
         
        if($query){
            header('location:customer.php');
        }else{
            echo '
            <script>alert("Failed!");
            window.location.href="customer.php   "
            </script>
            
            ';
        }
    }

    //editing new product data
    if(isset($_POST['editnewproductdata'])){
       $qty     = $_POST['qty'];
       $idnp    = $_POST['idnp'];   // id new product
       $idp     = $_POST['idp']; //idproduct

        //check current qty
        $searchqty      = mysqli_query($conn,"select * from newproduct where idnewproduct='$idnp'");
        $searchqty2     = mysqli_fetch_array($searchqty);
        $currentqty     = $searchqty2['qty'];

        //check current stock
        $searchstock         = mysqli_query($conn,"select * from product where idproduct='$idp'");
        $searchstock2        = mysqli_fetch_array($searchstock);
        $currentstock       = $searchstock2['stock'];
        
        if($qty >= $currentqty){
            //if user input greater than currentqty
            //count the difference
            $difference     = $qty-$currentqty;
            $newstock       = $currentstock+$difference;

            $query1          = mysqli_query($conn,"update newproduct set qty='$qty' where idnewproduct='$idnp'");
            $query2          = mysqli_query($conn,"update product set stock='$newstock' where idproduct='$idp'");
        
            if($query1&&$query2){
                header('location:newitem.php');
            }else{
                echo '
                <script>alert("Failed!");
                window.location.href="newitem.php   "
                </script>
                
                ';
            }

        }else{
            //if user input smaller
            //count the difference
            $difference     = $currentqty-$qty;
            $newstock       = $currentstock-$difference;

            $query1          = mysqli_query($conn,"update newproduct set qty='$qty' where idnewproduct='$idnp'");
            $query2          = mysqli_query($conn,"update product set stock='$newstock' where idproduct='$idp'");
        
            if($query1&&$query2){
                header('location:newitem.php');
            }else{
                echo '
                <script>alert("Failed!");
                window.location.href="newitem.php   "
                </script>
                
                ';
            }
        }
        
    }




    //delete new item data  
    if(isset($_POST['deletenewproductdata'])){
        $idnp     = $_POST['idnp'];
        $idp      = $_POST['idp'];

         //check current qty
         $searchqty      = mysqli_query($conn,"select * from newproduct where idnewproduct='$idnp'");
         $searchqty2     = mysqli_fetch_array($searchqty);
         $currentqty     = $searchqty2['qty'];
 
         //check current stock
         $checkstock         = mysqli_query($conn,"select * from product where idproduct='$idp'");
         $checkstock2        = mysqli_fetch_array($checkstock);
         $currentstock       = $checkstock2['stock'];

            //count the difference
            $newstock       = $currentstock-$currentqty;

            $query1          = mysqli_query($conn,"delete from newproduct  where idnewproduct='$idnp'");
            $query2          = mysqli_query($conn,"update product set stock='$newstock' where idproduct='$idp'");
        
            if($query1&&$query2){
                header('location:newitem.php');
            }else{
                echo '
                <script>alert("Failed!");
                window.location.href="newitem.php   "
                </script>
                ';
                }

    }


    //delete order
    if(isset($_POST['deleteorder'])){
        $ido    = $_POST['ido'];

        $checkdata      = mysqli_query($conn,"select * from orderdetail od where idorder='$ido'");

        while($ok=mysqli_fetch_array($checkdata)){
            //getback the stock
            $qty        = $ok['qty'];
            $idproduct  = $ok['idproduct'];
            $idod       = $ok['idorderdetail'];

             //check current stock
                $checkstock         = mysqli_query($conn,"select * from product where idproduct='$idproduct'");
                $checkstock2        = mysqli_fetch_array($checkstock);
                $currentstock       = $checkstock2['stock'];

                $newstock           = $currentstock + $qty;

                $queryupdate        = mysqli_query($conn,"update product set stock='$stock' where idproduct = '$idproduct'");

            //delete data
                $querydelete        = mysqli_query($conn,"delete from orderdetail where idorderdetail ='$idod'");


        }

        $query  = mysqli_query($conn,"delete from orders where idorder='$ido'");
         
        if($queryupdate && $querydelete && $query){
            header('location:index.php');
        }else{
            echo '
            <script>alert("Berhasil Hore!");
            window.location.href="index.php   "
            </script>
            
            ';
        }
    }


     //editing orderdetail
     if(isset($_POST['editorderdetail'])){
        $qty     = $_POST['qty'];
        $idod    = $_POST['idod'];   // id new product
        $idpr    = $_POST['idpr']; //idproduct
        $idp     = $_POST['idp'];
 
         //check current qty
         $searchqty      = mysqli_query($conn,"select * from orderdetail where idorderdetail='$idod'");
         $searchqty2     = mysqli_fetch_array($searchqty);
         $currentqty     = $searchqty2['qty'];
 
         //check current stock
         $searchstock         = mysqli_query($conn,"select * from product where idproduct='$idpr'");
         $searchstock2        = mysqli_fetch_array($searchstock);
         $currentstock       = $searchstock2['stock'];
         
         if($qty >= $currentqty){
             //if user input greater than currentqty
             //count the difference
             $difference     = $qty-$currentqty;
             $newstock       = $currentstock-$difference;
 
             $query1          = mysqli_query($conn,"update orderdetail set qty='$qty' where idorderdetail='$idod'");
             $query2          = mysqli_query($conn,"update product set stock='$newstock' where idproduct='$idpr'");
         
             if($query1&&$query2){
                 header('location:view.php?idp='.$idp);
             }else{
                 echo '
                 <script>alert("Failed!");
                 window.location.href="view.php?idp="'.$idp.'"
                 </script>
                 
                 ';
             }
 
         }else{
             //if user input smaller
             //count the difference
             $difference     = $currentqty-$qty;
             $newstock       = $currentstock+$difference;
 
             $query1          = mysqli_query($conn,"update orderdetail set qty='$qty' where idorderdetail='$idod'");
             $query2          = mysqli_query($conn,"update product set stock='$newstock' where idproduct='$idpr'");
         
             if($query1&&$query2){
                 header('location:view.php?idp='.$idp);
             }else{
                 echo '
                 <script>alert("Failed!");
                 window.location.href="view.php?idp='.$idp.'"
                 </script>
                 
                 ';
             }
         }
         
     }

     //edituser
     if(isset($_POST['edituser'])){
        $iduser = $_POST['iduser']; //iduser
        $username   = $_POST['username'];
        $password   = $_POST['password'];
        $role       = $_POST['role'];

        $query = mysqli_query($conn,"UPDATE user set username='$username', us_pass='$password', us_role='$role' where id_user='$iduser'");

        if($query)
        {
            header('location:manageuser.php');
        }else{
            echo'
            <script>alert("Failed!");
            window.location.href="manageuser.php   "
            </script>
            
            ';

        }
     }

     if(isset($_POST['deleteuser'])){
        $iduser =$_POST['iduser'];

        $query = mysqli_query($conn,"delete from user where id_user = '$iduser'");
        if($query){
            header('location: manageuser.php');
        }else{
            echo '
            <script>alert("FAILED!");
            window.location.href="manageuser.php"
            </script>';
        }
     }

    ?>