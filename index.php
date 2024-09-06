<?php
    require_once 'ComplexNumber.php';

    function calc(ComplexNumber $x, ComplexNumber $y, string $symbol): ComplexNumber {
        if ($symbol == '+') return $x->add($y);
        else if ($symbol == '-') return $x->subtract($y);
        else if ($symbol == '*') return $x->multiply($y);
        else return new ComplexNumber('1', '1');
    }
    
    function parseComplexNumber(string $str): array {
        $str = str_replace('i', '', $str);
        $arr = explode('+', $str);
        return $arr;
    }

    function createHistoryForm(ComplexNumber $x, ComplexNumber $y, string $symbol, string $result): string {
        return
        "<form action=\"\" method=\"post\" class=\"history__form\">
            <input name=\"action\" value=\"without\" hidden>
            <input name=\"x\" value=\"$x\" readonly class=\"history__input\">
            <input name=\"symbol\" value=\"$symbol\" readonly class=\"history__input\">
            <input name=\"y\" value=\"$y\" readonly class=\"history__input\">
            <input value=\"=\" readonly class=\"history__input\">
            <input value=\"$result\" readonly class=\"history__input\">
            <button type=\"submit\" class=\"history__button\">↩️</button>
        </form>";
    }
    
    list($x1, $x2) = parseComplexNumber($_POST['x'] ?? '1+1i');
    list($y1, $y2) = parseComplexNumber($_POST['y'] ?? '1+1i');
    
    $x = new ComplexNumber($x1, $x2);
    $y = new ComplexNumber($y1, $y2);
    $symbol = $_POST['symbol'] ?? '+';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['action'] == 'calc') {
            $array = [
                'x' => $_POST['x'],
                'y' => $_POST['y'],
                'symbol' => $_POST['symbol']
            ];
            $json = json_encode($array);
            $name = 'expression_' . time();
            setcookie($name, $json, time() + 60 * 30);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Calculator</title>
</head>
<body>
    <div class="container">
        <form action="" method="post" class="calc-form">
            <div class="calc-form__expression">
                <input name="action" value="calc" hidden>
                <input type="text" name="x" value="<?php echo $x; ?>" class="calc-form__input">
                <select name="symbol" class="calc-form__select">
                    <option value="+" <?php if ($symbol == '+') echo 'selected'; ?>>+</option>
                    <option value="-" <?php if ($symbol == '-') echo 'selected'; ?>>-</option>
                    <option value="*" <?php if ($symbol == '*') echo 'selected'; ?>>*</option>
                </select>
                <input type="text" name="y" value="<?php echo $y; ?>" class="calc-form__input">
            </div>
            <button type="submit" class="calc-form__button">=</button>
            <p class="calc-form__value"><?php echo calc($x, $y, $symbol); ?></p>
        </form>
        <div class="history">
            <?php
                $count = 0;
                foreach (array_reverse($_COOKIE) as $name => $value) {
                    if (str_starts_with($name, 'expression_') && $count < 5) {
                        $value = json_decode($value, true);

                        list($x1, $x2) = parseComplexNumber($value['x']);
                        list($y1, $y2) = parseComplexNumber($value['y']);

                        $x = new ComplexNumber($x1, $x2);
                        $y = new ComplexNumber($y1, $y2);

                        $result = calc($x, $y, $value['symbol']);

                        echo createHistoryForm($x, $y, $value['symbol'], $result);
                        $count++;
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>
