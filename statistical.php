<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/frame.css">
    <link rel="stylesheet" href="CSS/format.css">
    <link rel="stylesheet" href="CSS/color.css">
</head>
<body class="FText VioletThemes1 M0 Len JC">


    <div class="W80pc H100pc Len JC MLA MRA">

        <div>
            <?php  /* query.php */
                session_start();
                require_once 'ExFunct/connection.php';
                require_once 'ExFunct/function.php';
                global $sv, $db;
                $selected = $_POST['slOption'] ?? 'day';
                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === "Select") {
                    $Start = $_POST['Start'] ?? null;
                    $End = $_POST['End'] ?? null;
                    $condition = [
                        'paymentDayStart' => (new DateTime($Start))->format('Y-m-d 00:00:00'),
                        'paymentDayEnd' => (new DateTime($End))->format('Y-m-d 23:59:59')
                    ];
                    connect_DB($sv,$_SESSION['us'],$_SESSION['ps'],$db);
                    $queryData = selectStatistical($condition);
                    for ($i =0; $i < count($queryData); $i++){
                        if ($_POST['slOption'] == 'day') {
                            $queryData[$i]['paymentDay'] = (new DateTime($queryData[$i]['paymentDay']))->format('Y-m-d');
                        } else if ($_POST['slOption'] == 'month') {
                            $queryData[$i]['paymentDay'] = (new DateTime($queryData[$i]['paymentDay']))->format('Y-m');
                        }
                    }
                    $jsonData = json_encode($queryData);
                    $encodedData = urlencode($jsonData);
                    echo "<script>window.open('watch.html?type=$selected&&dataQuery=$encodedData', '_blank');</script>";
                }
            ?>
        </div>



        <form id="queryForm" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>"
            name="queryForm" class="W80pc minW600 H500 MLA MRA G5pc Hor JC AC">


            <div class="W120 H180 BRd1r Len G4 AC VioletBox HvNormal">

                    <div><button name="action" value="Select" class="W80 H30 BRd5 TSdO TxB HvBig VioletButton">Statistical</button></div>
                    <?php   $selected = $_POST['slOption'] ?? 'day';   ?>
                    <select name="slOption" id="slOption" class="W80 H30 BRd5 MT14 TSdO TxB HvBig VioletButton" onchange="submitChange()">
                        <option value="day" <?= ($selected === 'day') ? 'selected="selected"' : ''; ?>>Day</option>
                        <option value="month" <?= ($selected === 'month') ? 'selected="selected"' : ''; ?>>Month</option>
                    </select>

            </div>


            <div id="input" class="H240 W400 VioletBox BRd1r Len G5pc HvNormal">
                <?php /*Hiển thị các dòng nhập liệu*/
                    require_once 'ExFunct/connection.php';
                    require_once 'ExFunct/function.php';
                    $selected = $_POST['slOption'] ?? 'day';
                    if ($selected == 'day')   {showDay();}
                    else if ($selected == 'month')  {showMonth();}
                ?>
            </div>


        </form>
    </div>
</body>
<script>
    function submitChange (){
        document.getElementById('queryForm').submit();
    }

</script>
</html>