<?php
session_start();
require_once '../conn.php';
require_once '../constants.php';
$class = "edit";
?>
<?php
$cur_page = 'editAcc';
include 'includes/inc-header.php';
// include 'includes/inc-nav.php';

////

$id = $_GET['id'];

/////


$getData = "SELECT * FROM `passenger` WHERE `id` = $id ";
$query = mysqli_query($conn, $getData);



/////

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $file = 'file';
    $address = $_POST['address'];
    $cpassword = $_POST['cpassword'];
    $password = $_POST['password'];
    if (!isset($name, $address, $phone, $email, $password, $cpassword) || ($password != $cpassword)) { ?>
        <script>
            alert("Ensure you fill the form properly.");
        </script>
        <?php
        // } else {
        //     //Check if email exists
        //     $check_email = $conn->prepare("SELECT * FROM passenger WHERE email = ? OR phone = ?");
        //     $check_email->bind_param("ss", $email, $phone);
        //     $check_email->execute();
        //     $res = $check_email->store_result();
        //     $res = $check_email->num_rows();
        //     if ($res) {
        //     ?>
        <script>
            alert("Email already exists!");
        </script>
        <?php

    } elseif ($cpassword != $password) { ?>
        <script>
            alert("Password does not match.");
        </script>
        <?php
    } else {
        //Insert
        $password = md5($password);
        $can = 1;
        $loc = uploadFile('file');
        // if ($loc == -1) {
        //     echo "<script>alert('We could not complete your registration, try again later!')</script>";
        //     exit;
        // }
        $stmt = $conn->prepare("UPDATE passenger SET name = ?, email = ?, password = ?, phone = ?, address = ?, loc = ? WHERE `id` = ?");
        $stmt->bind_param("ssssssi", $name, $email, $password, $phone, $address, $loc, $id);
        if ($stmt->execute()) {
            ?>
            <script>
                alert("Congratulations.\nYour profile account updated.");
                window.location = 'individual.php';
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("We could not register you!.");
            </script>
            <?php
        }
    }
}
//}
?>
<div class="signup-page">
    <div class="form">
        <h2>Edit Acc </h2>
        <br>
        <p class="alert alert-info">
            <marquee behavior="" scrollamount="2" direction="">You can edit your account here!
            </marquee>
        </p>
        <form class="login-form" method="post" role="form" enctype="multipart/form-data" id="signup-form"
            autocomplete="off">
            <!-- json response will be here -->
            <div id="errorDiv"></div>
            <!-- json response will be here -->
            <div class="col-md-12">
                <?php foreach ($query as $q): ?>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" required minlength="10" name="name" value="<?= $q['name']; ?>">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" minlength="11" pattern="[0-9]{11}" required name="phone"
                            value="<?= $q['phone']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" required name="email" value="<?= $q['email']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Select Picture</label>
                        <input type="file" name='file'>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Address</label>
                        <input type='text' name="address" class="form-group" required value="<?= $q['address']; ?>">
                        </select>
                        <span class="help-block" id="error"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Change Password</label>
                        <input type="password" name="password" id="password">
                        <span class="help-block" id="error"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="cpassword" id="cpassword">
                        <span class="help-block" id="error"></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" id="btn-signup">
                            SAVE CHANGES
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
            <p class="message">
                <a href="#">.</a><br>
            </p>
        </form>
    </div>
</div>
</div>
<script src="assets/js/jquery-1.12.4-jquery.min.js"></script>

</body>

</html>