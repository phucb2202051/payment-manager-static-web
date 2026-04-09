<?php   /*function.php*/
require_once 'class.php';
$atbLabel=[];
$atbInput=[];
$table = [
    "kind" => new kind("kind"),
    "payment" => new payment("payment")
];
$action = null;
function showInput(Table $content)
{
    foreach ($content->atb as $key => $value) {
        if (is_int($value)) {
            $type = "number";
            $options = "<option value='NONE'>NONE</option>
                        <option value='>'>></option>
                        <option value='<'><</option>
                        <option value='='>=</option>";
        } elseif ($value instanceof DateTime) {
            $type = "datetime-local";
            $options = "<option value='NONE'>NONE</option>
                        <option value='>'>></option>
                        <option value='<'><</option>
                        <option value='='>=</option>";
        } else {
            $type = "text";
            $options = "<option value='NONE'>NONE</option>
                        <option value='LIKE'>LIKE</option>";
        }

        // Xử lý giá trị hiển thị
        $formattedValue = "";
        if (in_array($key,$content->numAtb))
            $formattedValue = -1;
        else if ($value instanceof DateTime) 
            $formattedValue = (new DateTime())->format('Y-m-d\TH:i');

        // In HTML
        echo "<div class='Hor W100pc AC G4'>
                <label class='W120 TxR TSdO TxB' for='$key'>$key</label>
                <select class='MaxW70 TSdO TxB B3 BdLB HvBKLB HvBdB HvBig' name='{$key}_operator'>$options</select>
                <input class='MaxW240 MR15 TSdO TxB B3 BdLB HvBKLB HvBdB HvBig' type='$type' id='$key' name='$key' value='$formattedValue'"
              ."></div>";
    }
}

function showRow(array $atb) 
{
    echo "<tr class='HvBKG HvNormal'>";
    echo "<form method='post' action=''>";
    echo "<td><button type='submit' class='HvBig W70 TSdO VtgButton' name='action' value='Alter'>Alter</button></td>";
    echo "<td><button type='submit' class='HvBig W70 TSdO VtgButton' name='action' value='Delete'>Delete</button></td>";
    // Quy định chiều rộng của các input theo key
    $widths = [
        "id" => "W40",
        "kindId" => "W40",
        "note" => "W240",
        "paymentDay" => "W180",
        "beneficiary" => "W240",
        "default" => "W100"
    ];

    foreach ($atb as $key => $value) {
        // Xác định type của input
        $type = "text"; 
        if (is_numeric($value)) {
            $type = "number";
        } elseif (strtotime($value) !== false) { // Kiểm tra xem có phải ngày tháng không
            $type = "datetime-local";
            $value = date("Y-m-d\TH:i", strtotime($value));
        }

        // Xác định class CSS theo key
        $class = $widths[$key] ?? $widths["default"];
        
        // Nếu là ID thì readonly
        $readonly = ($key === "id") ? "readonly" : "";
        
        echo "<td><input class='$class TSdO' type='$type' name='$key' value='$value' $readonly></td>";
    }

    echo "</form>";
    echo "</tr>";
}

function showColumn(array $atb) 
{
    echo "<thead><tr>";
    echo "<th class='W70'></th><th class='W70'></th>";
    $widthMap = [
        "id"         => "W40",
        "kindId"     => "W40",
        "note"       => "W240",
        "paymentDay" => "W180",
        "beneficiary" => "W240"
    ];

    foreach ($atb as $key => $value) {
        $widthClass = $widthMap[$key] ?? "W100"; 
        echo "<th class='{$widthClass} TSdO TxB'>$key</th>";
    }

    echo "</tr></thead>";
}

function showDay(){
    $formattedValue = (new DateTime())->format('Y-m-d');
    echo "<div class='Hor W100pc AC Len G20'>";

    echo "<div class='W100pc AC Hor G14 TxR'>";
    echo "<label class='W120 TSdO TxB' for='dayFrom'>Start Day</label>";
    echo "<input class='MaxW240 MR15 TSdO TxB B3 BdLB HvBKLB HvBdB HvBig' type='date' id='Start' name='Start' value='$formattedValue'>";
    echo "</div>";

    echo "<div class='W100pc AC Hor G14 TxR'>";
    echo "<label class='W120 TSdO TxB' for='dayTo'>End Day</label>";
    echo "<input class='MaxW240 MR15 TSdO TxB B3 BdLB HvBKLB HvBdB HvBig' type='date' id='End' name='End' value='$formattedValue'>";
    echo "</div>";
    
    echo "</div>";
}

function showMonth(){
    $formattedValue = (new DateTime())->format('Y-m');
    echo "<div class='Hor W100pc AC Len G20'>";

    echo "<div class='W100pc AC Hor G14 TxR'>";
    echo "<label class='W120 TSdO TxB' for='monthFrom'>Start Month</label>";
    echo "<input class='MaxW240 MR15 TSdO TxB B3 BdLB HvBKLB HvBdB HvBig' type='month' id='Start' name='Start' value='$formattedValue'>";
    echo "</div>";

    echo "<div class='W100pc AC Hor G14 TxR'>";
    echo "<label class='W120 TSdO TxB' for='monthTo'>End Month</label>";
    echo "<input class='MaxW240 MR15 TSdO TxB B3 BdLB HvBKLB HvBdB HvBig' type='month' id='End' name='End' value='$formattedValue'>";
    echo "</div>";

    echo "</div>";
}
?>