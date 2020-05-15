<?php
if (!isset($_SESSION)) { session_start(); }

class Shop
{

    /**
     * Shop constructor.
     */
    public function __construct()
    {
        global $conn;
        if (empty($conn)) {
            try {
                include "config.php";
                $conn = new PDO($dsn, $username, $password, $options);
            } catch (PDOException $error) {
                echo $error->getMessage();
            }
        }
        $this->conn = $conn;
    }

    public function getCategories()
    {
        $stmt = $this->conn->query("SELECT * FROM categories");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProductsFromCategory($categoryName, $page)
    {
        $limit = 9 * ($page - 1) . ", " . 9 * $page;
        $stmt = $this->conn->query("SELECT * FROM products WHERE category_list LIKE '%" . $categoryName . "%' LIMIT $limit");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProductsNumberFromCategory($categoryName)
    {
        $stmt = $this->conn->query("SELECT COUNT(*) number FROM products WHERE category_list LIKE '%" . $categoryName . "%'");
        $pagesNumber = $stmt->fetch();

        return $pagesNumber['number'];
    }

    public function getTopRatings()
    {
        $stmt = $this->conn->query("SELECT p.image_url, p.uid, p.name FROM reviews r
                                    INNER JOIN products p ON p.uid = r.product_uid
                                    GROUP BY product_uid
                                    ORDER BY AVG(r.rating) DESC
                                    LIMIT 5");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProductInfo($productUID){
        $stmt = $this->conn->query("SELECT * FROM products WHERE uid = '$productUID'");
        $product = $stmt->fetch();

        return $product;
    }

    public function getProductReviews($productUID){
        $stmt = $this->conn->query("SELECT text,username, DATE_FORMAT(created_at,'%d.%m.%Y') date FROM reviews WHERE product_uid = '$productUID'");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insertReview(){
        $sql = "INSERT INTO reviews (username, text, rating, product_uid, created_at) VALUES (?,?,?,?, NOW())";
        $this->conn->prepare($sql)->execute([$_POST["username"],$_POST['review_text'],$_POST['rating'],$_POST['product_id']]);

        $sql = "UPDATE products p SET p.rating = (SELECT ROUND(AVG(rating),0) FROM reviews WHERE product_uid = p.uid) WHERE p.uid = ?";
        $this->conn->prepare($sql)->execute([$_POST['product_id']]);

        $productInfo = $this->getProductInfo($_POST['product_id']);
        return $productInfo['rating'];
    }
}