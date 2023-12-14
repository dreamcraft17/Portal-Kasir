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
    <script src="path/to/qrcode-generator.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
                    <h1 class="mt-4">Order Data : <?= $idp ?></h1>
                    <h4 class="mt-4">Customer Name : <?= $custname ?></h4>
                    <!-- <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"> Welcome to this page!</li>
                    </ol> -->


                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-success mb-4 ml-1" data-toggle="modal" data-target="#myModal">
                        Add Item
                    </button>
                    <button class="btn btn-primary mb-4 ml-1" data-toggle="modal" data-target="#inimodal" onclick="loadDynamicContent()" >
                    <!-- style="position: absolute; right:9%; transform: translateX(50%); margin-top: 3px;" -->
                        Send Bill
                    </button>
                    <button type="button" class="btn btn-primary mb-4 ml-1" data-toggle="modal" data-target="#qrisModal">
                        Open QR Code Modal
                    </button>


                    <div class="modal fade" id="inimodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="inimodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                // Your existing PHP code to retrieve order details
                $ambil = mysqli_query($conn, "select * from orderdetail p, product pr where p.idproduct=pr.idproduct and p.idorder = '$idp'");
                $i = 1;
                $totalAmount = 0;
                ?>

                <!-- Nested table for order details -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Amount</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($p = mysqli_fetch_array($ambil)) {
                            $qty = $p['qty'];
                            $price = $p['price'];
                            $productname = $p['productname'];
                            $desc = $p['description'];
                            $subtotal = $qty * $price;
                            $totalAmount += $subtotal;
                            ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $productname; ?> ( <?= $desc; ?> )</td>
                                <td>Rp <?= number_format($price); ?> </td>
                                <td><?= number_format($qty); ?></td>
                                <td>Rp <?= number_format($subtotal); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- Display total amount -->
                <h4>Total Amount: Rp <?= number_format($totalAmount); ?></h4>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="sendWhatsApp()">Send Bill</button>
        </div>
        </div>
    </div>
</div>
<script>
    // Function to load dynamic content into the modal
    function loadDynamicContent() {
        // You can add additional logic here if needed
    }

    // Function to calculate and display total amount
    function calculateTotalAmount() {
        let totalAmount = 0;
        // Your existing logic to calculate total amount...

        // Display total amount in the modal
        document.getElementById('totalAmountDisplay').innerText = totalAmount.toLocaleString();
    }

    // Function to send WhatsApp message
    // Function to send WhatsApp message
// Function to send WhatsApp message
function sendWhatsApp() {
    // You need to replace '123456789' with the actual phone number
    let phoneNumber = prompt('Enter the phone number (with country code) to send the bill:', '6281269071846');
    if (phoneNumber) {
        // Construct the message with list content
        let message = 'Your order details:\n\n';

        // Loop through table rows and append details to the message
        let tableRows = document.querySelectorAll('#inimodal tbody tr');
        tableRows.forEach((row) => {
            let columns = row.querySelectorAll('td');
            let productName = columns[1].innerText;
            let price = columns[2].innerText;
            let qty = columns[3].innerText;
            let subtotal = columns[4].innerText;

            // Append product details to the message as a list item
            message += `- ${productName} (${qty} pcs)\n  Price: ${price}\n  Subtotal: ${subtotal}\n`;
        });

        // Append total amount to the message
        let totalAmount = document.querySelector('#inimodal .modal-body h4').innerText;
        message += `\n ${totalAmount}`;

        // Create a WhatsApp link
        let whatsappLink = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;

        // Open WhatsApp in a new window/tab
        window.open(whatsappLink, '_blank');
    }
}


    // Call the calculateTotalAmount function when the modal is shown
    $('#inimodal').on('shown.bs.modal', function () {
        calculateTotalAmount();
    });
</script>

  <!-- Modal -->
  <div class="modal fade" id="qrisModal" tabindex="-1" role="dialog" aria-labelledby="qrisModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrisModalLabel">QR Code Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Container to display QR Code -->
                    <div id="qrcode-container"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to generate QR Code for payment
        function generateQRCode() {
            // URL for QR Code API
            const apiUrl = 'https://qris.online/restapi/qris/show_qris.php';

            // Replace '081269071846' with your actual GOPAY account number
            const gopayAccountNumber = '081269071846';

            // Construct the API URL with the required parameters
            const apiEndpoint = `${apiUrl}?account_number=${gopayAccountNumber}`;

            // Fetch data from API
            fetch(apiEndpoint)
                .then(response => response.text())
                .then(qrCodeData => {
                    // Append the QR Code to the modal container
                    document.getElementById('qrcode-container').innerHTML = qrCodeData;
                })
                .catch(error => {
                    console.error('Error fetching QR Code data:', error);
                });
        }

        // Call the function to generate QR Code when the modal is shown
        $('#qrisModal').on('shown.bs.modal', function () {
            generateQRCode();
        });
    </script>

    <!-- Bootstrap JS (required for modal functionality) -->
   


                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Order Data
                        </div>
                        <div id="qrcode-container"></div>
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
                                                <form method="post" class="whatsapp-form">
           
       
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
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