<?php
session_start();
?>

<body>
    <?php
        if (empty($_SESSION['username'])) {
            echo("location.href='./index.php'; </script>");
        }
        
        $jsons = [];
        $prices = [];
        $true_count = 0;

        for ($i = 0; $i < $_REQUEST['num_results']; $i++) {
            if ($_REQUEST["select_{$i}"]) {
                $jsons[]  = $_REQUEST["json_{$i}"];
                $prices[] = $_REQUEST["json_{$i}_price"];
                $true_count += 1;
            }
        }

        echo("Count is: " . $true_count);
        for ($i = 0; $i < $true_count; $i++) {
            //TODO insert into database
            echo("<br />JSON: " . $jsons[$i]);
            echo("<br />Price: " . $prices[$i]);
        }
    ?>
</body>