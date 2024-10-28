<?php
class ProductController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function getAllProducts() {
        $query = "SELECT * FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $row['tags'] = json_decode($row['tags'], true);
            
            return $row;
        }
    
        return null;
    }
    
}
