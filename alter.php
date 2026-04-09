<?php /*alter.php*/
    session_start();
    $decodedData = urldecode($_GET['dataQuery']);
    $dataQuery = json_decode($decodedData, true);
    $name = $_GET['name'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/color.css">
    <link rel="stylesheet" href="CSS/format.css">
    <link rel="stylesheet" href="CSS/frame.css">
</head>
<body class="VtgThemes Len Hor JC AC">
    <div class="W80pc HA Len AC MinW800">

        <div>
            <?php
                require_once 'ExFunct/connection.php';
                require_once 'ExFunct/function.php';
                global $sv, $us, $db;
                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === "Delete") {
                    connect_DB($sv,$us,$_SESSION['ps'],$db);
                    $stateDel = false;
                    $id = $_POST['id'];
                    if (deleteFromTable($name,(int)$id) != -1){
                        $stateDel = true;
                        $pos = 0;
                        foreach($dataQuery as $row){
                            if ($row["id"] == $id){
                                unset($dataQuery[$pos]);
                                break;
                            }
                            $pos++;
                        }
                        $dataQuery = array_values($dataQuery);

                    }
                    $jsonData = json_encode($dataQuery);
                    $encodedData = urlencode($jsonData);
                    header("Location: alter.php?name=$name&stateDel=$stateDel&dataQuery=$encodedData");
                }
                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === "Alter") {
                    $stateAlter = false;
                    $clone = clone $table[$name];
                    foreach ($clone->atb as $key=>$value)
                        $clone->atb[$key] = $_POST[$key];
                    $clone = $clone->getClone($clone->atb);
                    if ($clone == null)
                        echo "Vui lòng nhập đầy đủ các trường bắt buộc";
                    else{
                        $id = (int) $_POST["id"];
                        connect_DB($sv,$us,$_SESSION['ps'],$db);
                        if (updateFromTable($name,$clone->atb,$id) != -1)
                        {
                            $stateAlter = true;
                            $pos = 0;
                            foreach($dataQuery as $row){
                                if ($row["id"] == $id){
                                    $dataQuery[$pos] = $clone->atb;
                                    break;
                                }
                                $pos++;
                            }
                        }
                    }
                        
                    $jsonData = json_encode($dataQuery);
                    $encodedData = urlencode($jsonData);
                    header("Location: alter.php?name=$name&stateAlter=$stateAlter&dataQuery=$encodedData");
                }
            ?>           

        </div>

        <div>
            <?php
                if (isset($_GET['stateDel']))
                    if ($_GET['stateDel']) echo "Xóa thành công";
                    else echo "Xóa thất bại";
                
                if (isset($_GET['stateAlter']))
                    if ($_GET['stateAlter']) echo "Sửa thành công";
                    else echo "Sửa thất bại";
            ?>
        </div>


        <table class="VtgBox BRd1r P20">
            <?php
                require_once 'ExFunct/function.php';
                if (isset($dataQuery) && is_array($dataQuery) && !empty($dataQuery)){
                    showColumn($dataQuery[0]);
                    foreach($dataQuery as $row)
                        showRow($row);
                    }
                else   echo "Không có gì để hiển thị";
            ?>
        </table>


    </div>    



</body>
</html>