<?php
require 'function.php';
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register - Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-dark">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Create Account</h3>
                                </div>
                                <div class="card-body">

                                    <form method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="username" type="text" placeholder="Enter Username" required />
                                            <label for="inputEmail">username</label>
                                        </div>
                                        <!-- <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="email" type="text" placeholder="Enter Email" required />
                                            <label for="inputEmail">Email</label>
                                        </div> -->
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" required />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputname" name="name" type="text" placeholder="Enter Your Name" required />
                                            <label for="inputname">Name</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputemail" name="email" type="email" placeholder="Email" required/>
                                            <label for="inputemail">Email</label>
                                        </div>
                                        <!-- <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="alamat" type="text" placeholder="Enter Address" required />
                                            <label for="inputEmail">Address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="notelp" type="text" placeholder="Enter Username" required />
                                            <label for="inputEmail">Phone Number</label>
                                        </div> -->
                                        <!-- <div class="mt-4 mb-0">
                                            <div class="d-grid"><a class="btn btn-primary btn-block" href="login.php">Create Account</a></div>
                                        </div> -->
                                        <div class="d-flex justify-content-center mt-4 mb-0">
                                            <button type="submit" name="register" class="btn btn-primary">Create Account</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="indexadmin.php">Go Back</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>