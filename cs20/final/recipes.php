<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Final Project</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous">
    </script>

    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Raleway'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
    <link rel="stylesheet" href="select_tools/select_style.css">

    <link rel="stylesheet" type = "text/css" href="./style.css">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="script.js"></script>

    <style>
        .backdrop {
            background-image: url("./media/header/recipes.jpg");
        }

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

        #results_title {background-color: var(--dark)}
        #results_title h3 {margin: 10px auto; max-height: 100px;}

        .search_result { display: inline; height: fit-content; padding: 15px}
        .search_result button {margin-bottom: 0px}

        h4 {margin: 0px; max-height: 3vw; width: 100%; margin-top: 0px;}
        
        /* #search_results img {height: 200px; border: solid 0.3vw var(--creme);} */
        #search_results:nth-child(even) {background-color: var(--muave)}
        #search_results:nth-child(odd)  {background-color: var(--taupe)}

        .json {display: none}
        .json * {display: none}

        #order_section {background-color: var(--taupe); align-items: center;}

        

    </style>

</head>

<body>
    <?php
    if (empty($_SESSION['username'])) echo ("<script> alert(\"You must be logged in to find new recipes!\");
                                                location.href='./index.php'; </script>");
    ?>
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
                <li><a href="./cart.php">My Cart</a></li>
                <li><a href="./orders.php">My Orders</a></li>
                <li><a href="./logout.php">Log Out</a></li>
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
                <!-- TODO: Add margin bottom to top of multi-select to extend page automatically -->
                <select multiple="multiple" id="recipe_selction">
                    <option>Vegan</option>
                    <option>Gluten Free</option>
                    <option>Cheap</option>
                </select>
            </section>
        </div>


        <div id="recipe_buttons">
            <button type="button" id="search" style="width: 300px" onclick="recipe_search()">Search Recipe!</button>
        </div>
    </div>

    <div class="text_block" id="results_title">
        <h3>
            Search Results:
        </h3>
    </div>


    <!-- <button type="button" id="order_now" style="width: 220px" form="order_form">Order Now!</button> -->
        <form method="post" name="order_button" id="order_form">
            <div class="text_block" id="search_results">
                <p><em>Nothing Yet! Search for a Recipe When You're Ready!</em></p>
            </div>

            <div class="text_block" id="order_section">
                <input type="submit" name="order_submit_button"
                       class="submit_button" id="order_now" value="Order Now!" />
            </div>
        </form>

    <?php
        if(isset($_POST["order_submit_button"])) {
            // TODO: A
            if (empty($_SESSION['username'])) {
                //TODO: Remove These Print Statements Which Display How the Post Data is Stored
                echo "<script> console.log('" . $_POST['json_0_title'] . "') </script>";
                echo "<script> console.log('" . $_POST['json_0_summary'] . "') </script>";
                echo "<script> console.log('" . $_POST['json_0_price'] . "') </script>";
                echo "<script> console.log('" . $_POST['json_0_ingredients'] . "') </script>";
            }
            else {
                orderNow();
            }
        }

        function orderNow() {
            // NOTES ON DATA STORAGE:
            /* POST DATA: Stored in the Following Variables
             * $_POST['json_i_title']: Name of the i^th food selected
             * $_POST['json_i_summary']: Summary/Description of the i^th food selected
             * $_POST['json_i_price']: Price of the i^th food selected
             * $_POST['json_i_ingredients']: List of ingredients of the i^th food selected
            */

            // echo "<script> alert('user logged in (huh?)'); </script>";
        }
        
        // echo `<script> location.reload(); </script>`;

    ?>

    <!-- <footer>
        <p>&copy; Hain's Delivery 2020</p>
    </footer> -->
    <script src="select_tools/select_index.js"></script>
    <!-- <script> location.reload(); </script> -->

</body>

</html>