<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Final Project</title>

    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Raleway'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
    <link rel="stylesheet" href="select_tools/select_style.css">

    <link rel="stylesheet" type = "text/css" href="./style.css">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="script.js"></script>

    <style>
        .text_block {
            height: auto;
            margin-bottom: 0px;
        }
        .text_block li {list-style-position: inside;}
        .text_block table {padding: 0px}
        
        #recipe_buttons * {display: inline-block;}
        
        h3 {margin: 30px auto}
        li {font-size: 20px; text-align: center;}
        td {max-width: 600px; width: 600px; }

        h1 {
            font-size: 7vw;
            padding: 0vw 2vw;
            width: fit-content;
            margin: 0vw auto 0vw auto;
            line-height: 18vw;
            border-radius: 2vw;
            color: var(--dark);
            background: none;
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
                    else echo("<li><a href=\"./orders.php\">My Orders</a></li><li><a href=\"./logout.php\">Log Out</a></li>");
                ?>
            </ul>
        </div>
    </header>

    <div class="backdrop">
        <div class="multi-drop">
            <h1>Recipes</h1>
        </div>
    </div>

    <div class="text_block" id="search_recipe">
        <h3>
            Search For a Recipe!
        </h3>

        <div class="container">
            <section>
                <select multiple="multiple" id="recipe_selction">
                    <option>Item 0</option>
                    <option>Item 1</option>
                    <option>Item 2</option>
                    <option>Item 3</option>
                    <!-- <option>Item 4</option> -->
                </select>
            </section>
        </div>

        <div id="recipe_buttons">
            <button type="button" id="search" style="width: 300px" onclick="recipe_search()">Search Recipe!</button>
            <form method="post" name="order_button" id="order_form">
                <!-- <input type="submit" name="order_submit_button" form="order_form"
                       class="submit_button" id="order_now" value="Order Now" /> -->
            </form>
            <button type="button" id="order_now" style="width: 220px" form="order_form">Order Now!</button>
        </div>
    </div>

    <?php
        if(isset($_POST["order_submit_button"])) {

            $_SESSION['url'] = "./recipes.php";
            if (empty($_SESSION['username'])) {
                //TODO: here is where we should store the info which will be added to their account once they create a log in
                echo "<script> location.href='./login.php'; </script>";
                exit;
            }
            else {
                orderNow();
            }
        }

        function orderNow() {
            //TODO: here we should add the order to the database
            echo "<script> alert('user logged in (huh?)'); </script>";
        }
    ?>

    <script src="select_tools/select_index.js"></script>
    <!-- <footer>
        <p>&copy; Hain's Delivery 2020</p>
    </footer> -->

</body>

</html>