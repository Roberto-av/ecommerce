<?php
class ProductSeeder
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    public function seed()
    {
        $jsonFilePath = __DIR__ . '/../json/products.json';

        $jsonData = file_get_contents($jsonFilePath);
        $products = json_decode(json: $jsonData, associative: true);

        foreach ($products as $product) {
            $this->insertProduct(product: $product);
        }
    }

    public function countProducts()
    {
        $query = "SELECT COUNT(*) FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    private function insertProduct($product)
    {
        if ($this->countProducts() > 5) {
            error_log("La tabla 'products' ya contiene registros. No se insertarán nuevos datos.");
            return;
        }
    
        $query = "INSERT INTO products (title, description, category, price, discountPercentage, rating, stock, tags, brand, image)
                  VALUES (:title, :description, :category, :price, :discountPercentage, :rating, :stock, :tags, :brand, :image)";
    
        $stmt = $this->conn->prepare($query);
    
        $title = $product['title'];
        $description = $product['description'];
        $category = $product['category'];
        $price = $product['price'];
        $discountPercentage = $product['discountPercentage'];
        $rating = $product['rating'];
        $stock = $product['stock'];
    
        $tags = json_encode($product['tags']);
        $brand = $product['brand'];
        $image = $product['image']; 
    
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':discountPercentage', $discountPercentage);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':tags', $tags);
        $stmt->bindParam(':brand', $brand);
        $stmt->bindParam(':image', $image); 
    
        $stmt->execute();
    }
    
    
}
