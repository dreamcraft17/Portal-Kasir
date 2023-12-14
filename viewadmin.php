<?php
require 'logincheck.php';

if (isset($_GET['idp'])) {
    $idp = $_GET['idp'];

    $takecustomername   = mysqli_query($conn, "select * from orders p, customer cust where p.idcustomer = cust.idcustomer and p.idorder ='$idp'");
    $np                 = mysqli_fetch_assoc($takecustomername);
    $custname           = $np['customername'];
} else {
    header('location:index.php');
}
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
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">Portal Kasir</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

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
                    <h1 class="mt-4">Order Data : <?= $idp ?></h1>
                    <h4 class="mt-4">Customer Name : <?= $custname ?></h4>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"> Welcome to this page!</li>
                    </ol>


                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-success mb-4 ml-1" data-toggle="modal" data-target="#myModal">
                        Add Item
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
                                        <th>No</th>
                                        <th>Product Name</th>
                                        <th>Price </th>
                                        <th>Amount</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ambil    = mysqli_query($conn, "select * from orderdetail p, product pr where p.idproduct=pr.idproduct and p.idorder = '$idp'");
                                    $i = 1;

                                    while ($p = mysqli_fetch_array($ambil)) {
                                        $idpr             = $p['idproduct'];
                                        $idorderdetail    =$p['idorderdetail'];
                                        $qty              = $p['qty'];
                                        $price            = $p['price'];
                                        $productname      = $p['productname'];
                                        $desc             =$p['description'];
                                        $subtotal         = $qty * $price;
                                        // $address             = $p['address'];  
                                        // $price          = $p['price'];
                                        // $stock          = $p['stock'];


                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $productname; ?> ( <?= $desc;?> )</td>
                                            <td>Rp <?= number_format($price); ?> </td>
                                            <td><?= number_format($qty); ?></td>
                                            <td>Rp <?= number_format($subtotal); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning  " data-toggle="modal" data-target="#edit<?=$idpr;?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idpr; ?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                         <!-- modal edit -->
                                  <div class="modal fade" id="edit<?=$idpr;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Order Detail Data</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <form method="post">

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <input type="text" name="productname" class="form-control" placeholder="Product Name" value="<?=$productname;?> : <?=$desc;?>" disabled>
                                                        <input type="number" name="qty" class="form-control mt-3" placeholder="Product Price" value="<?= $qty; ?>">
                                                        <input type="hidden" name="idod" value="<?=$idorderdetail;?>">
                                                        <input type="hidden" name="idp" value="<?=$idp;?>">
                                                        <input type="hidden" name="idpr" value="<?=$idpr;?>">
                                                        
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success" name="editorderdetail">Submit</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                        <!-- modal delete -->
                                        <div class="modal fade" id="delete<?= $idpr; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Are you sure to delete the item?</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <form method="post">

                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                        Are you sure to delete the item?
                                                            <input type="hidden" name="idp" value="<?= $idorderdetail; ?>">
                                                            <input type="hidden" name="idpr" value="<?= $idpr; ?>">
                                                            <input type="hidden" name="idorder" value="<?= $idp; ?>">
                                                            <!-- <input type="text" name="productname" class="form-control" placeholder="Product Name">
                                                            <input type="text" name="description" class="form-control mt-3" placeholder="Description">
                                                            <input type="num" name="price" class="form-control mt-3" placeholder="Product Price">
                                                            <input type="num" name="stock" class="form-control mt-3" placeholder="Initial Stock"> -->
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="deleteproduct">Yes</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
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
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
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
                <h4 class="modal-title">Add new Item</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form method="post">

                <!-- Modal body -->
                <div class="modal-body">
                    Choose Item
                    <select name="idproduct" class="form-control">

                        <?php
                        $getproduct = mysqli_query($conn, " select * from product where idproduct not in (select idproduct from orderdetail where idorder='$idp')");

                        while ($cst = mysqli_fetch_array($getproduct)) {
                            $productname    = $cst['productname'];
                            $stock          = $cst['stock'];
                            $description    = $cst['description'];
                            $idproduct      = $cst['idproduct'];

                        ?>
                            <option value="<?= $idproduct; ?>"><?= $productname; ?> - <?= $description; ?> (Stock : <?= $stock; ?>)</option>
                        <?php
                        }
                        ?>

                    </select>

                    <input type="number" name="qty" class="form-control mt-4" placeholder="Jumlah " min="1" required>
                    <input type="hidden" name="idp" value="<?= $idp; ?>">
                    <!-- <input type="text" name="productname" class="form-control" placeholder="Product Name">
                                <input type="text" name="description" class="form-control mt-3" placeholder="Description">
                                <input type="num" name="price" class="form-control mt-3" placeholder="Product Price">
                                <input type="num" name="stock" class="form-control mt-3" placeholder="Initial Stock"> -->
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="addproduct">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </form>
        </div>
    </div>
</div>

</html>