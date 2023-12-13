<?php require 'config/functions.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS MANAGEMENT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
   <div class="py-5 bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow rounded-4">
                    <?php alertMessage();  ?>
                    <div class="p-5">
                        <h4 class="text-dark mb-3">Customer Login</h4>
                        <form action="customer_login_code.php" method="POST">
                        <div class="mb-3">
                            <label for="">Enter Your Phone Number *</label>
                            <input type="number" name="phone" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="optional" />
                        </div>
                        <div class="my-3">
                            <button type="submit" name="customer_loginBtn" class="btn btn-primary w-100 mt-2">
                                Login
                            </button>
                        </div>

                        </form>
                    </div>

                </div>
            
            </div>
        </div>
    </div>
   </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <?php 
  include('includes/footer.php');
  ?>