<!DOCTYPE html>
<?php 
	include 'conn.php';
	$limit = isset($_POST["limit-records"]) ? $_POST["limit-records"] : 2;
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$start = ($page - 1) * $limit;
	$result = $conn->query("SELECT * FROM customers LIMIT $start, $limit");
	$customers = $result->fetch_all(MYSQLI_ASSOC);

	$result1 = $conn->query("SELECT count(id) AS id FROM customers");
	$custCount = $result1->fetch_all(MYSQLI_ASSOC);
	$total = $custCount[0]['id'];
	$pages = ceil( $total / $limit );

	$Previous = $page - 1;
	$Next = $page + 1;

 ?>

<html>
<head>
	<title>Learn Web Coding > Pagination in PHP and MySQL </title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"/>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
	<div class="container well">
		<h1 class="text-center">Bootstrap Pagination in PHP and MySQL</h1>
		<div class="row">
			<div class="col-md-10">
				<nav aria-label="...">
					<ul class="pagination">
				    <li class="page-item disabled">
				      <a href="pangination.php?page=<?= $Previous; ?>"  aria-label="Previous">
				        <span  class="page-link aria-hidden="true">&laquo; </span>
				      </a>
				    </li>
				    <?php for($i = 1; $i<= $pages; $i++) : ?>
				    	<li><a class="page-link"  href="pangination.php?page=<?= $i; ?>"><?= $i; ?></a></li>
				    <?php endfor; ?>
				    <li>
				      <a href="pangination.php?page=<?= $Next; ?>" aria-label="Next">
				        <span class="page-link aria-hidden="true"> &raquo;</span>
				      </a>
				    </li>
				  </ul>
				</nav>
			</div>

			<div class="text-center" style="margin-top: 20px; " class="col-md-2">
				<form method="post" action="#">
						<select name="limit-records" id="limit-records">
							<option disabled="disabled" selected="selected">---Limit Records---</option>
							<?php foreach([10,100,500,1000,5000] as $limit): ?>
								<option <?php if( isset($_POST["limit-records"]) && $_POST["limit-records"] == $limit) echo "selected" ?> value="<?= $limit; ?>"><?= $limit; ?></option>
							<?php endforeach; ?>
						</select>
					</form>
				</div>
		</div>
		<div style="height: 600px; overflow-y: auto;">
			<table id="" class="table table-striped table-bordered">
	        	<thead>
	                <tr>
	                    <th>Id</th>
	                    <th>Name</th>
	                    <th>Mobile</th>
	                    <th>Address</th>
	                    <th>Date</th>
	              	</tr>
	          	</thead>
	        	<tbody>
	        		<?php foreach($customers as $customer) :  ?>
		        		<tr>
		        			<td><?= $customer['id']; ?></td>
		        			<td><?= $customer['name']; ?></td>
		        			<td><?= $customer['mobile']; ?></td>
		        			<td><?= $customer['address']; ?></td>
		        			<td><?= $customer['createdOn']; ?></td>
		        		</tr>
	        		<?php endforeach; ?>
	        	</tbody>
      		</table>
		</div>
</body>
</html>
