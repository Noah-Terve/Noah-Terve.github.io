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

        table {
            line-height: 25px;
            margin: 1rem 1rem;
            border-collapse: collapse;
            text-align: center;
            border-radius: 10px;
        }

        th {
            color: var(--muave);
        }

        tr:not(:last-child) {
            border-bottom: 2px solid var(--muave);
        }

        tr:not(:first-child) {
            border-top: 2px solid var(--muave);
        }
    </style>

</head>

<body>
<?php
    if (empty($_SESSION['username'])) echo ("<script> alert(\"You must be logged in to view your cart!\");
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
            <h1>My Cart</h1>
        </div>
    </div>

    <div class="text_block">

        <table>
            <tr>
                <th>Recipe</th>
                <th>Servings</th>
                <th>Cost Per Serving</th>
                <th>Total Cost</th>
            </tr>

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

                // get each item and print to page
                foreach($items as $item) { 
                    $recipe = json_decode($item["recipe"],true);
                    $cost = $item["serving_cost"];
                    $servings = $item["servings"];
                    $totalcost = number_format($cost * $servings, 2, '.', "");
                    print_recipe($recipe, $cost, $servings, $totalcost);
                }

                // close database connection
                $conn->close();
            }

            function print_recipe($recipe, $cost, $servings, $totalcost){
                $s = "<tr>";
                $s .= td($recipe["title"], "name");
                $s .= td(makeSelect("quantity", 1, 20,$servings), "servings");
                $s .= td("$" . $cost, "cost");
                $s .= td("$" . $totalcost, "totalcost");
                $s.= "</tr>";

                echo $s;
            }

            // functions to create select item and td item
            function makeSelect($name, $minRange, $maxRange, $selected) {
                $t = "<select name='$name' size='1'>";
                for ($i = $minRange; $i <= $maxRange; $i++) {
                    if ($i == $selected) {
                        $t .= "<option selected> $i </option>";
                    } else {
                        $t .= "<option> $i </option>";
                    }
                }
                $t .= "</select>"; 
                return $t;
            }
            function td($content, $className) {
                return "<td class = '$className'> $content </td>";
            }

            get_cart($_SESSION['username']);
        ?>
        </table>

        <div id="order_button">
            <button type="button" id="order" style="width: 300px" onclick="">Place Order!</button>
        </div>
    </div>

</body>

</html>