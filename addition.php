<!DOCTYPE html>
<html>
<head>
<style>
    body {
        font-family: Arial;
        margin: 0;
    }

    textarea {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        resize: none;
    }

    input[type=submit] {
        width: 100%;
        background-color: #019ADE;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

</style>

<?php
    function is_number($number) {
        $is_okay = true;
        for ($i = 0; ($i < strlen($number)) && $is_okay; $i++) {
            if (!(($number[$i] >= '0' && $number[$i] <= '9') || ($number[$i] <= '.'))) {
                $is_okay = false;
            }
        }
        return $is_okay;
    }

    function has_commas($line) {
        if (strlen($line) == 0 || strpos($line, ',')) {
            return true;
        }
        else {
            return false;
        }
    }

    function get_products_list() {
        $products_list = array();
        $products_file_handle = fopen('products.csv', 'r');
        if ($products_file_handle) {
            while (($cur_product_info = fgets($products_file_handle)) !== false) {
                $products_list[] = explode(',', $cur_product_info);
            }
            fclose($products_file_handle);
            return $products_list;
        }
        return null;
    }

    function make_editable_fields($products_list) {
        $new_product = array();
        echo "<div style=\"margin-left: 15%; margin-top: 5%; width: 70%\">";
        echo "<form method=\"POST\">";
        echo "<p1>ID продукта: ";
        echo count($products_list);
        echo "</p1><br><br>";

        echo "<label for=\"product_name\">Название продукта:</label>";  
        echo "<textarea rows='1' name='product_name' placeholder='Название продукта...'>";
        if (isset($_POST['product_name'])) { echo $_POST['product_name'];}
        echo "</textarea>";

        echo "<label for=\"product_price\">Стоимость:</label>";  
        echo "<textarea rows='1' name='product_price' placeholder='Стоимость продукта...'>";
        if (isset($_POST['product_price'])) { echo $_POST['product_price'];}
        echo "</textarea>";

        echo "<label for=\"product_description\">Описание:</label>";  
        echo "<textarea rows='3' name='product_description' placeholder='Описание продукта...'>";
        if (isset($_POST['product_description'])) { echo $_POST['product_description'];}
        echo "</textarea>";

        echo "<p1>Дата добавления: ";
        date_default_timezone_set('Europe/Minsk');
        $date = date('d:m:Y', time());
        echo $date;
        echo "</p1><br><br>";

        echo "<input type=\"submit\" name=\"submit\" value=\"Подтвердить\" action=\"index.php\">";
        if (isset($_POST['submit'])) {
            if (strlen($_POST['product_name']) > 0 && 
                is_number($_POST['product_price']) &&
                !has_commas($_POST['product_description'])) {
                $new_product[] = count($products_list);
                $new_product[] = $_POST['product_name'];
                $new_product[] = $_POST['product_price'];
                $new_product[] = $_POST['product_description'];
                $new_product[] = $date;

                $products_file_handle = fopen('products.csv', 'a');
                if (count($products_list) > 0) {
                    fwrite($products_file_handle, "\n");
                }
                fwrite($products_file_handle, implode(',', $new_product));
                fclose($products_file_handle);

                echo "<script>window.location.replace(\"index.php\");</script>";
            }
            else {
                echo "Заполните поля в соответствии с их логическим типом!";
                echo "<br>";    
                echo "Использовать запятые запрещено из-за требований хранения данных.";
            }
        }
        echo "</div>";
    }
?>

</head>
<body>
    <?php
        $products_list = get_products_list();
        make_editable_fields($products_list);
    ?>
</body>
</html>