
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php
if (isset($err) && $err){
    ?>
    <div class="alert alert-danger" role="alert">
     <?php echo $msg;?>
    </div>
    <?php
} ?>

<form action="../index.php?target=User&action=register" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input name="password" type="password" class="form-control" id="exampleInputPassword1" >
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">First Name</label>
        <input type="text" name="first_name" class="form-control" >

    </div>
    <div class="form-group">
        <label >Last Name</label>
        <input type="text" name="last_name" class="form-control" >

    </div>
    <div class="form-group">
        <label >Age</label>
        <input type="number" name="age" class="form-control" min="0" max="100">

    </div>
    <div class="form-group">
        <label >Phone number</label>
        <input type="number" name="phone_number" class="form-control" placeholder="0888888888" >

    </div>

    <button name="register" type="submit" class="btn btn-primary">Submit</button>
</form>
</body>
</html>