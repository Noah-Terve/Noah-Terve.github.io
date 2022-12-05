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
        #purpose {padding: 30px 200px; background-color: var(--mist);}
        h3 { margin: 20px }

        #random_recipe {background-color: var(--taupe);}
        #random_recipe button {background-color: var(--mist);}
        #random_recipe button:hover {
            border: solid 2px var(--gray-pink);
            background-color: var(--mist);
            box-shadow: 0 12px 16px 0 rgba(165, 127, 136, 0.24), 0 17px 50px 0 rgba(165, 127, 136, 0.19);
        }
        
        /* h3 {margin: 20px auto} */
        li {font-size: 20px; text-align: center;}
        td {max-width: 600px; width: 600px; }

        #recipe_image {width: 556px; height: 370px; line-height: 370px;}

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
            <h1>Welcome to Hain's Delivery</h1>
            <!-- <h2>Top-Notch Recipes at Your Fingertips</h2> -->
        </div>
    </div>

    <div class="text_block" id="random_recipe">
        <h3>
            Find a New Recipe!
        </h3>

        <table>
            <tr>
                <th id="recipe_title">Title</th>
                <th>Description</th>
            </tr>
            <tr>
                <td>
                    <div id="recipe_image"><em>Image Not Yet Generated</em></div>
                </td>
                <td id="recipe_summary"><em>Description Not Yet Generated</em></td>
            </tr>
        </table>

        <div id="recipe_buttons">
            <button type="button" id="generate_recipe" style="width: 320px" onclick="fetch_random()">Generate New Recipe!</button>
            <button type="button" id="log_in" style="width: 210px" onclick="location.href='./login.php';">Log In Now!</button>
        </div>
    </div>

    <div class="text_block" id="purpose">
        <h3>
            What We Do
        </h3>
        <p><em>
            Hain's Delivery is dedicated to showing you bold and exciting new
            recipes and delivering ingredients right to your doorstep. And why
            wait? <a href="./login.php">Get set up with an account</a> so you can place an order today!
        </em></p>
    </div>

    <!-- <footer>
        <p>&copy; Hain's Delivery 2020</p>
    </footer> -->

</body>

</html>