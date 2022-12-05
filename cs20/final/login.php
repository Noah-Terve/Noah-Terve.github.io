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
            background-image: url("./media/header/orders.jpg");
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
            <h1>Log in</h1>
        </div>
    </div>

    <?php

        $username = $_REQUEST["user"];
        $password = $_REQUEST["pass"];
        

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

        if ($result == NULL) {
            //add user to DB, create session
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            if ($conn->query($sql) === TRUE) {
                echo "added new login, you are now logged in";
                session_start();
                $_SESSION['username'] = $username;

                //echo "<script>history.back(3)</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } 
        else {
            $user = $result->fetch_all(MYSQLI_ASSOC);
            $db_pass = $user[0]["password"];
            if ($db_pass == $password) {
                echo "password correct, you are now logged in";
                session_start();
                $_SESSION['username'] = $username;
                
                //echo "<script>history.back(3)</script>";
            }
            else {
                echo "incorrect password. try again";
            }
        }
        // close database connection
        $conn->close();

    
    ?>

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