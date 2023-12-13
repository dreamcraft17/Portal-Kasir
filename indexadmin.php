<?php
require 'logincheck.php';


if(isset($_GET['op'])){
    $op = $_GET['op'];
} else {
    $op="";
}
if($op=='delete'){
    
}


//count amount of order
$h1=mysqli_query($conn,"select * from orders ");
$h2=mysqli_num_rows($h1); //amount of order
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Order Data</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
       
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
         <!-- Navbar Brand-->
         <a class="navbar-brand ps-3" href="indexadmin.php">Cashier Application</a>

    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="indexadmin.php">
                            <div class="sb-nav-link-icon"><i class="far fa-clipboard"></i></div>
                            Order
                        </a>
                        <a class="nav-link" href="stockadmin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
                            Stock
                        </a>
                        <a class="nav-link" href="newitemadmin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-dolly-flatbed"></i></div>
                            New Item
                        </a>
                        <a class="nav-link" href="customeradmin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-dolly-flatbed"></i></div>
                            Manage Customer
                        </a>
                        
                        <a class="nav-link" href="register.php">
                            Register
                        </a>

                        <a class="nav-link" href="manageuser.php">
                            Manage User
                        </a>

                        <a class="nav-link" href="logout.php">
                            Logout
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">
                        <?php
                        // Starting session
                       
                        
                        // Displaying username if logged in
                        if (isset($_SESSION['login']) && $_SESSION['login'] == 'TRUE' && isset($_SESSION['username'])) {
                            echo 'Logged in as : ' . htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
                        }
                        ?>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Order Data</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"> Welcome to this page!</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Jumlah Pesanan : <?=$h2;?></div>
                            </div>
                        </div>

                    </div>

                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-warning mb-4 ml-1" data-toggle="modal" data-target="#myModal">
                        Add new Order
                    </button>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Order Data
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Order Id</th>
                                        <th>Date</th>
                                        <th>Customer Name</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ambil    = mysqli_query($conn, "SELECT * from orders p, customer cst where p.idcustomer=cst.idcustomer");
                                    // $ambil = mysqli_query($conn,"SELECT * from orders p, customer cst where p.idcustomer=cst.idcustomer");
                                    if (!$ambil) {
                                        die("Query failed: " . mysqli_error($conn));
                                    }
                                    while ($p = mysqli_fetch_array($ambil)) {
                                        $idorder         = $p['idorder'];
                                        $date            = $p['date'];
                                        $customername    = $p['customername'];
                                        $address         = $p['address'];  
                                        // $price          = $p['price'];
                                        // $stock          = $p['stock'];

                                        //count the amount
                                        $countammount = mysqli_query($conn,"select * from orderdetail where idorder='$idorder'");
                                        $ammount      = mysqli_num_rows($countammount);


                                    ?>
                                        <tr>
                                            <td><?= $idorder; ?></td>
                                            <td><?= $date; ?></td>
                                            <td><?= $customername; ?> - <?=$address;?></td>
                                            <td><?= $ammount; ?></td>
                                            <td>
                                                <a href="view.php?idp=<?=$idorder;?>" class="btn  btn-primary" target="blank">View Order</a> 
                                                <button type="button" class="btn btn-danger  " data-toggle="modal" data-target="#delete<?=$idorder;?>">
                                                        Delete
                                                </button>
                                            </td>
                                        </tr>

                                         <!-- modal delete -->
                                     <div class="modal fade" id="delete<?=$idorder;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Delete Order Data</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <form method="post">

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        Are you sure want to delete this order data?
                                                        <input type="hidden" name="ido" value="<?=$idorder;?>">
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success" name="deleteorder">Submit</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    }; //end of while

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <!-- <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div> -->
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

<!-- The Modal -->
<div class="modal fade" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Add new Order</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <form method="post">

                            <!-- Modal body -->
                            <div class="modal-body">
                                Choose Customer
                                <select name="idcustomer" class="form-control">

                                  <?php
                                  $getcustomer  = mysqli_query($conn," select *from customer");

                                  while ($cst = mysqli_fetch_array($getcustomer)){
                                    $customername   = $cst['customername'];
                                    $idcustomer     = $cst['idcustomer'];
                                    $address        = $cst['address'];
                                  
                                  ?>
                                  <option value="<?=$idcustomer;?>"><?=$customername;?> - <?=$address;?></option>
                                  <?php
                                  }
                                  ?>

                                </select>
                                <!-- <input type="text" name="productname" class="form-control" placeholder="Product Name">
                                <input type="text" name="description" class="form-control mt-3" placeholder="Description">
                                <input type="num" name="price" class="form-control mt-3" placeholder="Product Price">
                                <input type="num" name="stock" class="form-control mt-3" placeholder="Initial Stock"> -->
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="neworder">Submit</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>

                            </form>
                        </div>
                    </div>
                </div>

</html>