<?php
namespace Controller;
use model\SearchDAO;
use model\Search;
use model\Product;
use Model\ProductDAO;
use Model\Type;
use Model\TypeDAO;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once dirname(__FILE__) . "/../Model/DBManager.php";

class ProductController {
public function show (){
    if (isset($_GET["prdId"])){
        $product = ProductDAO::findProduct($_GET["prdId"]);
        $product->show();
    }
    if (isset($_GET["ctgId"])){
        $types = TypeDAO::getTypesFromCategorieId($_GET["ctgId"]);
        foreach ($types as $type){
            $typeObject = new Type($type["id"] , $type["name"] , $type["categorie_id"]);
            $typeObject->show();
        }
    }
    if (isset($_GET["typId"])){
      $products =  ProductDAO::getProductsFromTypeId($_GET["typId"]);
        $type = TypeDAO::getTypeInformation($_GET["typId"]);
       echo "<h1>" .$type->name . "</h1>";
      foreach ($products as $product){
          $productList = ProductDAO::findProduct($product["id"]);
          $productList->show();
      }

    }

}




    public function add(){

    $msg='';
    if(isset($_POST["save"])){
        if(empty($_POST["name"]) || empty($_POST["producer_id"])
            || empty($_POST["price"]) || empty($_POST["type_id"])
            || empty($_POST["quantity"])) {

            $msg = "All fields are required!";
        }else{
            if(!preg_match('/^[0-9]+$/',$_POST["quantity"]) || !is_numeric($_POST["quantity"])){

                $msg="Invalid quantity format!";
            }

            $msg=$this->validatePrice($_POST["price"]);
            if(!is_uploaded_file($_FILES["file"]["tmp_name"])) {

                $msg = "Image is not uploaded!";
            }elseif($msg==""){
                $file_name_parts=explode(".",$_FILES["file"]["name"]);
                $extension=$file_name_parts[count($file_name_parts)-1];
                $filename=time().".".$extension;
                $img_url="images".DIRECTORY_SEPARATOR.$filename;
                if(!move_uploaded_file($_FILES["file"]["tmp_name"],$img_url)){

                    $msg="Image error!";
                }
            }
            if($msg==""){


                ProductDAO::add($_POST["name"],$_POST["producer_id"],$_POST["price"],$_POST["type_id"],$_POST["quantity"],$img_url);

            }

        }
    }
        include_once "View/addProduct.php";
    }

    public function edit(){

        $msg="";
        if(isset($_POST["saveChanges"])){
            if(empty($_POST["name"]) || empty($_POST["producer_id"])
                || empty($_POST["price"]) || empty($_POST["type_id"])
                || empty($_POST["quantity"])) {
                $msg = "All fields are required!";
            }else{
                if(!preg_match('/^[0-9]+$/',$_POST["quantity"]) || !is_numeric($_POST["quantity"])){

                    $msg="Invalid quantity format!";
                }

                $price=$_POST["price"];
                $old_price=NULL;
                if(!empty($_POST["newPrice"])){
                    $msg=$this->validatePrice($_POST["newPrice"]);
                    if($_POST["newPrice"]>$_POST["price"]){
                        $msg="New price of product must be lower than price !";
                    }else{
                        $price=$_POST["newPrice"];
                        $old_price=$_POST["price"];
                    }
                }

                $msg=$this->validatePrice($_POST["price"]);

                if(!is_uploaded_file($_FILES["file"]["tmp_name"])) {
                    $img_url= $_POST["old_image"];
                }else{
                    $file_name_parts=explode(".",$_FILES["file"]["name"]);
                    $extension=$file_name_parts[count($file_name_parts)-1];
                    $filename=time().".".$extension;
                    $img_url="images".DIRECTORY_SEPARATOR.$filename;
                    if(move_uploaded_file($_FILES["file"]["tmp_name"],$img_url)){
                        unlink($_POST["old_image"]);
                    }else{
                        $msg="Image error!";
                    }
                }
                if($msg==""){
                    $product=[];
                    $product["product_id"]=$_POST["product_id"];
                    $product["name"]=$_POST["name"];
                    $product["producer_id"]=$_POST["producer_id"];
                    $product["price"]=$price;
                    $product["old_price"]=$old_price;
                    $product["type_id"]=$_POST["type_id"];
                    $product["quantity"]=$_POST["quantity"];
                    $product["image_url"]=$img_url;

                    ProductDAO::edit($product);

                }

            }

        }
        $productId=$_POST["product_id"];
        include_once "View/editProduct.php";
    }

    public function validatePrice($price){
    $msg='';
        if (!preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $price) ||  !is_numeric($price)){
            $msg="Invalid price format!";
        }
        return $msg;
    }


    public static function checkIfIsInPromotion($product_id){
        $product=ProductDAO::getById($product_id);



        $oldPrice=null;
        $inPromotion=false;
        $discount=null;
        if($product->old_price !=NULL){
            $inPromotion=true;
            $oldPrice=$product->old_price;
            $discount=round((($product->old_price-$product->price)/$product->old_price)*100,0);
        }
        $price=[];
        $price["in_promotion"]=$inPromotion;
        $price["old_price"]=$oldPrice;
        $price["discount"]=$discount;
        return $price;
    }


    public function removeDiscount(){
    if(isset($_POST["remove"])){
        if(isset($_POST["product_id"])){
            ProductDAO::removePromotion($_POST["product_id"]);
            $productId=$_POST["product_id"];
            include_once "View/editProduct.php";
        }
    }


    }

    public function addProduct(){
        include_once "View/addProduct.php";
    }


    public function editProduct(){
        if(isset($_POST["editProduct"])){
            if(isset($_POST["product_id"])){
                $productId=$_POST["product_id"];
                include_once "View/editProduct.php";
            }else{
                header("Location:index.php");
            }
        }else{
            header("Location:index.php");
        }
    }


    public function showProduct(){
    include_once "View/showProduct.php";

    }



}