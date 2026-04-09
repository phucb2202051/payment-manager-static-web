<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/frame.css">
    <link rel="stylesheet" href="CSS/format.css">
    <link rel="stylesheet" href="CSS/color.css">
</head>
<body class="FText VioletThemes1 M0 Hor">


    <div class="Len HA JC">
        <div class="Hor">
            <?php  /* query.php */
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                require_once 'ExFunct/connection.php';
                require_once 'ExFunct/function.php';
                global $sv, $db;
                $selectedTable = $_POST['slOption'] ?? 'kind';
                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === "Insert") {
                    
                    /*lấy bảng mẫu select */
                    $clone = clone $table[$selectedTable];
                    
                    /*đưa dữ liệu vào bảng*/
                    foreach ($clone->atb as $key => $value) {
                        $clone->atb[$key] = $_POST[$key] ?? ""; 
                    }
                    
                    /*kiểm tra tính đúng đắn của input*/
                    $clone = $clone->getClone($clone->atb);
                    
                    if (isset($clone->atb['kindId']) && ($clone->atb['kindId'] == -1)) {
                        unset($clone->atb['kindId']);
                    }

                    if ($clone == null) {
                        echo "<div class= 'W400 HA BKLR'>
                                Lỗi: Vui lòng nhập đủ các trường bắt buộc </div>";
                    } 
                    else {
                        connect_DB($sv, $_SESSION['us'], $_SESSION['ps'] , $db);
                        echo "<div class= 'nmFr nmBder HvOr HvBig T10 L10 T4Gr fmHor fmLen'>"
                        .insertFromTable($clone->name, $clone->atb)
                        ."</div>";
                    }
                }
                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === "Select") {
                    $clone = clone $table[$selectedTable];
                    $condition = [];
                    foreach ($clone->atb as $key => $value) {
                        if ($_POST[$key."_operator"]!= "NONE")
                            $condition[$key] = [$_POST[$key."_operator"],$_POST[$key]];
                    }
                    connect_DB($sv,$_SESSION['us'],$_SESSION['ps'],$db);
                    $queryData = selectFromTable($selectedTable,[],$condition);
                    $jsonData = json_encode($queryData);
                    $encodedData = urlencode($jsonData);
                    echo "<script>window.open('alter.php?name=$clone->name&dataQuery=$encodedData', '_blank');</script>";
                }
            ?>
        </div>


    <form id="queryForm" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>"
        name="queryForm" class="W80pc minW600 H500 MLA MRA Len G5pc">


        <div class="W600 H260 Hor G12 AC MLA MRA">
            <div class="W120 H180 BRd1r Len G4 AC VioletBox HvNormal">

                <div><button name="action" value="Select" class="W80 H30 BRd5 TSdO TxB HvBig VioletButton">Select</button></div>
                <div><button name="action" value="Insert" class="W80 H30 BRd5 TSdO TXB HvBig VioletButton">Insert</button></div>

                <select name="slOption" id="slOption" class="W80 H30 BRd5 MT14 TSdO TxB HvBig VioletButton" onchange="submitChange()">
                    <?php   $selected = $_POST['slOption'] ?? 'kind';   ?>
                    <option value="kind" <?= $selected === 'kind' ? 'selected' : '' ?>>Kind</option>
                    <option value="payment" <?= $selected === 'payment' ? 'selected' : '' ?>>Payment</option>
                </select>

            </div>

            <div id="input" class="H240 W400 VioletBox BRd1r Len G5pc HvNormal">
                <?php /*Hiển thị các dòng nhập liệu*/
                    require_once 'ExFunct/connection.php';
                    require_once 'ExFunct/function.php';
                    global $table;
                    $selectedTable = $_POST['slOption'] ?? 'kind';
                    showInput($table[$selectedTable]);
                ?>
            </div>
        </div>



    </form>
    </div>
    
    <div class="HvSlider H100pc W160 BKLP BL10">
            <Label id="ActiveSlider">◀</Label>
            <div class="Len W50pc AC JC MLA MRA G14">
                <button class="VioletButton W100 H30 TSdO TxB" onclick="returnLogin()">Login</button>
                <button class="VioletButton W100 H30 TSdO TxB" onclick="toStatictical()">Statistical</button>
            </div>
    </div>

</body>


<script>

function submitChange() {
     document.getElementById('queryForm').submit();
}
function returnLogin() {
    history.replaceState(null, "", location.href);
    window.location.replace("index.php");
}
function toStatictical() {
    window.open('statistical.php', '_blank');
}


</script>  

<style>
#ActiveSlider{
    position: relative;
    top: 50%;
    transform: translateY(-50%);
    left: -14px;
    cursor: pointer;
}
</style>

</html>