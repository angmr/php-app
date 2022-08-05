<?php include 'header-script.php'; ?>

<?php

function saveUser($data){
    global $user;

    $data_to_save = json_decode(json_encode($data));
    $result = $user -> createUser($data_to_save);
    return $result;
}

function updateUser($data){
    global $user;

    $data_to_save = json_decode(json_encode($data));
    $result = $user -> updateUser($data_to_save);
    return $result;
}

function deleteUser($data){
    global $user;

    $result = $user -> deleteUser($data);
    return $result;
}

$usernameErr = "";
$passwordErr = "";
$identifierErr = "";
$category_nameErr = "";
$nameErr = "";
$surnameErr = "";
$emailErr = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (empty($_POST["username"])){
        $usernameErr = "Username is required.";
    }

    if (empty($_POST["password"])){
        $passwordErr = "You must enter a password.";
    }

    if (empty($_POST["identifier"])){
        $identifierErr = "You must enter a category identifier.";
    }

    if (empty($_POST["category-name"])){
        $category_nameErr = "Category name is required.";
    }

    if (empty($_POST["surname"])){
        $surnameErr = "Surname is required";
    } else {
        if(!preg_match("/^[a-zA-Z\p{Greek}\s]+$/u", $_POST["surname"])){
            $surnameErr = "Invalid name format";
        }
    }

    if (empty($_POST["name"])){
        $nameErr = "Name is required";
    } else {
        if(!preg_match("/^[a-zA-Z\p{Greek}\s]+$/u", $_POST["name"])){
            $nameErr = "Invalid name format";
        }
    }

    if (empty($_POST["user-email"])){
        $emailErr = "E-mail is required";
    } else {
        if(!filter_var($_POST["user-email"], FILTER_VALIDATE_EMAIL)){
            $emailErr = "Invalid e-mail format";
        }
    }

    if(empty($usernameErr) && empty($passwordErr) && empty($identifierErr) && 
        empty($category_nameErr) && empty($surnameErr) && empty($nameErr) && empty($emailErr)){
            $data = array(
                'username' => $_POST["username"],
                'password' => $_POST["password"],
                'user_category' => [
                    'identifier' => $_POST["identifier"],
                    'name' => $_POST["category-name"]
                ],
                'surname' => $POST["surname"],
                'name' => $_POST["name"],
                'email' => $_POST["user-email"]
            );

            $result = saveUser($data);

    }
}

$data = json_decode($user -> showUsers(), true);
$data = json_decode($data['data'], true);
?>

<?php include 'header.php'; ?>
    <div class="container mt-4">
        <h2>Εισαγωγή νέου χρήστη</h2>
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
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" value="<?php echo $username; ?>">
                <span class="text-danger">*<?php echo $usernameErr; ?></span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" class="form-control" id="password" name="password" value="<?php echo $password; ?>">
                <span class="text-danger">*<?php echo $passwordErr; ?></span>
            </div>
            <p>User Category</p>
            <div class="mb-3">
                <label for="identifier" class="form-label">Identifier</label>
                <input type="text" class="form-control" id="identifier" name="identifier" value="<?php echo $identifier; ?>">
                <span class="text-danger">*<?php echo $identifierErr; ?></span>
            </div>
            <div class="mb-3">
                <label for="category-name" class="form-label">Name</label>
                <input type="text" class="form-control" id="category-name" name="category-name" value="<?php echo $category_name; ?>">
                <span class="text-danger">*<?php echo $identifierErr; ?></span>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
                <span class="text-danger">*<?php echo $identifierErr; ?></span>
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">Surname</label>
                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $identifier; ?>">
                <span class="text-danger">*<?php echo $identifierErr; ?></span>
            </div>
            <div class="mb-3">
                <label for="user-email" class="form-label">E-mail</label>
                <input type="text" class="form-control" id="user-email" name="user-email" value="<?php echo $user_email; ?>">
                <span class="text-danger">*<?php echo $identifierErr; ?></span>
            </div>
            <input type='hidden' name='id' id='id' value=''>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
<?php include 'footer.php'; ?>