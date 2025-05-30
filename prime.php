<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        function prim($x) {
            if ($x < 2) {
                return false;
            }
            for ($d = 2; $d * $d <= $x; $d++) {
                if ($x % $d == 0) {
                    return false;
                }
            }
            return true;
        }

        $pr = "";
        for ($i = 1; $i <= $_GET['val']; $i++) {
            $pr .= "$i ";
            if (prim($i)) {
                echo "<span style=\"color:red\">$i</span><br>\n";
            }
            else {
                echo "<span style=\"color:blue\">$i</span><br>\n";
            }
        }

        file_put_contents("prime.txt", $pr)
        // Nu merge
        // $file_content = file_get_contents("prime.txt");
        // echo $file_content;
    ?>
</body>
</html>