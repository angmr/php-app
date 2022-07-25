<html>
    <body>
        <?php
            function add($x,$y) {
                $total = $x + $y ;
                return $total;
            }
            echo "1 + 16 =" . add(1,16);
        ?>
        <br>
        <br>
        <?php
            function add1($x,$y) {
                global $z; // Global variable.
                $total = $x + $y + $z;
                return $total;
            }
            $z = 5;
            echo "1 + 16 = " . add1(1,16);
        ?>

    </body>
</html>