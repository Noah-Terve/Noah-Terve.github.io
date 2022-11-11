<html>
<head>
    <title>Two Owls Cafe</title>

    <style>
        .userInfo label,.userInfo\ address label {
            display: inline-block;
            width: 314px;
            text-align: right;
        }

        label{
            display: inline-block;
            width: 321px;
            text-align: right;
        }

        h1, h2, h3, h4 {
            text-align: center;
        }
    </style>
</head>

<body>
    <?
        $servername = "localhost";
        $username = "uko051ggklabi";
        $password = "two_owls_pass";
        $dbname = "dbytc9cg3z4rtp";    

        // makes a select element with the given range
        function makeSelect($name, $minRange, $maxRange){
            $s = "<select name='$name' size='1'>";
            for ($i = $minRange; $i <= $maxRange; $i++)
                $s = $s . "<option> $i </option>";
            $s = $s . "</select>"; 
            return $s;
        }

        // creates a td element with the content and class desired
        function td($content, $className) {
            return "<td class = '$className' > $content </td>";
        }
    ?>

    <h1>Two Owls Cafe</h1>
    <h2>Your late night spot for cheep eats</h2>
    <h3>TAKEOUT ONLY</h3>
    <h4>Open daily from 7pm - 2am</h4>

    <form id="form" method="get" action="processOrder.php" target="_blank">
        <p class="FirstName"><label style="width: 333px;">First Name:</label> <input type="text" name='firstname' value="" /></p>
        <p class="LastName"><label style="width: 333px;">Last Name*:</label>  <input type="text" name='lastname' value=""/></p>
        <p class="SpecialInstructions"><label style="width: 333px;">Special Instructions:</label> <input type="text" name='instructions' value=""/></p>

        <table border="0" cellpadding="3">
            <tr>
                <th>Select Item</th>
                <th>Item Name</th>
                <th>Cost Each</th>
                <th>Total Cost</th>
            </tr>
            <?
                // Get the data from the database, and build a table with it
                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                $sql = "SELECT * FROM Items ORDER BY ItemNum ASC";
                $result = $conn->query($sql);
                $rows = $result->fetch_all(MYSQLI_ASSOC);

                $table = "";
                foreach ($rows as $row) {
                    $table = $table . "<tr>";
                    $table = $table . td(makeSelect("quan" . $row["ItemNum"], 0, 10),"selectQuantity");
                    $table = $table . td($row["ItemName"], "itemName");
                    $table = $table . td("$$row[Cost]", "cost");
                    $table = $table . td("$<input type='text' name='cost' readonly='true' value='0.00' />", "totalCost");
                }

                echo $table;
                $conn->close();
            ?>
        </table>
        <p class="subtotal"><label>Subtotal:</label> $ <input type="text" name='subtotal' id="subtotal" value="0.00" readonly='true'/></p>
        <p class="tax"><label>Mass tax 6.25%:</label> $ <input type="text" name='tax' id="tax" value="0.00" readonly='true'/></p>
        <p class="total"><label>Total:</label> $ <input type="text" name='total' id="total" value="0.00" readonly='true'/></p>
        <input type = "button" value = "Submit Order" onclick="return verify()"/>
    </form>

    <script>
        // stuff for updating costs when new quantities get clicked, gets all value
        // fields, then updates all onselect functions to update their respective
        // value field and then update the totals accordingly
        costs = document.getElementsByName("cost")
        cost_values = document.getElementsByClassName("cost")
        subtotal = document.getElementById("subtotal")
        tax = document.getElementById("tax")
        total = document.getElementById("total")
        mass_tax = .0625;

        
        // set onchange functions for all menu items
        for (i = 1; i <= costs.length + 1; i++) {
            x = document.getElementsByName("quan" + String(i))[0]
            function_call = "update_item_total(" + String(i - 1) + ", this.selectedIndex)"
            x.setAttribute("onchange",function_call)
        }
        
        // update the cost associated with the index that was updated
        function update_item_total(index, num_ordered) {
            costs[index].value = (num_ordered * parseFloat(cost_values[index].innerHTML.substring(cost_values[index].innerHTML.indexOf("$") + 1))).toFixed(2)
            update_totals()
        }
        
        // updates the totals for subtotal, tax, and total
        function update_totals() {
            sum = 0
            for (i = 0; i < costs.length; i++) {
                cost = parseFloat(costs[i].value)
                sum += cost 
            }
            subtotal.value = sum.toFixed(2)
            tax.value = (sum * mass_tax).toFixed(2)
            total.value = (parseFloat(subtotal.value) + parseFloat(tax.value)).toFixed(2) 
        }

        // verifies all information, and then makes new page and displays it, or
        // alerts the user that the info was bad
        function verify() {
            issue = false

            // last name check
            if (document.getElementsByName("lastname")[0].value == "") {
                issue = update_issue(issue, "You must provide a last name for the order!\n")
            }

            // Because I am doing the math all internally, if the total is greater than
            // 0 they have ordered something.. I know I could also do this by looping
            // through the selects and checking their values.
            if (parseFloat(total.value) <= 0) {
                issue = update_issue(issue, "You must order at least 1 item, do so by selecting a value on the left!\n")
            }

            // Check the timing to make sure the order fits the time window
            if (!time_check()){
                issue = update_issue(issue, "You can only place orders within 15 minutes of us opening, or closing.")
            }

            // if an issue was found, alert the user, otherwise give them the new page by submitting
            issue ? alert(issue) : document.getElementById("form").submit()
        }

        // checks if the time is not within 15 minutes of opening or closing,
        // returns false if the time is not within the range
        function time_check() {
            // TODO: remove this, its for testing purposes
            return true
            // making all new dates to ensure that the days are all the same, and
            // then comparison can be done on the hours and minutes.
            current_time = new Date()

            // cutoff times, not actual open/close times
            opening_time = new Date()
            closing_time = new Date()
            opening_time.setHours(18, 45, 0)
            closing_time.setHours(1, 45, 0)

            if(current_time.getTime() < closing_time.getTime() || current_time.getTime() > opening_time.getTime()){
                return true
            }
            return false
        }

        // if the issue is false, set it to the empty string so it can be appended
        function update_issue(issue, string) {
            if (!issue) issue = ""
            issue += string
            return issue
        }

        // NOT GOING TO WORK, uses menu items
        // create new page and display it, takes in the pickup/delivery time
        function display_order(time) {
            alert("We have recieved your order, and are working on it now. Thank you so much for choosing Jade Delight!")
            order_details = "<h1>Order Details:</h1><p>Items:<br />"
            
            for (i = 0; i < menuItems.length; i++) {
                // if they didn't order any of an item dont display it
                if (costs[i].value <= 0) continue
                order_details += document.getElementsByName("quan" + String(i))[0].value + 
                                 " x " + menuItems[i].name + " at $" + menuItems[i].cost.toFixed(2) + 
                                 " each, is $" + costs[i].value + "<br />"
            }
            
            order_details += "</p><p>subtotal: $" + subtotal.value + 
                             "<br />tax: $" + tax.value + 
                             "<br />total: $" + total.value + "</p>"
            
            // see comment above for the reasoning of this statement
            address_displayed ? order_details += "<p>We will deliver around " + time.toLocaleString() + "</p>" :
                                order_details += "<p>Your oder will be ready for pickup around " + time.toLocaleString() + "</p>"

            order_window = window.open("", "_blank")
            order_window.document.write(order_details)
        }
    </script>
</body>


</html>