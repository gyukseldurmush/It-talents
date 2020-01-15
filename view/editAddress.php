<?php
namespace view;
use model\AddressDAO;

try{
    $addressDAO=new AddressDAO;
    $address=$addressDAO->getById($_POST["address_id"]);
    $cities=$addressDAO->getCities();
}catch (\PDOException $e){
    include_once "view/header.php";
    echo "Oops, error 500!";

}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="index.php?target=address&action=edit" method="post">
    <input type="hidden" name="address_id" value="<?php echo $address->id ?>">
    <table>
        <tr>
            <td>City</td>
            <td><select name="city" required>
                    <option value="<?php echo $address->city_id ?>"><?php echo $address->city_name ?></option>
                    <?php foreach ($cities as $city) {
                        echo "<option value='$city->id'>$city->name</option>";

                    } ?>
                </select></td>
        </tr>
        <tr>
            <td>Street name</td>
            <td><input type="text" name="street" value="<?php echo $address->street_name?>" placeholder="Enter street name" min="5" required ></td>
        </tr>
        <tr><td colspan="2"><input type="submit" name="save" value="Save changes"></td></tr>
    </table>
</form>
<a href="index.php?target=user&action=account"><button>Back</button></a>
</body>
</html>
