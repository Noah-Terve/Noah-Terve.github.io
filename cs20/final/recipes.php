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

        h4 {margin: 0px; max-height: 3vw; width: 100%; margin-top: 0px;}

        .search_result { display: inline; height: fit-content; padding: 25px}
        /* .search_result button {margin-bottom: 0px} */
        .search_result h4 {margin-bottom: 10px;}
        .search_result label {font-weight: bold; font-size: 1vw;}

        
        .json {display: none}
        .json * {display: none}

        #search_results {padding: 0px}
        #order_section {background-color: var(--taupe);
                        align-items: center; padding-top: 0px; padding-bottom: 15px;}

        #search_results p {margin-top: 20px;}
        

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
                    <option>Gluten Free</option>
                    <option>Vegetarian</option>
                    <option>Vegan</option>
                    <option>Pescetarian</option>

                    <option>Main Course</option>
                    <option>Dessert</option>
                    <option>Breakfast</option>
                    <option>Snack</option>
                    
                    <option>Greek</option>
                    <option>Southern</option>
                    <option>Mexican</option>
                    <option>American</option>
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
            if (!empty($_SESSION['username'])) {
                add_to_cart();
            }
        }

        function add_to_cart() {
            // NOTES ON DATA STORAGE:
            /* POST DATA: Stored in the Following Variables
             * $_POST['json_title']: A List of the Names of the foods selected
             * $_POST['json_summary']: A List of the Summaries/Descriptions of the foods selected
             * $_POST['json_price']: A List of the Prices of the foods selected
             * $_POST['json_ingredients']: A List of the List of ingredients of the foods selected
             * $_POST['num_results']: The total number of foods selected
            */

            // $_POST['select'] = []
            $_POST['json_title'] = [];
            $_POST['json_summary'] = [];
            $_POST['json_price'] = [];
            $_POST['json_ingredients'] = [];

            $true_count = 0;
            for ($i = 0; $i < $_POST['num_results']; $i++) {
                if ($_POST["select_{$i}"]) {
                    $_POST['json_title'][]       = $_POST["json_{$i}_title"];
                    $_POST['json_summary'][]     = $_POST["json_{$i}_summary"];
                    $_POST['json_price'][]       = $_POST["json_{$i}_price"];
                    $_POST['json_ingredients'][] = $_POST["json_{$i}_ingredients"];
                    $true_count += 1;
                }
            }
            $_POST['num_results'] = $true_count;

        }
        
    ?>

    <!-- <footer>
        <p>&copy; Hain's Delivery 2020</p>
    </footer> -->

    <script src="select_tools/select_index.js"></script>

</body>

</html>