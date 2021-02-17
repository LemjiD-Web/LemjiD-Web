<!DOCTYPE html>
<html lang="en">
<?php

    include_once '../config/database.php';
    include_once '../class/products.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Products($db);
    $datas = $items->getProductsDetails();


    $category = new Products($db);
    $categorys = $category->getCategory();

?> 
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Shop Item - Start Bootstrap Template</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/shop-item.css" rel="stylesheet">


<!-- POUR TESTER LE SYSTEM DE MISE EN CACHE  -->
<style rel="stylesheet">
	#time{
		 position :fixed;
		 top:40%;
		 white:100%;
		 background :black;
		 color: white;
		 padding :10px;
		 font-family: arial;
	}
</style>
</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Start Bootstrap</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav></br></br>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">
        <h1 class="my-4">Shop Name</h1>
        <div class="list-group"> 
		<?php
		// SYSTEM DE MISE EN CACHE 
			$data ='';
			$start = microtime(true);
			$cache ="cache/file.cache.php";

			 if (file_exists($cache)){
				 //echo "Cache File Found <br>";
				   include $cache;
			 }else {
				 
				 // echo "Cache does not exist<br>";
				while ($row = $categorys->fetch(PDO::FETCH_ASSOC)){
						$data .='<a href="#" class="list-group-item">';
						$data .= $row["category"];
						$data .='</a>';
						} 
			  $handler = fopen($cache, 'w');
			  fwrite($handler,$data);
			  fclose($handler);
			}
			$end= microtime(true);
			$time =round (($end-$start),5); ?>
		    <?php echo $data; ?>
	<!-- 	<div id="time"> La page a pris (<?php  //echo $time; ?> ) secondes pour charger !</div> -->
        </div>
      </div>
      <!-- /.col-lg-3 -->
    <?php while ($row = $datas->fetch(PDO::FETCH_ASSOC)){ 
	   			$productName=$row['productName'];
				$price=$row['price'];
				$description=$row['description'];
				$avg_score=$row['avg_score'];
				$reviews=$row['reviews'];
                $date=$row['createdAt']; 
				$dateformat =date("d/m/Y", strtotime($date));?>
      <div class="col-lg-9">

        <div class="card mt-4">
          <img class="card-img-top img-fluid" src="http://placehold.it/900x400" alt="">
          <div class="card-body">
            <h3 class="card-title"><?php echo $productName; ?></h3>
            <h4>$<?php echo $price; ?></h4>
            <p class="card-text"><?php echo $productName; ?></p>
            <span class="text-warning"> <?php echo $avg_score; ?> &#9733; </span> stars
          </div>
        </div>
        <!-- /.card -->

        <div class="card card-outline-secondary my-4">
          <div class="card-header">
            Product Reviews
          </div>
          <div class="card-body"> <?php 
		  // echo $reviews; 
		     $obj = json_decode($reviews ,true);
			 foreach ($obj as $key => $value) {			
			 echo "Content : " .$value["content"]."<br><br>";
			 echo "Rating : " .$value["rating"]." ★ <br><br>";
			 echo "<small class='text-muted'>Posted by Anonymous on " .$dateformat." </small>
            <hr>";
			 }
				 ?>
            <a href="#" class="btn btn-success">Leave a Review</a>
          </div>
        </div>
        <!-- /.card -->

      </div>
	<?php } ?>
      <!-- /.col-lg-9 -->

    </div>

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2020</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
