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

        /* Title Rules */
        .backdrop {
            background-image: url("./media/header/recipes.jpg");
        }

        h1 {
            font-size: 7vw;
            padding: 0vw 2vw;
            width: fit-content;
            margin: 0vw auto 0vw auto;
            line-height: 18vw;
            background: none;
        }

        /* Heading Rules */
        .multi-drop { line-height: 5vw; }
        .multi-drop h1 { padding: 0vw 0px 0px 0px; font-size: 5vw; }
        .multi-drop h2 { font-size: 4vw; }

        
        #find_recipe {
            height: auto;
        }
        
        h3 {margin: 30px auto}
        #find_recipe li {list-style-position: inside;}
        #find_recipe table {padding: 0px}
        table {margin: 30px 200px}
        
        #recipe_buttons {margin-bottom: 30px;}

        li {font-size: 20px; text-align: center;}

        td {max-width: 600px; width: 600px; }

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
                <li><a href="./index.html">Home</a></li>
                <li><a href="./recipes.php">Recipes</a></li>
                <li><a href="./orders.html">My Orders</a></li>
                <li> <a href="./login.php"> Log In </a></li>
            </ul>
        </div>
    </header>

    <div class="backdrop">
        <div class="multi-drop">
            <h1>Recipes</h1>
        </div>
    </div>

    <div class="text_block" id="find_recipe">
        <h3>
            Find a New Recipe!
        </h3>

        <table>
            <tr>
                <th id="recipe_title">Title</th>
                <th>Ingredients</th>
            </tr>
            <tr>
                <td id="recipe_description">Description</td>
                <td>
                    <div id="recipe_ingredients"><em>Recipe Not Yet Generated</em></div>
                </td>
            </tr>
        </table>

        <div id="recipe_buttons">
            <button type="button" id="generate_recipe" style="width: 300px" onclick="fetchdata()">Generate New Recipe</button>
            <input type="submit" name="order_button"
                class="order_button" id="order_now" value="Order Now" />
        </div>
    </div>

    <?php
        if(isset($_POST["order_button"])) {
            session_start();
            $_SESSION['url'] = "./recipes.php";
            if (empty($_SESSION['username'])) {
                echo "<script> location.href='./login.php'; </script>";
                exit;
            }
            else {
                orderNow();
            }
        }

        function orderNow() {
            echo "success!";
        }
    ?>


    <!-- <footer>
        <p>&copy; Hain's Delivery 2020</p>
    </footer> -->

</body>

</html>