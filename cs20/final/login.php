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
            background-image: url("./media/header/home.jpg");
        }
    </style>
</head>

<body>
    <?php
        $username = $_REQUEST["user"];
        $password = $_REQUEST["pass"];

        // If the username is empty, they are coming from another page, because
        // we force them to submit the username with a value from this page. 
        // if they come from another page we shouldn't try to log them in.
        if (!empty($username)) {
            // if user has not logged in though they would have to actively navigate
            // to this page as we don't display it anymore once you log in.
            if (empty($_SESSION['username'])) {
                login_user($username, $password);
            }
        }

        function login_user($username, $password){

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
            $sql = "SELECT * FROM users WHERE username='$username'";
            $result = $conn->query($sql);
            $results = $result->fetch_all(MYSQLI_ASSOC);

            //TODO: Handling multiple users with the same username requires for loop over
            // all entries in array. Then, if not found either prompt for if they are a new
            // user, or change the form to have that included...
            if ($result->num_rows == 0) {
                //add user to DB, create session
                $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
                $result = $conn->query($sql);
                
                if ($result == TRUE) {
                    $_SESSION['username'] = $username;
                    echo "<script> alert(\"Created a new user, you are now logged in\"); location.href='./orders.php'; </script>";
                } else {
                    echo "<script> alert(\"We ran into an issue, please try again soon\"); console.log(Error: "
                            . $sql . "<br>" . $conn->error . ") </script>";
                }
            } 
            else {
                $db_pass = $results[0]["password"];

                //TODO: check over all passwords in case multiple people have same username
                if ($db_pass == $password) {
                    $_SESSION['username'] = $username;
                    echo "<script> alert(\"Password correct, you are now logged in\"); location.href='./orders.php'; </script>";
                }
                else {
                    echo "<script> alert(\"Incorrect password, please try again\"); </script>";
                }
            }
            // close database connection
            $conn->close();
        }
    
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
                <?php
                    if (empty($_SESSION['username'])) echo ("<li><a href=\"./login.php\">Log In</a></li>");
                    else echo("<li><a href=\"./orders.php\">My Cart</a></li><li><a href=\"./orders.php\">My Orders</a></li><li><a href=\"./logout.php\">Log Out</a></li>");
                ?>
            </ul>
        </div>
    </header>

    <div class="backdrop">
        <div class="multi-drop">
            <h1>Log in</h1>
        </div>
    </div>


    <script> 
        function validateLogin() {
            validLogin = false;
            var user = document.getElementById("user").value;
            var pass = document.getElementById("pass").value;
            if (user == "" || pass == "") {
                alert("Please enter your first and last name.");
            } else if (user.length > 20 || pass.length > 40) {
                alert("username or password is too long. There is a 20/40 character\
                limit respectively on user/pass");
            }
            else {
                validLogin = true;
            }
            if (validLogin) {
                document.getElementById('login_form').submit();
            }
        }
    </script>

    <div class="form box">
        <form method="post" name="form" id="login_form" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="text" id="user" name="user" placeholder="username">
            <br>
            <input type="text" id="pass" name="pass" placeholder="password">
            <br>
            <input type="button" value="login" name="login" onclick="validateLogin()">
            <br>
        </form>
    </div>

    

    <!-- <footer>
        <p>&copy; Hain's Delivery 2020</p>
        test junk here
    </footer> -->

</body>

</html>