<?php

require_once('Rating.php');
require_once('Product.php');


$review = new Rating();
$product = new Product();

$products = $product->getProducts();

if ((isset($_POST['tm_rating'])) && ($_POST['tm_rating'] != ''))
{
    $review->saveRating();
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <title>starRatingSystem</title>

    <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <style rel="stylesheet" type="text/css">
        .stars-outer {
            display: inline-block;
            position: relative;
            font-family: FontAwesome;
        }

        .stars-outer::before {
            /*each of our icons should appear five times inside a table row hence the repetition of their unicode*/
            content: "\f006 \f006 \f006 \f006 \f006";
        }

        /*Style the internal body of the star-a width of 0 will make the body blank, and so white in colour*/
        .stars-inner {
            position: absolute;
            top: 0;
            left: 0;
            white-space: nowrap;
            overflow: hidden;
            /*width: 0;*/
        }

        .stars-inner::before {
            /*each of our icons should appear five times inside a table row hence the repetition of their unicode*/
            content: "\f005 \f005 \f005 \f005 \f005";
            /*Style the internal body of the star-a width of 0 as above will make the body blank and thus white; otherwise give it a golden color
            Note that it is the width of this '.stars-inner' that we will manipulate to create fractions of stars-for example;
            making '.stars-inner' 50% wide will reveal half of it*/
            color: #f8ce0b;
        }
    </style>

    </head>
    <body>
        <div class="container">
            <div class="row">
            <h2>Welcome to the product review app</h2>

                <div class="jumbotron">
                    <?php
                    foreach ($products as $prod) {

                        //get the num of reviews and ratings this product has earned overall
                        $reviewsQuery = "SELECT ratings_client_name, ratings_rating, ratings_comment, (SELECT COUNT(*) FROM ratings WHERE products_id = $prod[product_id]) AS num_ratings, (SELECT SUM(ratings_rating) FROM ratings WHERE products_id = $prod[product_id]) AS num_stars, ratings_date FROM ratings WHERE products_id = $prod[product_id]";

                        $reviewStats = $review->query($reviewsQuery);

                        //get the average rating
                        if ($reviewStats[0]['num_stars']) {
                            //Sum of all ratings divided by num of reviewers, divided by max rating, multiplied by a hundred for a percentage
                            $starAverage = (($reviewStats[0]['num_stars'] / $reviewStats[0]['num_ratings']) / 5) * 100;
                            $finalAverage = $review->roundToFraction($starAverage, 4);
                        }
                        else {
                            $starAverage = 0;
                        }

                        echo "<h2>Product name: $prod[product_name]</h2>";
                        echo "<p>Product description: $prod[product_description]</p>";?>
                        <?php if ($reviewStats[0]['num_stars']) { ?>
                            <h4>Number of reviewers: <?= $reviewStats[0]['num_ratings'] ?></h4>
                            <?php
                        } ?>
                        <h3>
                            <div class="stars-outer">
                                <div class="stars-inner" style="width:<?=$finalAverage?>"></div>
                            </div>
                        </h3>


                        <div class="productDiv">
                            <?php //Display current reviews for this product
                            if ($reviewStats) { ?>
                                <div class="well">
                                <?php
                                foreach ($reviewStats as $data) { ?>

                                        <p>Reviewer name: <?= $data['ratings_client_name'] ?></p>
                                        <p>Rating score: <?= $data['ratings_rating'] ?></p>
                                        <p>Comment: <?= $data['ratings_comment'] ?></p>
                                        <p>Review date: <?= $data['ratings_date'] ?></p>
                                    <hr />
                                    <?php
                                } ?>
                                </div>
                            <?php
                            }
                            else
                            { ?>
                                <p>This product has no reviews yet. Be the first to review.</p>
                            <?php
                            } ?>
                            <a data-id="<?=$prod['product_id']?>" id="makeRating" data-toggle="modal"
                                                 style="border-radius:4px;" href="#" class="btn btn-primary"
                                                 data-target="#ratingModal">Review this product</a>
                        </div> <!--END OF PRODUCT DIV-->
                        <hr />
                        <?php
                        //reset the average ratings which is used for the width of the yellow color in the rating stars (0 means white)
                        $finalAverage = 0;
                    } ?>
                </div>
            </div>
        </div>





        <!-- ==========================
                          MODAL TESTIMONIAL / FEEDBACK - START
                        =========================== -->
        <div class="modal fade" role="dialog" id="ratingModal" style="display:none;">
            <div class="modal-dialog" style="background-color: #FFF; border-radius: 10px;">

                <!-- Modal content-->
                <div class="md-content">

                    <!-- Modal header-->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 style="background-color: #28a4c9; color: #FFF;font-weight: bold;" class="modal-title text-center">Your Review</h3>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div>
                            <p>Fill in the data appropriately:</p>
                            <form action="" method="post" id="tmForm">

                                <p>
                                    <label for="tm_name">Your name</label>
                                    <input class="form-control" type="text" align="center" id="tm_client_name" name="tm_client_name" autocomplete="off" placeholder="Full name" />
                                </p>

                                <p>
                                    <label for="tm_rating">Please rate us from 1 to 5 (where 1 is very dissatisfied)</label>
                                    <select class="form-control" align="center" id="tm_rating" name="tm_rating">
                                        <option value="">Please choose a rating from 1-5</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </p>

                                <p>
                                    <label for="tm_comment">Please enter the reason for your rating</label>
                                    <textarea class="form-control" align="center" id="tm_comment" name="tm_comment"></textarea>
                                </p>

                                <input type="hidden" id="productId" name="productId" value="" />

                                <p>
                                    <input type="submit" id="ratingBtn" class="btn btn-primary btn-sm" value="Submit"/>
                                </p>
                            </form>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ==========================
            MODAL TESTIMONIAL / FEEDBACK - END
        =========================== -->


        <script type="text/javascript">
            $(document).ready(function() {

                //-----------Handle review form---------------------
                $(document).on('click', '#ratingBtn', function (e) {
                    var errorMsg = "";
                    var tmForm = document.getElementById('tmForm').value;
                    var tmName = document.getElementById('tm_client_name').value;
                    var tmRating = document.getElementById('tm_rating').value;
                    var tmComment = document.getElementById('tm_comment').value;

                    if (tmName.trim() == '') {
                        errorMsg += "Please enter your name \n\n"
                    }

                    if (tmRating.trim() == '') {
                        errorMsg += "Please give a rating \n\n"
                    }

                    if (tmComment.trim() == '') {
                        errorMsg += "Please give a reason for your rating \n\n"
                    }

                    if (errorMsg == "")
                    {
                        tmForm.submit();
                    }
                    else
                    {
                        alert(errorMsg);
                    }


                    e.preventDefault();
                });




                //link product ID with field in moal form
                $(document).on("click", "#makeRating", function () {
                    var productId = $(this).data('id');
                    $(".modal-body #productId").val( productId );
                });


            });
        </script>
</body>
</html>
