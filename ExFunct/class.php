<?php   /*class.php*/
class Table {
    public $name = "";
    public $atb = [];
    public $cons = [];
    public $numAtb = [];
    public function __construct(string $Tname)
    {
        $this->name = $Tname;
    }

    public function getClone(array $Tatb)
    {
        $clone = clone $this;
    
        foreach ($Tatb as $key => $value) {
            if (in_array($key, $clone->cons) && 
                (   (in_array($key, $clone->numAtb) && $value == -1 ) ||
                    empty($value) || trim($value) === "")) {
                return null;
            }
    
            // Xác định kiểu dữ liệu gốc của thuộc tính trong atb
            $originalType = gettype($clone->atb[$key]);
    
            // Ép kiểu về đúng dữ liệu gốc
            switch ($originalType) {
                case 'integer':
                    $clone->atb[$key] = is_numeric($value) ? (int) $value : null;
                    break;
                case 'double': // float
                    $clone->atb[$key] = is_numeric($value) ? (float) $value : null;
                    break;
                case 'boolean':
                    $clone->atb[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                    break;
                case 'array':
                    $clone->atb[$key] = is_array($value) ? $value : json_decode($value, true);
                    break;
                case 'object':
                    if ($clone->atb[$key] instanceof DateTime) {
                        try {
                            $clone->atb[$key] = new DateTime($value);
                        } catch (Exception $e) {
                            $clone->atb[$key] = null;
                        }
                    }
                    break;
                case 'NULL':
                    $clone->atb[$key] = empty($value) ? null : $value;
                    break;
                default: // string hoặc các kiểu khác
                    $clone->atb[$key] = (string) $value;
                    break;
            }
        }
        return $clone;
    }
    
}

class Kind extends Table {
    public function __construct()
    {
        parent::__construct("kind");
        $this->cons = ["beneficiary"];
        $this->atb = [
            "id" => -1,
            "beneficiary" => ""
        ];
        $this->numAtb = ["id"];
    }
}

class Payment extends Table {
    public function __construct()
    {
        parent::__construct("payment");
        $this->cons = ["amount"];
        $this->atb = [
            "id" => -1,
            "kindId" => -1,
            "amount" => 0,
            "paymentDay" => new DateTime(),
            "note" => ""
        ];
        $this->numAtb = ["id","kindId","amount"];
    }
}
?>
