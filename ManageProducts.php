<?php

session_start();

if(isset($_SESSION["adminSession"])){

   ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin|Manage Products</title>
   <link rel="icon" href="resources/images/Logo.png">
   <link rel="stylesheet" href="resources/css/bootstrap.css" />
    <link rel="stylesheet" href="resources/css/style.css" />
</head>

<body>

   <div class="container-fluid">
      <div class="row">
         <div class="col-12 text-center bg-dark">
            <h2 class="text-white">Manage Products</h2>
         </div>
         <div class="col-12">
            <div class="row">
               <div class="col-12 d-block d-md-none text-start">
                  <span>Filter</span><i class="bi bi-funnel" id="openFilter" style="cursor: pointer;"></i>
               </div>
               <div class="side-navigator">
                  <div class="row">
                     <div class="col-12 text-center">
                        <label class="form-label fw-bold fs-4">Filter</label>
                     </div>
                     <div class="col-12 d-block d-md-none text-end mb-3">
                        <i class="bi bi-x-lg" id="closeFilter" style="cursor: pointer;font-weight: bold;"></i>
                     </div>
                     <div class="col-12 mb-3 d-flex">
                        <input type="text" class="form-control" placeholder="Search...." id="searchInput">
                     </div>
                     <div class="col-12">
                        <h5>Filter By Price</h5>
                     </div>
                     <div class="col-12">
                        <label class="form-label">High To Low</label>
                        <input type="radio" name="price" id="priceLow">
                     </div>
                     <div class="col-12">
                        <label class="form-label">Low To High</label>
                        <input type="radio" name="price" id="priceHigh">
                     </div>
                     <div class="col-12">
                        <h5>Filter By Activity</h5>
                     </div>
                     <div class="col-12">
                        <label class="form-label">Active</label>
                        <input type="radio" name="activity" id="active">
                     </div>
                     <div class="col-12">
                        <label class="form-label">Deactive</label>
                        <input type="radio" name="activity" id="deactive">
                     </div>
                     <div class="col-12">
                        <h5>Filter By Condition</h5>
                     </div>
                     <div class="col-12">
                        <label class="form-label">New</label>
                        <input type="radio" name="condition" id="new">
                     </div>
                     <div class="col-12">
                        <label class="form-label">Used</label>
                        <input type="radio" name="condition" id="used">
                     </div>
                     <div class="col-12">
                        <h5>Filter By Stock</h5>
                     </div>
                     <div class="col-12">
                        <label class="form-label">Out of Stock</label>
                        <input type="radio" name="stock" id="instock">
                     </div>
                     <div class="col-12">
                        <label class="form-label">In Stock</label>
                        <input type="radio" name="stock" id="outofstock">
                     </div>
                     <div class="col-12 d-grid">
                        <button class="btn btn-primary" id="search">Search</button>
                     </div>
                     <div class="col-12 d-grid my-3">
                        <button class="btn btn-warning" id="clear">Clear</button>
                     </div>
                  </div>
               </div>
               <div class="col-md-9 p-3" >
                  <div class="row" id="productData">
                     <!-- data -->
                  </div>
               </div>
            </div>
         </div>

         

         <?php require "footer.php" ?>
      </div>
   </div>

   <script src="javascript/manageProducts.js"></script>
</body>

</html>
   <?php

}else{
   header("Location: adminLogin.php");
}





?>

