<!DOCTYPE html>
<?php
$secretKey = '4614ad021dbcd56d288663982869b0e80d4d51c2198d244b00135c55193ad26e';
$keyId = 'deb530687c3c36e0bca3a0265d82385c4e256e159f69774c32e714d9245bd5ff';
?>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsrsasign/10.1.1/jsrsasign-all-min.js"></script>

</head>
<body>
<div class="container">
    <div class="wrapper">
        <div class="title"><span>Login Form</span></div>
        <form id="formData">
            <div class="row">
                <i class="fas fa-user"></i>
                <input type="text" name="email" placeholder="Email or Phone" required>
            </div>
            <div class="row">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="row button">
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#formData').submit(function(event) { // Change form ID
            event.preventDefault();
            var formDataSerialized = $('#formData').serializeArray();
            var formData = {};
            var userFormData = {};

            $.each(formDataSerialized, function(index, field) {
                formData[field.name] = field.value;
            });

            userFormData.user_details = formData;
            var formToken = KJUR.jws.JWS.sign(null, {alg: 'HS256', cty: 'JWT'}, JSON.stringify(userFormData), '<?=$secretKey?>');

            $.ajax({
                type: 'POST',
                url: 'login.php',
                data: {
                    token: formToken
                }
            });
        });
    });
</script>
</body>
</html>
