<html>  
    <head>  
	   <title>Json to Mysql</title> 
    </head>  
      <body>  
        <div class="container box">
          <h3 align="center">Import JSON File Data into Mysql in PHP</h3><br />
          <?php
			$host = "localhost";
			$user="root";
			$passwd="";
			$base= "application";
			 
			$connect = mysqli_connect ($host,$user,$passwd,$base);			 
			if (mysqli_connect_errno()){
			echo "Error connecting to MySQL: " . mysqli_connect_errno();
			exit(0);}
			$query = '';
			// Download JSON file
			// $json = file_get_contents('http://internal.ats-digital.com:30000/products?size=5000');

			$filename = "products.json"; //Fils Json Products
			$data = file_get_contents($filename); //Read the JSON file in PHP
			$array = json_decode($data,true); //Convert JSON String into PHP Array
		
      // var_dump($array);
          foreach($array["products"] as $row){     
           $query .= "INSERT INTO products (color,category,productName,price,description,tag,productMaterial,imageUrl,createdAt,reviews) 
		   VALUES (
					'".$row["color"]."', 
					'".$row["category"]."',
					'".$row["productName"]."',
					'".$row["price"]."', 
					'".$row["description"]."',
					'".$row["tag"]."',
					'".$row["productMaterial"]."', 
					'".$row["imageUrl"]."',
					'".$row["createdAt"]."',
					'".json_encode(@$row["reviews"])."'); ";
          }
			if(mysqli_multi_query($connect,$query))
				{echo'Data insertion is completed successfully :) ';}
			else 
				{ echo'Error :( ';}
          ?>
        </div>  
    </body>  
 </html> 