<?php
    class Products{

        // Connection
        private $conn;

        // Table
        private $db_table = "products";

        // Columns
        public $id;
        public $color;
        public $category;
        public $productName;
        public $price;
		public $description;
		public $tag;
		public $productMaterial;
		public $imageUrl;
		public $createdAt;
		public $reviews;
		public $avg_score;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // Liste paginée des produits
        public function getProducts(){
            $sqlQuery = "SELECT  id, color, category, productName, price ,avg_score,description,reviews  FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;         
        }

		// Fiche détaillée des produits
		public function getAllProducts(){
			$sqlQuery = "SELECT * FROM " . $this->db_table . " limit 10 ";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			return $stmt;
		}
        
		// Liste  des Category
		public function getCategory(){
			$sqlQuery = "SELECT distinct category FROM " . $this->db_table . " ORDER BY category ASC ";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			return $stmt;
		}
        
        // Liste des URL de produit aleatoir
		public function getImageUrl(){
			$sqlQuery = "SELECT imageUrl FROM " . $this->db_table . " ORDER BY RAND() LIMIT 3";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			return $stmt;
		}
		
		// Liste paginée des produits
        public function getProductsDetails(){
            $sqlQuery = "SELECT  *  FROM " . $this->db_table . " limit 1 ";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;         
        }
}
?>

