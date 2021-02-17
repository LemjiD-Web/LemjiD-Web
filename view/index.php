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
	
	
	$cat = new Products($db);
    $catys = $cat->getCategory();
	
	define("ROW_PER_PAGE",99); // Nombre de Produits par page

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
#keyword {
    border: #CCC 1px solid;
    border-radius: 4px;
    padding: 7px;
    background: url("css/demo-search-icon.png") no-repeat center right 7px;
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
	$search_keyword = '';
	if(!empty($_POST['search']['keyword'])) {
		$search_keyword = $_POST['search']['keyword'];
	}
	$sql = 'SELECT * FROM products WHERE productName LIKE :keyword OR price like :keyword  ORDER BY id DESC ';
	
	/* Pagination Code starts */
	$per_page_html = '';
	$page = 1;
	$start=0;
	if(!empty($_POST["page"])) {
		$page = $_POST["page"];
		$start=($page-1) * ROW_PER_PAGE;
	}
	$limit=" limit " . $start . "," . ROW_PER_PAGE;
	$database_username = 'root';
	$database_password = '';
	$pdo_conn = new PDO( 'mysql:host=localhost;dbname=application', $database_username, $database_password );
	$pagination_statement = $pdo_conn->prepare($sql);
	$pagination_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
	$pagination_statement->execute();

	$row_count = $pagination_statement->rowCount();
	if(!empty($row_count)){
		$per_page_html .= "<div style='text-align:center;margin:20px 0px;'>";
		$page_count=ceil($row_count/ROW_PER_PAGE);
		if($page_count>1) {
			for($i=1;$i<=$page_count;$i++){
				if($i==$page){
					$per_page_html .= '<input type="submit" name="page" value="' . $i . '" style="background:#F0F0F0;border:#CCC 1px solid; border-radius:4px;cursor:pointer;height: 30px;width: 30px;margin-bottom: 3px;margin-right: 3px;" />';
				} else {
					$per_page_html .= '<input type="submit" name="page" value="' . $i . '" style="margin-right:10px;height: 30px;width: 30px;margin-bottom: 3px;margin-right: 3px; border:#CCC 1px solid; background:#FFF;border-radius:4px;cursor:pointer;"/>';
				}
			}
		}
		$per_page_html .= "</div>";
	}
	
	$query = $sql.$limit;
	$pdo_statement = $pdo_conn->prepare($query);
	$pdo_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();

	?>
	<form method="get" action="index.php" class="form-inline" style="float:left;">
		<select name="category" onchange="submit()" class="form-control" >
				<option>Choisir...</option>
				<?php 
					while ($crow = $catys->fetch(PDO::FETCH_ASSOC)){
						echo "<option";	   
						 if(isset($_REQUEST['category']) and $_REQUEST['category']==$crow['category']) echo ' selected="selected"';
						echo ">{$crow['category']}</option>\n";
					} 
				?>
	    </select>
    </form>
	<form name='frmSearch' action='' method='post'>
		<div style='text-align:right;margin:20px 0px;'>
		<input type='text' name='search[keyword]' placeholder="Recherche Par Nom" value="<?php echo $search_keyword; ?>" id='keyword' maxlength='25'>
	</div>
	</form>
	<div class="row">
	<?php
		if ((isset($_GET['category'])) && ($_GET['category'] <> "")) {
			$category = $_GET['category'];
		$bdd = new PDO('mysql:host=localhost;dbname=application;charset=utf8', 'root', '');	
		$reponse = $bdd->query("SELECT * FROM products WHERE category='$category' ORDER BY productName");
		
		while ($donnees = $reponse->fetch()){
    ?> 
			  <div class="col-lg-4 col-md-6 mb-4">
				<div class="card h-100">
				  <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
				  <div class="card-body">
					<h4 class="card-title">
					  <a href="#"><?php echo $donnees['productName']; ?></a>
					</h4>
					<h5>$ <?php echo $donnees['price']; ?></h5>
					<p class="card-text"><?php echo $donnees['description']; ?></p>
				  </div>
				  <div class="card-footer">
					<small class="text-muted"><?php echo $donnees['avg_score']; ?>&#9733;</small><?php //echo $id; ?>
				  </div>
				</div>
			  </div>
	<?php //} } ?>
    </div>		
	
	<div class="row">
	<?php  // Recherche par Nom
			}} elseif(!empty($result)) { 
	        	foreach($result as $row) {	
				// echo $row['id'] . '<br>';
				$productName=$row['productName'];
				$price=$row['price'];
				$description=$row['description'];
				$avg_score=$row['avg_score'];
				$reviews=$row['reviews'];
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
			<?php }} else {
              echo "Pas de donnée!";
    }?> 
	</div>
	<?php   
	 // displaying paginaiton.
		echo $per_page_html;
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
