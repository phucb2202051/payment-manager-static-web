<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/frame.css">
    <link rel="stylesheet" href="CSS/format.css">
    <link rel="stylesheet" href="CSS/color.css">
</head>
<body class="FText BlackThemes">
    <div class="W80pc H100pc Len AC JC MLA MRA">


        <form id="LoginForm" method="post" class="W400 H500 Len JC AC BK BlackBox MLA MRA">

            <h1 class="Tx40 TxB">Payment Manager</h1>
            
            <div class="W80pc 50pc MB35pc Len G6">

                <label for="user">Name</label>
                <input id="us" type="text" name="us" class="W80pc HvBig BdB BRd10 HvBdDY FcBdDY TSdO">
                <label for="user">Password</label>
                <input id="pass" type="password" name="pass" class="W80pc HvBig BdB BRd10 HvBdDY FcBdDY TSdO">
                <button class="W100 H30 MT20 HvBig TxB BdB BRd10 BKLB HvBdDY VtgButton TSdO">Login</button>

            </div>

        </form>

        <div class="WA HA BKLB BdB MLA MRA">
            <?php
                /*Kết nối tới DataBase*/
                include 'ExFunct/connection.php';
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pass']) && !empty(trim($_POST['pass']))) {
                    global $sv, $db, $connect;
                    $password = trim($_POST['pass']);
                    $user = trim($_POST['us']);
                    echo connect_DB($sv, $user, $password, $db); 
                    if (!is_null($connect)) {
                        $_SESSION['us'] = $user;
                        $_SESSION['ps'] = $password;
                        header("Location: query.php");
                        exit();
                    }
                }
            ?>
        </div>




    </div>
</body>
</html>