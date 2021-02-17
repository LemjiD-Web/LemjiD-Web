<!DOCTYPE html>
<html lang="en">
<?php

    include_once '../config/database.php';
    include_once '../class/products.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Products($db);
    $data = $items->getProducts();


    $category = new Products($db);
    $categorys = $category->getCategory();

    $imgurl = new Products($db);
    $imgurls = $imgurl->getImageUrl();

?>             
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Shop Homepage - Start Bootstrap Template</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/shop-homepage.css" rel="stylesheet">
<style type="text/css">
/* For this page only */
body { font-family:Arial, Helvetica, sans-serif; font-size:13px; }
.wrap { text-align:center; line-height:21px; padding:20px; }

/* For pagination function. */
ul.pagination {
    text-align:center;
    color:#829994;
}
ul.pagination li {
    display:inline;
    padding:0 3px;
}
ul.pagination a {
    color:#0d7963;
    display:inline-block;
    padding:5px 10px;
    border:1px solid #cde0dc;
    text-decoration:none;
}
ul.pagination a:hover,
ul.pagination a.current {
    background:#0d7963;
    color:#fff;
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
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">
        <h1 class="my-4">Shop Name</h1>
        <div class="list-group">
		<?php
			while ($category = $categorys->fetch(PDO::FETCH_ASSOC)){
			   $category=$category['category'];
             echo'<a href="#" class="list-group-item">'.$category.'</a>';
			}  
		?>

        </div>

      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-9">

        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner" role="listbox">
            <?php
			while ($imgurl = $imgurls->fetch(PDO::FETCH_ASSOC)){
			   $imgurl=$imgurl['imageUrl'];
             ?>
            <div class="carousel-item active">
            <?php echo'<img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Second slide">'; ?>
              <!-- src='.$imgurl.' -->
            </div>
           <?php }  ?>  
          </div>

          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
	<?php 

	$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
	if ($page <= 0) $page = 1;

	$per_page = 12; // Set how many records do you want to display per page.

	$startpoint = ($page * $per_page) - $per_page;

	$statement = "`products` ORDER BY `id` ASC"; // Change `records` according to your table name.
    include('../api/connbase.php');
	$results = mysqli_query($conDB,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");

	?><div class="row">
	<?php
		if (mysqli_num_rows($results) != 0) {		
			// displaying records.
			while ($row = mysqli_fetch_array($results)) {
				// echo $row['id'] . '<br>';
				$productName=$row['productName'];
				$price=$row['price'];
				$description=$row['description'];
				$avg_score=$row['avg_score'];
				$id=$row['reviews'];
			 ?>
			  <div class="col-lg-4 col-md-6 mb-4">
				<div class="card h-100">
				  <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
				  <div class="card-body">
					<h4 class="card-title">
					  <a href="#"><?php echo $productName; ?></a>
					</h4>
					<h5>$ <?php echo $price; ?></h5>
					<p class="card-text"><?php echo $description; ?></p>
				  </div>
				  <div class="card-footer">
					<small class="text-muted"><?php echo $avg_score; ?>&#9733;</small><?php //echo $id; ?>
				  </div>
				</div>
			  </div>
			<?php }  ?> 

	<?php
		} else {
			 echo "No records are found.";
		}
	?>
	</div>
	<?php
	 // displaying paginaiton.
		$ss = new Products($db);
	   echo  $rr = $ss->pagination($statement,$per_page,$page,$url='?');
	?>
      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

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
