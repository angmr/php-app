<?php include 'header-script.php'; ?>

<?php
    function saveSubscription($data){
        global $subscription;

        $data_to_save = json_decode(json_encode($data));
        $result = $subscription -> createSubscription($data_to_save);
        return $result;
    }

    $nameErr = "";
    $identifierErr = "";

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
                $data = array(
                    'identifier' => $_POST["identifier"],
                    'name' => $_POST["name"]
                );

                $result = saveSubscription($data);
                $result = json_decode($result, true);

                if (!$result['success']){
                    $alert = trim($result['data'], '"');
                } else {
                    $alert = "";
                }
        }
    }

    $data = json_decode($subscription -> showSubscription(), true);
    $data = json_decode($data['data'], true);
?>

<?php include 'header.php'; ?>
    <div class="container mt-4">
        <h2>Εγγραφή σε Ανακοινώσεις</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="mb-3">
                <label for="identifier" class="form-label">Identifier</label>
                <input type="text" class="form-control" id="identifier" name="identifier" aria-describedby="emailHelp" value="<?php echo $identifier; ?>">
                <span class="text-danger">*<?php echo $identifierErr; ?></span>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
                <span class="text-danger">*<?php echo $nameErr; ?></span>
            </div>
            <input type='hidden' name='id' id='id' value=''>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
<?php include 'footer.php'; ?>