<?php
namespace view;
use controller\RatingController;
use model\FavouriteDAO;
use controller\ProductController;
use model\RatingDAO;

try{

    $ratingDAO=new RatingDAO();
    $review=$ratingDAO->getReviewsNumber($this->id);
    $comments=$ratingDAO->getComments($this->id);

    $ratingController=new RatingController();
    $countOfStars=$ratingController->showStars($this->id);

    $productController=new ProductController();
    $status=$productController->checkIfIsInPromotion($this->id);


    ?>
    <div  class="container">
        <div class="row">
            <div class="col">
                <img src="<?= $this->imageUrl ?>" class="">
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <?= $review->reviews_count ?> reviews
                        </div>

                        <div class="row">
                            <?= $status["is_in_stock"] ?>
                        </div>
                        <div class="row">
<table>
    <?php if($status["in_promotion"]){
        ?>
        <tr>
            <td>Old Price:</td>
            <td><?=$status["old_price"] ?> EURO</td>
        </tr>
        <tr>
            <td>New Price:</td>
            <td><?= $this->price ?> EURO</td>
        </tr>
        <tr>
            <td>Discount:</td>
            <td><?= $status["discount"] ?> %</td>
        </tr>
        <?php
    }else{
        ?>
        <tr>
            <td>Price:</td>
            <td><?= $this->price ?> EURO</td>
        </tr>
        <?php
    }?>
</table>
                        </div>
                        <div class="row">
 <?php if(isset($_SESSION["logged_user_role"]) && $_SESSION["logged_user_role"]=="admin"){?>

                <form action="index.php?target=product&action=editProduct" method="post">
                    <input type="hidden" name="product_id" value="<?= $this->id ?>">
                    <input type="submit" name="editProduct" value="Edit this product">
                </form>

        <?php }?>
                        </div>
                        <div class="row">
                            <?php if (isset($_SESSION["logged_user_role"])){
                                ?>

                                    <a href="index.php?target=cart&action=add&id=<?=$this->id?>"><button>Добави в количка</button> </a>

                                <?php
                                $favouriteDAO=new FavouriteDAO;
                                if ($favouriteDAO->checkIfInFavourites($this->id , $_SESSION["logged_user_role"]))
                                {
                                    ?>

                                        <a href="index.php?target=favourite&action=delete&id=<?=$this->id?>"><button>Премахни от любими</button></a>

                                    <?php
                                }
                                else{
                                    ?>

                                            <a href="index.php?target=favourite&action=add&id=<?=$this->id?>"><img src="icons/like.svg" width="50" height="50"></a>

                                    <?php
                                }
                                ?>

                                    <a href="index.php?target=product&action=rateProduct&id=<?=$this->id?>"><button>Оцени този продукт</button></a>

                                <?php
                            }
                            else {
                                ?>

                                    <a href="index.php?target=user&action=loginPage" class="btn btn-primary btn-lg btn-block">Добави в количка</a>

                                <a href="index.php?target=user&action=loginPage" class="btn btn-primary btn-lg btn-block">Оцени този продукт</a>

                                    <a href="index.php?target=user&action=loginPage"><img src="icons/like.svg" width="50" height="50"></a>








                                <?php
                            }
                            ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            poiu
        </div>
    </div>
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
    <table>
        <tr>
            <td><h3> <?=$this->name ?></h3></td>
        </tr>
        <tr>
            <td><img src="<?= $this->imageUrl ?>"width="150"></td>

        </tr>
        <tr>
            <td><?= $review->reviews_count ?> reviews</td>
        </tr>

        <tr>
            <td><?= $status["is_in_stock"] ?> </td>
        </tr>

        <?php if($status["in_promotion"]){
            ?>
            <tr>
                <td>Old Price:</td>
                <td><?=$status["old_price"] ?> EURO</td>
            </tr>
            <tr>
                <td>New Price:</td>
                <td><?= $this->price ?> EURO</td>
            </tr>
            <tr>
                <td>Discount:</td>
                <td><?= $status["discount"] ?> %</td>
            </tr>
            <?php
        }else{
            ?>
            <tr>
                <td>Price:</td>
                <td><?= $this->price ?> EURO</td>
            </tr>
            <?php
        }?>


        <?php if(isset($_SESSION["logged_user_role"]) && $_SESSION["logged_user_role"]=="admin"){?>
            <tr>
                <form action="index.php?target=product&action=editProduct" method="post">
                    <input type="hidden" name="product_id" value="<?= $this->id ?>">
                    <input type="submit" name="editProduct" value="Edit this product">
                </form>
            </tr>
        <?php }
        else{
        ?>
        <?php if (isset($_SESSION["logged_user_role"])){
            ?>
            <tr>
                <td><a href="index.php?target=cart&action=add&id=<?=$this->id?>"><button>Добави в количка</button> </a></td>
            </tr>
            <?php
            $favouriteDAO=new FavouriteDAO;
            if ($favouriteDAO->checkIfInFavourites($this->id , $_SESSION["logged_user_role"]))
            {
                ?>
                <tr>
                    <td><a href="index.php?target=favourite&action=delete&id=<?=$this->id?>"><button>Премахни от любими</button></a></td>
                </tr>
                <?php
            }
            else{
                ?>
                <tr>
                    <td>
                        <a href="index.php?target=favourite&action=add&id=<?=$this->id?>"><img src="icons/like.svg" width="50" height="50"></a>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td><a href="index.php?target=product&action=rateProduct&id=<?=$this->id?>"><button>Оцени този продукт</button></a></td>
            </tr>
            <?php
        }
        else {
            ?>
            <tr>
                <td><a href="index.php?target=user&action=loginPage"><button>Добави в количка</button> </a></td>
            </tr>
            <tr>
                <td>
                    <a href="index.php?target=user&action=loginPage"><img src="icons/like.svg" width="50" height="50"></a>
                </td>
            </tr>
            <tr>
                <td><a href="index.php?target=user&action=loginPage"><button>Оцени този продукт</button></a></td>
            </tr>
            <?php
        }
        ?>

    </table>
    <?php }?>
    <table>
        <tr>
            <td>Average grade: <?= $review->avg_stars?></td>
            <?php foreach ($countOfStars as $key=>$countOfStar) {
                echo "<tr><td>Rate with $key stars:  $countOfStar</td></tr>";
            }
            ?>
        </tr>
    </table>
    <hr>

    <?php
    if($review->reviews_count==0){
        echo"<h3>There is no comments for this product!</h3>";
    }else{
        echo"<h3>Comments:</h3>";
    }?>



    <?php foreach ($comments as $comment) {
        ?>
        <table>
            <tr>
                <td>Name:</td>
                <td><?= $comment->full_name ?></td>
            </tr>
            <tr>
                <td>Date:</td>
                <td><?= $comment->date ?></td>
            </tr>
            <tr>
                <td>Stars:</td>
                <td><?= $comment->stars ?> stars</td>
            </tr>
            <tr>
                <td>Opinion:</td>
                <td><?= $comment->text ?></td>
            </tr>

        </table>
        <hr>
        <?php
    } ?>

    </body>
    </html>


<?php
}catch (\PDOException $e){
    include_once "view/main.php";
    echo "Oops, error 500!";

}