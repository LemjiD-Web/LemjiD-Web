<?php include_once('config.php'); include('paginator.class.php'); ?>
<!doctype html>
<html lang="en-US" xmlns:fb="https://www.facebook.com/2008/fbml" xmlns:addthis="https://www.addthis.com/help/api-spec"  prefix="og: http://ogp.me/ns#" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>PHP pagination class with Bootstrap 4</title>
	
	<link rel="shortcut icon" href="https://demo.learncodeweb.com/favicon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   
</head>

<body>
	
	<div class="container">
		<h1><a href="https://learncodeweb.com/php/php-pagination-class-with-bootstrap-4/">PHP pagination class with Bootstrap 4</a></h1>
    	<hr>
		<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>" class="form-inline">
			<select name="tb1" onchange="submit()" class="form-control">
				<option>Please select a continent</option>
				<?php
					$Continentqry   =   $db->query('SELECT DISTINCT continentName FROM countries ORDER BY continentName ASC');
					while($crow = $Continentqry->fetch_assoc()) {
						echo "<option";
						if(isset($_REQUEST['tb1']) and $_REQUEST['tb1']==$crow['continentName']) echo ' selected="selected"';
						echo ">{$crow['continentName']}</option>\n";
					}
				?>
			</select>
		</form>
		<hr>
		<?php
		if(isset($_REQUEST['tb1'])) {
			$condition		=	"";
			if(isset($_GET['tb1']) and $_GET['tb1']!="")
			{
				$condition		.=	" AND continentName='".$_GET['tb1']."'";
			}
			
			//Main query
			$pages = new Paginator;
			$pages->default_ipp = 15;
			$sql_forms = $db->query("SELECT * FROM countries WHERE 1 ".$condition."");
			$pages->items_total = $sql_forms->num_rows;
			$pages->mid_range = 9;
			$pages->paginate();	
			
			$result	=	$db->query("SELECT * FROM countries WHERE 1 ".$condition." ORDER BY countryName ASC ".$pages->limit."");
		}
		
		?>
		<div class="clearfix"></div>
		
		<div class="row marginTop">
			<div class="col-sm-12 paddingLeft pagerfwt">
				<?php if($pages->items_total > 0) { ?>
					<?php echo $pages->display_pages();?>
					<?php echo $pages->display_items_per_page();?>
					<?php echo $pages->display_jump_menu(); ?>
				<?php }?>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="clearfix"></div>
		
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Sr#</th>
					<th>Country Name</th>
					<th>ID</th>
					<th>Country Code</th>
					<th>Currency Code</th>
					<th>Capital</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if($pages->items_total>0){
					$n  =   1;
					while($val  =   $result->fetch_assoc()){ 
				?>
				<tr>
					<td><?php echo $n++; ?></td>
					<td><?php echo mb_strtoupper($val['countryName']); ?></td>
					<td><?php echo $val['id']; ?></td>
					<td><?php echo mb_strtoupper($val['countryCode']); ?></td>
					<td><?php echo mb_strtoupper($val['currencyCode']); ?></td>
					<td><?php echo mb_strtoupper($val['capital']); ?></td>
				</tr>
				<?php 
					}
				}else{?>
				<tr>
					<td colspan="6" align="center"><strong>No Record(s) Found!</strong></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		
		<div class="clearfix"></div>
		
		<div class="row marginTop">
			<div class="col-sm-12 paddingLeft pagerfwt">
				<?php if($pages->items_total > 0) { ?>
					<?php echo $pages->display_pages();?>
					<?php echo $pages->display_items_per_page();?>
					<?php echo $pages->display_jump_menu(); ?>
				<?php }?>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="clearfix"></div>
        
    </div> <!--/.container-->
	
</body>
</html>



