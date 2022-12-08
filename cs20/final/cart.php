<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Final Project</title>
    <link rel="stylesheet" type = "text/css" href="./style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="script.js"></script>
    <style>
        .backdrop {
            background-image: url("./media/header/orders.jpg");
        }
    </style>

</head>

<body>
    <header>
        <div class="nav_bar">
            <div class="name_logo">
                <a href="./index.html" class="logo"><img src="./media/header/logo.jpg" height="50px"></a>
                <div class="bakery_name">
                    Hain's Delivery
                </div>
            </div>

            <ul class="nav_bar_ul">
                <li><a href="./index.php">Home</a></li>
                <li><a href="./recipes.php">Recipes</a></li>
                <?php
                    if (empty($_SESSION['username'])) echo ("<li><a href=\"./login.php\">Log In</a></li>");
                    else echo("<li><a href=\"./cart.php\">My Cart</a></li><li><a href=\"./orders.php\">My Orders</a></li><li><a href=\"./logout.php\">Log Out</a></li>");
                ?>
            </ul>
        </div>
    </header>

    <div class="backdrop">
        <div class="multi-drop">
            <h1>My Cart</h1>
        </div>
    </div>

    <div class="text_block" id="search_recipe">
        <h3>
            Order your recipes now!
        </h3>

        <?php
            function get_cart($username){

                // database info
                $server = "localhost";
                $userid = "u0m7cp7iogobo";
                $pw = "finalprojectpass";
                $db = "dbsikj01q12d1d";
                
                // connect to database
                $conn = new mysqli($server, $userid, $pw, $db);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
    
                // check if user is in database
                $sql = "SELECT * FROM orders WHERE username='$username' AND in_cart='1'";
                $result = $conn->query($sql);
                $items = $result->fetch_all(MYSQLI_ASSOC);

                if ($items->num_rows == 0) {
                    echo "no items in cart!";
                } 
                else {
                    foreach($items as $item) { 
                        echo "here is one of your items:";
                        echo $item;
                    }
                }
                // close database connection
                $conn->close();
            }
            get_cart($_SESSION['username']);
        ?>

        <div id="recipe_buttons">
            <button type="button" id="search" style="width: 300px" onclick="recipe_search()">Search Recipe!</button>
        </div>
    </div>


</body>

</html>