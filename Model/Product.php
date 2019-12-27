<?php

namespace model;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Product{
protected $id;
public $name;
protected $producerId;
public $price;
protected $typeId;
protected $quantity;
public $imageUrl;


function __construct($id ,$name , $producerId , $price , $typeId , $quantity ,$imageUrl)
    {
        $this->id =$id;
        $this->name=$name;
        $this->producerId = $producerId;
        $this->price=$price;
        $this->typeId=$typeId;
        $this->quantity=$quantity;
        $this->imageUrl=$imageUrl;
    }
function show(){
   $product = findProduct($this->id);
   echo $product->name;
   ?> <img src="<?= $product->imageUrl ?>"width="150"></a>
    <form action="index.php?target=cart&action=add&id=<?=$product->id?>" method="post">
        <input type="submit" value="Add to cart" name="addToCart">
    </form>
<?php
}

}