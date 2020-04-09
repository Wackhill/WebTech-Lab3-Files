<!DOCTYPE html>
<html>
<head>
<style>
    body {
        font-family: Arial;
        margin: 0;
    }

    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        background-color: #f1f1f1;
        position: fixed;
        height: 100%;
        width: 25%;
        overflow: auto;
    }

    li a {
        display: block;
        color: #000;
        padding: 8px 16px;
        text-decoration: none;
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

    .active {
        background-color: #4CAF50;
    }

    .add-button {
        background-color: #019ADE;
    }

    .left-box {
        background-color: white;
        width: 25%;
        float: left;
    }
  
    .right-box {
        background-color: white;
        width: 75%;
        float: right;
    }

</style>

<?php
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

    function generate_menu($products_list, $selected_id) {
        echo "<ul>";
        for ($i = 0; $i < count($products_list); $i++) {
            echo "<li>";
                if($i <> $selected_id) {
                    echo "<a href=\"index.php?id=$i\">";
                    echo $products_list[$i][1];
                    echo "</a>";
                } elseif($i == $selected_id) {
                    echo "<a style=\"background-color: #4CAF50\">";
                    echo $products_list[$selected_id][1];
                    echo "</a>";
                }
            echo "</li>";
        }
        echo "</ul>";
        return 1;
    }

    function show_product_info($product_info) {
        echo "<div style=\"margin-left: 30%; width: 70%\">";
        echo "<p1><b>ID продукта:</b> $product_info[0]</p1><br>";
        echo "<p1><b>Название:</b> $product_info[1]</p1><br>";
        echo "<p1><b>Стоимость:</b> $product_info[2]</p1><br>";
        echo "<p1><b>Скидка 80%: </b>";
        echo round($product_info[2] * 0.8, 2);
        echo "</p1><br>";
        echo "<p1><b>Описание:</b> $product_info[3]</p1><br>";
        echo "<p1><b>Дата добавления:</b> $product_info[4]</p1><br>";
        echo "</div>";
        return 1;
    }
?>

</head>

<body>
    <?php
        $products_list = get_products_list();
        
        echo "<form action=\"addition.php\">";
        echo "<input style=\"width: 25%\" type=\"submit\" name=\"add\" value=\"Добавить\" href=\"index.htm\">";
        echo "</form>";        
        
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            generate_menu($products_list, $id);
            show_product_info($products_list[$id]);
        }
        else {
            $id = 0;
            generate_menu($products_list, $id);
            show_product_info($products_list[$id]);
        }

    ?>

</body>
</html>