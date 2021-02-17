<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../config/database.php';
    include_once '../class/products.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Products($db);

    $stmt = $items->getProducts();
    $itemCount = $stmt->rowCount();


    json_encode($itemCount);

    if($itemCount > 0){
        
        $employeeArr = array();
        $employeeArr["Products"] = array();
        $employeeArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "color" => $color,
				"category" => $category,
				"productName" => $productName,
				"price" => $price,
                "avg_score" => $avg_score,
                "description" => $description,
				"reviews" => $reviews
            );

           array_push($employeeArr["Products"], $e);
        }
        echo json_encode($employeeArr);

    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }

?>