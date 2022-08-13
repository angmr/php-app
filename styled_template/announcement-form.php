<?php include 'header-script.php'; ?>

<?php
    function saveAnnouncement($data){
        global $announcement;

        $data_to_save = json_decode(json_encode($data));
        $result = $announcement -> createAnnouncement($data_to_save);
        return $result;
    }

    function updateAnnouncement($data){
        global $announcement;

        $data_to_save = json_decode(json_encode($data));
        $result = $announcement -> updateAnnouncement($data_to_save);
        return $result;
    }

    function deleteAnnouncement($data){
        global $announcement;

        $result = $announcement -> deleteAnnouncement($data);
        return $result;
    }

    $nameErr = "";
    $passwordErr = "";
    $textErr = "";
    $dateErr = "";

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

                $result = updateAnnouncement($data);

            } else {
                $data = array(
                    'identifier' => $_POST["identifier"],
                    'name' => $_POST["name"]
                );

                $result = saveAnnouncement($data);
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
            $result = deleteAnnouncement($id);
        }
    }

    $data = json_decode($announcement -> showAnnouncements(), true);
    $data = json_decode($data['data'], true);
?>

<?php include 'header.php'; ?>

    <div class="container mt-4">
        <h2>Εισαγωγή νέας Ανακοίνωσης</h2>
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
                <label for="department_name" class="form-label">Department Name</label>
                <input type="text" class="form-control" id="department-name" name="department-name" value="<?php echo $department_name; ?>">
                <span class="text-danger">*<?php echo $depNameErr; ?></span>
            </div>
            <div class="mb-3">
                <label for="subdepartment_name" class="form-label">Subdepartment Name</label>
                <input type="text" class="form-control" id="subdepartment_name" name="subdepartment_name" value="<?php echo $subdepartment_name; ?>">
                <span class="text-danger">*<?php echo $subDepNameErr; ?></span>
            </div>
            <div class="mb-3">
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $category_name; ?>">
                <span class="text-danger">*<?php echo $catNameErr; ?></span>
            </div>
            <div class="mb-3">
                <label for="category_name" class="form-label">Password</label>
                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $category_name; ?>">
                <span class="text-danger">*<?php echo $passwordErr; ?></span>
            </div>
            <div class="mb-3">
                <label for="category_name" class="form-label">Subject</label>
                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $category_name; ?>">
                <span class="text-danger">*<?php echo $subjectErr; ?></span>
            </div>
            <div class="mb-3">
                <label for="category_name" class="form-label">Message</label>
                <input type="textfiled" class="form-control" id="category_name" name="category_name" value="<?php echo $category_name; ?>">
                <span class="text-danger">*<?php echo $msgErr; ?></span>
            </div>
            <div class="mb-3">
                <label for="category_name" class="form-label">Start</label>
                <input type="date" class="form-control" id="category_name" name="category_name" value="<?php echo $category_name; ?>">
                <span class="text-danger">*<?php echo $dateErr; ?></span>
            </div>
            <div class="mb-3">
                <label for="finish" class="form-label">Finish</label>
                <input type="date" class="form-control" id="finish" name="finish" value="<?php echo $finish; ?>">
            </div>
            <div class="mb-3">
                <label for="attachment" class="form-label">Attachment</label>
                <input type="file" class="form-control" id="attachmentFile" name="filename" value="<?php echo $file_name; ?>">
            </div>

            <input type='hidden' name='id' id='id' value=''>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <hr>

        <table class='table table-striped'>
            <tr>
                <th>Όνομα Τμήματος</th>
                <th>Όνομα Υποτμήματος</th>
                <th>Κατηγορία</th>
                <th>Θέμα</th>
                <th>Μύνημα</th>
                <th>Περίοδος</th>
                <th>Επισυναπτόμενα Αρχεία</th>
                <th>Διαδικασίες</th>
            </tr>
            <?php
                foreach ($data as $value){
                    echo "<tr>";

                        echo "<td>";
                        foreach ($value["departmant"] as $value){
                            echo $value["name"]."<br>";
                        }
                        echo "</td>";

                        echo "<td>";
                            foreach ($value["subdepartment"] as $value){
                                echo $value["name"]."<br>";
                            }
                        echo "</td>";

                        echo "<td>";
                            foreach ($value["category"] as $value){
                                echo $value["name"]."<br>";
                            }
                        echo "</td>";

                        echo "<td>".$value['subject']."</td>";
                        echo "<td>".$value['message']."</td>";

                        echo "<td>";
                            foreach ($value["period"] as $value){
                                echo $value["start"]." - ".$value["finnish"];
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
        function loadForm(id, name, identifier){
            console.log(id, name, identifier);
            $('#name').val(name);
            $('#identifier').val(identifier);
            $('#id').val(id);
        }
    </script>
<?php include 'footer.php'; ?>