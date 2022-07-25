<html>
    <body>
        <?php
            for ( $i = 1; $i <= 5; $i++) {
                echo "Hello World!" .$i."<br/>";
            }

            echo "<br><br>"; //not recommended

            $x = array ("one", "two", "three");
            foreach ( $x as $value ) {
                echo $value . "<br/>";
            }
        ?>
    </body>
</html>