<?php
namespace model;
use model\CartDAO;
use Model\ProductDAO;
use PDO;
use PDOException;
class OrderDAO{

  static function addOrderProducts ($orderId , $orderedProducts){
        try{
            foreach ($orderedProducts as $product){
                $params = [];
                $params[] = $orderId;
                $params[] = $product["product_id"];
                $params[] = $product["quantity"];
                $pdo = getPDO();
                $sql = "INSERT INTO orders_have_products (order_id , product_id , quantity) VALUES (?,? ,?)";
                $statement = $pdo->prepare($sql);
                $statement->execute($params);
            }
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
    }
  static function addOrder ($addressId){
        try{
            $params = [];
            $params[] = $_SESSION["logged_user_id"];
            $params[] = $addressId;
            $pdo = getPDO();
            $sql = "INSERT INTO orders (user_id , address_id) VALUES (?,?)";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
            $id = $pdo->lastInsertId();
            return $id;
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    static function showOrders(){
        try{
            $params = [];
            $params[] = $_SESSION["logged_user_id"];
            $pdo = getPDO();
            $sql = "SELECT o.address_id , op.product_id , op.quantity , p.name ,p.image_url , o.date_created  FROM orders as o
            JOIN orders_have_products as op
            ON o.id = op.order_id 
            JOIN products as p ON p.id = op.product_id
            WHERE o.user_id = ? ORDER BY o.date_created";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
    }

  static  function finishOrder($orderedProducts){
        try{
            $pdo = getPDO();
            $pdo->beginTransaction();
            $id = OrderDAO::addOrder($_POST["address"]);
            OrderDAO::addOrderProducts($id , $orderedProducts);
            ProductDAO::decreaseProductQuantity($orderedProducts);
            CartDAO::deleteCart();
            $pdo->commit();
        }
        catch (PDOException $e){
            $pdo->rollBack();
            echo $e->getMessage();
        }
    }
}