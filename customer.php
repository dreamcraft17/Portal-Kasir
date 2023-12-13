<?php

require 'logincheck.php';
if (isset($_POST['kirim_pesan'])) {
    $nomorPengirim = '081269071846'; // Nomor WhatsApp pengirim tetap
    $pesan = 'Halo'; // Pesan default

    // Mengekstrak nomor penerima dari form
    $nomorPenerima = $_POST['phonenumber'];

    // Membuat URL untuk mengirim pesan WhatsApp
    $urlWhatsApp = "https://wa.me/$nomorPenerima/?text=" . urlencode($pesan) . "&source=$nomorPengirim";

    // Redirect ke URL WhatsApp untuk memulai obrolan
    header("Location: $urlWhatsApp");
    exit;
}
//count amount of Customer
$h1=mysqli_query($conn,"select * from customer ");
$h2=mysqli_num_rows($h1); //amount of customer

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" /> 
    <meta name="author" content="" />
    <title>Customer Data</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    /* Ganti warna tombol dan tampilan input sesuai dengan kebutuhan Anda */
    .whatsapp-form {
        display: inline-block;
    }

    .phonenumber-input {
        width: 100px;
    }

    .kirim-pesan-button {
        background-color: #25d366;
        color: #fff;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }
</style>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">Cashier Application</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="far fa-clipboard"></i></div>
                            Order
                        </a>
                        <a class="nav-link" href="stock.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
                            Stock
                        </a>
                        <a class="nav-link" href="newitem.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-dolly-flatbed"></i></div>
                            New Item
                        </a>
                        <a class="nav-link" href="customer.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-dolly-flatbed"></i></div>
                            Manage Customer
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
                    <h1 class="mt-4">Customer Data</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"> Welcome to this page!</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Customer amount: <?=$h2?></div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-warning mb-4 ml-4" data-toggle="modal" data-target="#myModal">
                    Add Customer
                </button>

                <!-- The Modal -->
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Add Customer Data</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <form method="post">

                            <!-- Modal body -->
                            <div class="modal-body">
                                <input type="text" name="customername" class="form-control" placeholder="Customer Name">
                                <input type="text" name="phonenumber"  class="form-control mt-3" placeholder="Phone Number">
                                <input type="text" name="address" class="form-control mt-3" placeholder="Address">
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="newcustomer">Submit</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Customer Data
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Customer Name</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                            $ambil    = mysqli_query($conn,"select * from customer");
                            $i         = 1;
                            while($p=mysqli_fetch_array($ambil)){
                            $customername       = $p['customername'];
                            $phonenumber        = $p['phonenumber'];
                            $address            = $p['address'];
                            $idcst              = $p['idcustomer'];
                           

                            ?>
                                <tr>
                                    <td><?=$i++;?></td>
                                    <td><?=$customername;?></td>
                                    <td><?=$phonenumber;?></td>
                                    <td><?=$address;?></td>
                                    <td>
                                                <button type="button" class="btn btn-warning  " data-toggle="modal" data-target="#edit<?=$idcst;?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger  " data-toggle="modal" data-target="#delete<?=$idcst;?>">
                                                    Delete
                                                </button>
                                                <form method="post" class="whatsapp-form">
                                                    <label for="phonenumber">Nomor WhatsApp:</label>
                                                    <input type="text" class="phonenumber-input" name="phonenumber" placeholder="6281234567890" required>
                                                    <input type="submit" name="kirim_pesan" value="Kirim Pesan WhatsApp" class="kirim-pesan-button">
                                                </form>
                                                
                                              
                                        </td>
                                </tr>

                                 <!-- modal edit -->
                                 <div class="modal fade" id="edit<?=$idcst;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit <?= $customername; ?></h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <form method="post">

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <input type="text" name="customername" class="form-control" placeholder="Customer Name" value="<?= $customername; ?>">
                                                        <input type="text" name="phonenumber" class="form-control mt-3" placeholder="Phone Number" value="<?= $phonenumber; ?>">
                                                        <input type="text" name="address" class="form-control mt-3" placeholder="Address" value="<?= $address; ?>">
                                                        <input type="hidden" name="idcst" value="<?=$idcst;?>">
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success" name="editcustomer">Submit</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                     <!-- modal delete -->
                                     <div class="modal fade" id="delete<?=$idcst ;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Delete <?= $customername; ?></h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <form method="post">

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        Are you sure want to delete the customer?
                                                        <input type="hidden" name="idcst" value="<?=$idcst;?>">
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success" name="deletecustomer">Submit</button>
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




</html>