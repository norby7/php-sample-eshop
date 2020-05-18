<?php
if (!isset($_SESSION)) { session_start(); }
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
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
        $limit = " 9 OFFSET " . 9 * ($page - 1);
        //$limit = 9 * ($page - 1) . ", " . 9 * $page;
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
        $stmt = $this->conn->query("SELECT p.image_url, p.uid, p.name, p.price FROM reviews r
                                    INNER JOIN products p ON p.uid = r.product_uid
                                    GROUP BY r.product_uid, p.image_url, p.uid, p.name, p.price
                                    ORDER BY AVG(r.rating) DESC
                                    LIMIT 5");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProductInfo($productUID){
        $stmt = $this->conn->query("SELECT p.*, b.name brand, m.name manufacturer FROM products p
                                            INNER JOIN brands b ON b.id = p.brand_id
                                            INNER JOIN manufacturers m ON m.id = p.manufacturer_id
                                            WHERE p.uid = '$productUID'");
        $product = $stmt->fetch();

        return $product;
    }

    public function getProductReviews($productUID){
        $stmt = $this->conn->query("SELECT text,username, to_char(created_at, 'DD.MM.YYYY') date FROM reviews WHERE product_uid = '$productUID'");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insertReview(){
        $sql = "INSERT INTO reviews (username, text, rating, product_uid, created_at) VALUES (?,?,?,?, NOW())";
        $this->conn->prepare($sql)->execute([$_POST["username"],$_POST['review_text'],$_POST['rating'],$_POST['product_id']]);

        $sql = "UPDATE products p SET rating = (SELECT ROUND(AVG(rating),0) FROM reviews WHERE product_uid = p.uid) WHERE p.uid = ?";
        $this->conn->prepare($sql)->execute([$_POST['product_id']]);

        $productInfo = $this->getProductInfo($_POST['product_id']);
        return $productInfo['rating'];
    }

    public function getCartItems(){
        if(isset($_SESSION['cart'])) {
            $uidList = implode("','", array_keys($_SESSION['cart']));
            $uidList = "'" . $uidList . "'";

            $stmt = $this->conn->query("SELECT uid, name, price, image_url FROM products WHERE uid IN ($uidList)");

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        return array();
    }

    public function submitOrder(){
        $adressOpt = empty($_POST['addressOpt']) ? "" : $_POST['addressOpt'];
        $sql = "INSERT INTO orders (first_name, last_name, email, address, adress_opt, country, state, zip, payment_type, card_name, card_number, expiration, cvv, products_list, products_qty, date) 
                            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, NOW())";
        $this->conn->prepare($sql)->execute([$_POST["firstName"],$_POST['lastName'],$_POST['email'],$_POST['address'],$adressOpt,$_POST['country'],$_POST['state'],$_POST['zip'],$_POST['paymentType'],$_POST['cardName'],$_POST['cardNumber'],$_POST['cardExpiration'],$_POST['cardCVV'],implode("','", array_keys($_SESSION['cart'])),implode("','", $_SESSION['cart'])]);

        try {
            $items = $this->getCartItems();
            $total = 0;

            $mail = new PHPMailer(); // create a new object
            $mail->IsSMTP(); // enable SMTP
            $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465; // or 587
            //$mail->IsHTML(true);
            $mail->Username = "chatbot.gen@gmail.com";
            $mail->Password = "#chatbotgen1";
            $mail->SetFrom("chatbot.gen@gmail.com");
            $mail->Subject = "Test";
            ob_start();
            include 'mail_template.php';
            $body = ob_get_clean();
            $mail->IsHTML(true);
            $mail->Body = $body;
            $mail->IsHTML(true);
            $mail->AddAddress($_POST['email']);

            if(!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                echo "Message has been sent";
            }

            unset($_SESSION['cart']);
        }catch (\Exception $exception){
            echo "Error";
            var_dump($exception);
        }

        return "Success";
    }
}