<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once "Shop.php";
require_once "config.php";

$categoryName = empty($_GET['categoryName']) ? "TV" : $_GET['categoryName'];
$currentPage = empty($_GET['page']) ? 1 : $_GET['page'];
$productUID = empty($_GET['productUID']) ? -1 : $_GET['productUID'];

$shop = new Shop();
$categoriesList = $shop->getCategories();
$productInfo = $shop->getProductInfo($productUID);
$productReviews = $shop->getProductReviews($productUID);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Item - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
    <link href="css/starrr.css" rel="stylesheet">

    <link href="css/shop-item.css" rel="stylesheet">

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/product.js"></script>
    <script src="js/starrr.js"></script>
</head>
<style>
    .ratingStars {
        color: deepskyblue;
        font-size: 2em;
    }

    .productImage {
        width: 900px;
        height: 400px;
    }

    .starrr a{
        font-size: 2em !important;
    }
</style>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Shop name</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
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

        <div class="col-lg-3 my-4">
            <div class="list-group">
                <?php
                foreach ($categoriesList as $category) {
                    echo "<a href=\"index.php?categoryName=" . $category['name'] . "\" class=\"list-group-item " . ($categoryName == $category['name'] ? 'active' : '') . " \">" . $category['name'] . "</a>";
                }
                ?>
            </div>
        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">

            <div class="card mt-4">
                <img class="card-img-top img-fluid productImage" src="<?php echo $productInfo['image_url'] ?>" alt="">
                <div class="card-body">
                    <h3 class="card-title"><?php echo $productInfo['name'] ?></h3>
                    <h4>$<?php echo $productInfo['price'] ?></h4>
                    <p class="card-text"><?php echo $productInfo['description'] ?></p>
                    <span class="text-warning"><span class="ratingStars">
                                        <?php
                                        for ($i = 0; $i < 5; $i++) {
                                            if ($i < $productInfo['rating']) {
                                                echo " &#9733;";
                                            } else {
                                                echo " &#9734;";
                                            }
                                        }
                                        ?>
                                    </span></span>
                    <span id="starsNumber"><?php echo $productInfo['rating'] ?></span> stars
                </div>
            </div>
            <!-- /.card -->

            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Product Reviews
                </div>
                <div class="card-body">
                    <div id="reviewsList">
                    <?php
                    foreach ($productReviews as $review) {
                        echo "<p>" . $review['text'] . "</p><small class=\"text-muted\">Posted by " . $review['username'] . " on " . $review['date'] . "</small><hr>";
                    }
                    ?>
                    </div>
                    <div>
                        <div>Username: <input type="text" class="form-control" id="username"></div>
                        <div><textarea rows="5" class="form-control" id="review_text"></textarea></div>
                        <div>
                            <input type="hidden" id="starRatingNumber">
                            <div class='starrr'></div>
                        </div>
                    </div>
                    <button class="form-control btn-success" onclick="addReview('<?=$productUID?>')">Leave a review!</button>
                </div>
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col-lg-9 -->

    </div>

</div>
<!-- /.container -->

<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<!--<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>-->

</body>

</html>
<script>
    $(document).ready(function() {
        $('.starrr').starrr({
            change: function(e, value){
                $("#starRatingNumber").val(value);
            }
        });
    });
</script>

