
<?php   /* connection.php */
require_once 'class.php';
require_once 'var.inc';

function selectStatistical(array $conditions = [])
{
    global $connect;

    $sql = "SELECT amount, paymentDay FROM `payment` WHERE paymentDay BETWEEN ? AND ?";
    
    if (!($stmt = $connect->prepare($sql))) {
        throw new Exception("Lỗi khi chuẩn bị truy vấn: " . $connect->error);
    }

    $stmt->bind_param('ss', $conditions['paymentDayStart'], $conditions['paymentDayEnd']);



    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }


    return $data;
}

function selectFromTable(string $table, array $columns = ["*"], array $conditions = [])
{
    global $connect;
    $columnList = empty($columns) || !is_array($columns) ? "*" : implode(", ", $columns);

    $whereClause = "";
    $values = [];
    $types = ""; // Chuỗi kiểu dữ liệu cho bind_param

    if (!empty($conditions)) {
        $whereParts = [];

        foreach ($conditions as $column => $condition) {
            if (is_array($condition) && count($condition) === 2) {
                list($operator, $value) = $condition;
                
                if ($operator === "LIKE") {
                    $value = "%".$value."%";
                }

                $whereParts[] = "`$column` $operator ?";
                $values[] = $value;

                // Xác định kiểu dữ liệu cho bind_param
                if ($value instanceof DateTime) {
                    $values[count($values) - 1] = $value->format('Y-m-d H:i:s');
                    $types .= "s";
                } elseif (is_int($value)) {
                    $types .= "i";
                } elseif (is_float($value)) {
                    $types .= "d";
                } else {
                    $types .= "s";
                }
            }
        
        $whereClause = " WHERE " . implode(" AND ", $whereParts);
        }
    }

    $sql = "SELECT $columnList FROM `$table` $whereClause";
    if (!($stmt = $connect->prepare($sql))) {
        throw new Exception("Lỗi khi chuẩn bị truy vấn: " . $connect->error);
    }

    // Bind các giá trị nếu có điều kiện
    if (!empty($conditions)) {
        $stmt->bind_param($types, ...$values);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    return $data;
}

function deleteFromTable(string $tableName, int $id)
{
    global $connect;

    try {
        $query = "DELETE FROM $tableName WHERE id = ?";

        $stmt = $connect->prepare($query);
        if (!$stmt) {
            throw new Exception("Lỗi chuẩn bị truy vấn: " . $connect->error);
        }

        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            throw new Exception("Lỗi khi thực thi truy vấn: " . $stmt->error);
        }

        $stmt->affected_rows;
        $stmt->close();

        return 1;
    } catch (Exception $e) {
        echo "Xóa thất bại: " . $e->getMessage();
        return -1;
    }
}

function updateFromTable(string $tableName, array $data, int $id)
{
    global $connect;
    try {
        $columns = array_keys($data);
        $setClause = implode(", ", array_map(fn($col) => "$col = ?", $columns));
        $sql = "UPDATE $tableName SET $setClause WHERE id = ?";

        $stmt = $connect->prepare($sql);
        if (!$stmt) {
            return "Lỗi: " . $connect->error;
        }

        $types = "";
        $values = [];

        foreach ($data as $value) {
            if (is_int($value)) {
                $types .= "i";
            } elseif (is_float($value)) {
                $types .= "d";
            } else {
                $types .= "s";
            }
            $values[] = $value;
        }

        $types .= "i"; 
        $values[] = $id;

        $stmt->bind_param($types, ...$values);
        $stmt->execute();
        $stmt->close();
        return 1;
    } catch (Exception $e) {
        echo "Lỗi khi thay đổi dữ liệu: " . $e->getMessage();
        return -1;
    }
}

function insertFromTable(string $tableName, array $data)
{
    global $connect;
    unset($data['id']);
    $columns = array_keys($data);
    $placeholders = implode(", ", array_fill(0, count($columns), "?"));
    $columnString = implode(", ", $columns);
    $sql = "INSERT INTO $tableName ($columnString) VALUES ($placeholders)";
    
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $stmt = $connect->prepare($sql);
        $types = "";
        $values = [];

        foreach ($data as $key => $value) {
            $types .= is_int($value) ? "i" : (is_float($value) ? "d" : "s");
            $values[] = $value;
        }

        $stmt->bind_param($types, ...$values);
        $stmt->execute();
        $stmt->close();
        return "Thêm thành công";
    } catch (mysqli_sql_exception $e) { 
        return "Thêm thất bại: " . $e->getMessage(); 
    }
}

function connect_DB($sv, $us, $ps, $db)
{
    global $connect;

    if ($connect == null) {
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Kích hoạt Exception
            $connect = new mysqli($sv, $us, $ps, $db);
            return "Kết nối tới Cơ sở dữ liệu thành công!";
        } catch (mysqli_sql_exception $e) { 
            return "Kết nối tới cơ sở dữ liệu thất bại: \n" . $e->getMessage(); 
        }
    }
}

?>
