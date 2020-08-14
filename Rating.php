<?php



class Rating
{

    protected $host = '';


    protected $username = '';


    protected $pwd = '';


    protected $db = '';


    protected $salt = '';


    protected $connectionType = '';





    public function __construct()
    {
        //get DB connection credentials
        $this->username = 'dorguz';
        $this->pwd = 'dorguz123';
        $this->db = 'starRatingSystem';
        $this->host = 'localhost';

        $this->connectionType = 'mysqli';
        $this->salt = 'takeThisWith@PinchOfSalt';

    }





    protected function connect()
    {

        if ($this->connectionType  == 'mysqli')
        {
            $conn = new mysqli($this->host, $this->username, $this->pwd, $this->db);

            if ($conn->connect_error)
            {
                die('cannot open database');
            }


            return $conn;
        }
        elseif ($this->connectionType  == 'pdo')
        {
            try
            {
                return new PDO("mysql:host=$this->host;dbname=$this->db", $this->username, $this->pwd);
            }
            catch (PDOException $e)
            {
                echo 'Cannot connect to database';
                exit;
            }
        }
    }






    public function query($query)
    {
        $db = $this->connect();

        $res = $db->query($query);

        //check result if SELECTING
        if ((isset($res->num_rows)) && ($res->num_rows > 0))
        {
            $results = array();
            while ($row = $res->fetch_assoc())
            {
                $results[] = $row;
            }

            return $results;
        }


        //check result if INSERTING/UPDATING/DELETING
        if ((isset($db->affected_rows)) && ($db->affected_rows > 0))
        {

            if ((isset($db->insert_id)) && ($db->insert_id != 0)) {
                return $db->insert_id;
            }
            else
            {
                return true;
            }
        }

        return false;
    }





    /**
     * Get all reviews
     */
    public function getRatings()
    {
        $query = "SELECT * FROM ratings";

        $data = $this->query($query);

        return $data;
    }







    /**
     * Save review
     */
    public function saveRating()
    {
        //TODO: Clean the input to prevent SQL Injection attacks
        $tm_error = '';

        if ((isset($_POST['tm_client_name'])) && ($_POST['tm_client_name'] != ''))
        {
            //get client name
            $tm_name = $_POST['tm_client_name'];

            if ($tm_name == "")
            {
                // No name provided
                $tm_error .= '<p>Please enter your name</p>';
            }


            //get client rating
            $tm_rating = $_POST['tm_rating'];
            if ($tm_rating == "")
            {
                // No rating provided
                $tm_error .= '<p>Please give a rating</p>';
            }

            //get client rating comment
            $tm_comment = $_POST['tm_comment'];
            //$tm_comment = $val->fix_string($tm_comment);
            if ($tm_comment == "")
            {
                // No comment provided
                $tm_error .= '<p>Please enter the reason for your rating</p>';
            }

            //get the product ID
            $productId = $_POST['productId'];
        }


        // We'll only run the following code if no errors were encountered
        if ($tm_error == "")
        {
            $query = "INSERT INTO ratings (ratings_client_name, ratings_rating, ratings_comment, products_id, ratings_date) VALUES ('$tm_name', $tm_rating, '$tm_comment', $productId, NOW())";

            $saved = $this->query($query);

            if ($saved != false)
            {
                header('location: index.php?saved=1');
            }
            else
            {
                header('location: index.php?saved=0');
            }
        }
        else
        {
            header('location: index.php?fields=0');
        }
    }







    /**
     * Use this helper method to generate rounded figures to fractions for the star ratings
     * @param $number
     * @param int $denominator
     * @return float
     */
    public function roundToFraction($number, $denominator = 1)
    {
        $x = $number * $denominator;
        $x = ceil($x);
        $x = $x / $denominator;
        return $x;
    }
}