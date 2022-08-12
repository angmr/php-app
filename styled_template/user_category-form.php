<?php include 'header-script.php'; ?>

<?php
    function saveUserCategory($data){
        global $user_category;

        $data_to_save = json_decode(json_encode($data));
        $result = $user_category -> createUsercategory($data_to_save);
        return $result;
    }

    function updateUserCategory($data){
        global $user_category;

        $data_to_save = json_decode(json_encode($data));
        $result = $user_category -> updateUsercategory($data_to_save);
        return $result;
    }

    function deleteUserCategory($data){
        global $user_category;

        $result = $user_category -> deleteUsercategory($data);
        return $result;
    }

    $nameErr = $identifierErr = "";
    $name = $identifier = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if(empty($_POST['id'])){
            $update = false;
        } else {
            $update = true;
        }

        if (empty($_POST["name"])){
            $nameErr = "Name is required";
        } else {
            if(!preg_match("/^[a-zA-Z\p{Greek}\s]+$/u", $_POST["name"])){
                $nameErr = "Invalid name format";
            }
        }
        
        if (empty($_POST["identifier"])){
            $identifierErr = "Identifier is required";
        } else {
            if (!is_numeric($_POST["identifier"])){
                $identifierErr = "Invalid identifier format: only digits allowed";
            }
        }

        if(empty($nameErr) && empty($identifierErr)){
            if ($update) {
                $data = array(
                    '_id' => $_POST['id'],
                    'identifier' => $_POST['identifier'],
                    'name' => $_POST['name']
                );

                $result = updateUserCategory($data);

            } else {
                $data = array(
                    'identifier' => $_POST["identifier"],
                    'name' => $_POST["name"]
                );

                $result = saveUserCategory($data);
                $result = json_decode($result, true);

                if (!$result['success']){
                    $alert = trim($result['data'], '"');
                } else {
                    $alert = "";
                }
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "GET"){
        if (isset($_GET['id']) && !empty($_GET['id'])){
            $id = $_GET['id'];
            $result = deleteUserCategory($id);
        }
    }

    $data = json_decode($user_category -> showUsercategories(), true);
    $data = json_decode($data['data'], true);
?>

<?php include 'header.php'; ?>
    <div class="container mt-4">
        <h2>Εισαγωγή νέας Κατηγορίας Χρήστη</h2>
        <?php
            if (isset($alert) && !empty($alert)) {
        ?>
            <div class="alert alert-danger" role="alert">
            <?php echo $alert; ?>
            </div>
        <?php
            }
        ?>
        
        <p><span class="text-danger">* required field</span></p>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="mb-3">
                <label for="identifier" class="form-label">Identifier</label>
                <input type="text" class="form-control" id="identifier" name="identifier" aria-describedby="emailHelp" value="<?php echo $identifier; ?>">
                <span class="text-danger">*<?php echo $identifierErr; ?></span>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
                <span class="text-danger">*<?php echo $nameErr; ?></span>
            </div>
            <input type='hidden' name='id' id='id' value=''>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <hr>

        <table class='table table-striped'>
            <tr>
                <th>Αναγνωριστικό Κατηγορίας</th>
                <th>Όνομα Κατηγορίας</th>
                <th>Διαδικασίες</th>
            </tr>
            <?php
                foreach ($data as $value){
                    echo "<tr>";
                        echo "<td>".$value['identifier']."</td>";
                        echo "<td>".$value['name']."</td>";
                        echo "<td>";
                ?>      
                        <button class="btn btn-primary" onclick="loadForm(<?php echo '\''.$value['_id']['$oid'].'\',\''.$value['name'].'\',\''.$value['identifier'].'\''?>)">Update</button>
                        <form method="delete" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <input type="hidden" name="id" value="<?php echo $value['_id']['$oid']; ?>">
                            <input class="btn btn-danger" type="submit" name="submit" value="Delete">
                        </form>
                <?php 
                        echo "</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>
    <script>
        function loadForm(id, name, identifier){
            console.log(id, name, identifier);
            $('#name').val(name);
            $('#identifier').val(identifier);
            $('#id').val(id);
        }
    </script>
<?php include 'footer.php'; ?>