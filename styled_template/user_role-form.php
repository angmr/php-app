<?php include 'header-script.php'; ?>

<?php
    function saveRoles($data){
        global $roles;

        $data_to_save = json_decode(json_encode($data));
        $result = $roles -> createRoles($data_to_save);
        return $result;
    }

    function updateRoles($data){
        global $roles;

        $data_to_save = json_decode(json_encode($data));
        $result = $roles -> updateRoles($data_to_save);
        return $result;
    }

    function deleteRoles($id, $roleid){
        global $roles;

        $result = $roles -> deleteDepartment($id, $roleid);
        return $result;
    }

    $identifierErr = "";
    $permissionErr = "";
    $authErr = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if(empty($_POST['id'])){
            $update = false;
        } else {
            $update = true;
        }

        if (empty($_POST["permission"])){
            $permissionErr = "You must specify role permission";
        }
        
        if (empty($_POST["authorizations"])){
            $authErr = "Authorizations is required";
        } 

        if(empty($permissionErr) && empty($identifierErr) && empty($authErr)){
            if ($update) {
                $data = array(
                    '_id' => $_POST['id'],
                    'permission' => $_POST['identifier'],
                    'authorizations' => $_POST['authorizations']
                );

                $result = updateRoles($data);

            } else {
                $data = array(
                    'identifier' => $_POST["identifier"],
                    'permission' => $_POST["permission"],
                    'authorizations' => $_POST["authorizations"]
                );

                $result = saveRoles($data);
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
            $result = deleteRoles($id);
        }
    }

    $data = json_decode($roles -> showRoles(), true);
    $data = json_decode($data['data'], true);
?>

<?php include 'header.php'; ?>

    <div class="container mt-4">
        <h2>Εισαγωγή νέου ρόλου</h2>
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
                <label for="permission" class="form-label">Permission</label>
                <input type="text" class="form-control" id="permission" name="permission" value="<?php echo $permission; ?>">
                <span class="text-danger">*<?php echo $permissionErr; ?></span>
            </div>
            <div class="mb-3">
                <label for="authorizations" class="form-label">Authorizations</label>
                <input type="text" class="form-control" id="authorizations" name="authorizations" value="<?php echo $authorizations; ?>">
                <span class="text-danger">*<?php echo $authErr; ?></span>
            </div>
            <input type='hidden' name='id' id='id' value=''>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <hr>

        <table class='table table-striped'>
            <tr>
                <th>Identifier</th>
                <th>Permission</th>
                <th>Authorizations</th>
                <th>Διαδικασίες</th>
            </tr>
            <?php
                foreach ($data as $value){
                    echo "<tr>";
                        echo "<td>".$value['identifier']."</td>";
                        echo "<td>".$value['permission']."</td>";
                        echo "<td>";
                            foreach ($value["authorizations"] as $value){
                                echo $value["name"]."<br>";
                            }
                        echo "</td>";
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
        function loadForm(identifier, permission, authorizations){
            console.log(identifier, permission, authorizations);
            $('#identifier').val(identifier);
            $('#permission').val(permission);
            $('#authorizations').val(authorizations);
        }
    </script>
<?php include 'footer.php'; ?>