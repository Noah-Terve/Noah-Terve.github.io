<?php
session_start();
?>

<body>
    <?php
        if (empty($_SESSION['username'])) {
            echo("<script>location.href='./index.php'; </script>");
        }

        // Gather info from the post request
        $prices = [];
        $titles = [];
        $summaries = [];
        $ingredients = [];
        $instructions = [];
        $true_count = 0;

        for ($i = 0; $i < $_REQUEST['num_results']; $i++) {
            if ($_REQUEST["select_{$i}"]) {
                $titles[]       = $_REQUEST["json_{$i}_title"];
                $summaries[]    = $_REQUEST["json_{$i}_summary"];
                $prices[]       = $_REQUEST["json_{$i}_price"];
                $ingredients[]  = $_REQUEST["json_{$i}_ingredients"];
                $instructions[] = $_REQUEST["json_{$i}_instructions"];
                $true_count += 1;
            }
        }

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

        $sql = "";
        $result;
        $username = $_SESSION['username'];
        $failed = FAlSE;

        for ($i = 0; $i < $true_count; $i++) {
            $sql = "INSERT INTO orders (username, in_cart, serving_cost, servings, title, description, steps, ingredients) 
                                VALUES ('$username', '1', '$prices[$i]', '" . round($prices[$i] / 8) . "', '$titles[$i]', '$summaries[$i]', '$instructions[$i]', '$ingredients[$i]')";
            $result = $conn->query($sql);

            if ($result == FAlSE) {
                echo "<script> alert(\"We ran into an issue, please try again soon\"); console.log(Error: "
                            . $sql . "<br>" . $conn->error . ") </script>";
                $failed = TRUE;
            }
        }

        if (!$failed) {
            echo("<script> alert(\"We have recieved your order, you can now close this window\"); </script>");
        }
    ?>
</body>