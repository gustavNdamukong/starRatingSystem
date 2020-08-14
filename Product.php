<?php


use Rating;



class Product
{




    public function __construct()
    {

    }




    /**
     * Get all products
     */
    public function getProducts()
    {
        $review = new Rating();
        $query = "SELECT * FROM products";

        $data = $review->query($query);

        return $data;
    }


}