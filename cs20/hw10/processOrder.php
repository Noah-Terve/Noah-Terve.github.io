<html>
<head>
    <title>Order Details</title>

    <style>
        h1, h2, h3, h4 {
            text-align: center;
        }

        div {
            padding: 8px 20px;
        }
    </style>
</head>
<body>
    <?
        $servername = "";
        $username = "";
        $password = "";
        $dbname = "";
    ?>

    <h1>Two Owls Cafe</h1>
    <h2>Your late night spot for cheep eats</h2>
    <h3>TAKEOUT ONLY</h3>
    <h4>Open daily from 7pm - 2am</h4>
    
    <?
        // Take a cost, and make sure that it has the right number of 0s
        // after the decimal point to make formatting look pretty (returns as a string)
        function format_cost($cost) {
            $string_cost = (string)$cost;
            $idx = strpos($string_cost, '.');
            $len = strlen($string_cost);

            // cases:
                // 1: no '.': add '.00'  -> strpos returns false
                // 2:    '.': add '00'   -> len - z, idx = z - 1 
                //            (this case is not possible, but including for the sake of the function so it
                //             works in all cases to pad an int to 2 decimal places and return as a string)
                // 2:   '.x': add '0'    -> len = z, idx = z - 2
                // 3:  '.xx': do nothing -> len = z, idx = z - 3

            if (!$idx)            return $string_cost . ".00";
            if ($idx == $len - 1) return $string_cost . "00";
            if ($idx == $len - 2) return $string_cost . '0';
            /* pretty indent */   return $string_cost;
        }

        // Open connection to database, and then use it to count how many items
        // we have to check to get their data for item numbers.
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "SELECT * FROM Items ORDER BY ItemNum ASC";
        $result = $conn->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $length = 0;
        foreach ($rows as $row) {
            $length ++;
        }

        // get the data from the request
        $first_name = $_REQUEST["firstname"];
        $last_name = $_REQUEST["lastname"];
        $instructions = $_REQUEST["instructions"];
        $subtotal = $_REQUEST["subtotal"];
        $tax = $_REQUEST["tax"];
        $total = $_REQUEST["total"];
        
        $items_ordered = [];
        for ($i = 0; $i < $length; $i++){
            $items_ordered[] = $_REQUEST["quan" . ($i + 1)];
        }

        // Build up order details
        $order_details = "<div style='padding-left: 0px;'> <strong>Order Details:</strong> </div><div>Items:<br />";

        for ($i = 0; $i < $length; $i++) {
            // if they didn't order any of an item dont display it
            if ($items_ordered[$i] <= 0) continue;
            $cost = format_cost($items_ordered[$i] * $rows[$i]["Cost"]);
            $order_details = $order_details . $items_ordered[$i] . " x " . $rows[$i]["ItemName"] .
                             " at $" . $rows[$i]["Cost"] . " each, is $" . $cost . "<br />";
        }

        $order_details = $order_details . "</div><div>subtotal: $" . $subtotal .
                         "<br />tax: $" . $tax . 
                         "<br />total: $" . $total . "</div>";

        // print order details to the page
        echo($order_details);
    ?>

    <div id="pickup_time"></div>

    <script>
        // Having this here because we need to calculate the time at user side
        // For reference, this has to make new dates every time, because it is constantly getting/setting values and
        // they return ints that can make new dates easily, so it's an ease thing that I wanted to just put on one line.
        document.getElementById("pickup_time").innerHTML = "Pickup time: " + String(new Date(new Date(new Date().getTime() + 900000).setSeconds(0)).toLocaleString())
    </script>
</body>

</html>