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

$usernameErr = $identifierErr = "";
$username = $identifier = "";
$passwordErr = "";

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
            <input type='hidden' name='id' id='id' value=''>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
<?php include 'footer.php'; ?>