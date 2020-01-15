<?php
namespace view;


use controller\ProductController;

$controller = new ProductController();
if(isset($filters)  && isset($products)&& isset($totalPages) && isset($page)) {


    ?>
    <div class="container">
    <div class="row">
        <div class="col-2">
            <div class="card">
                <?php foreach ($filters->getFilter() as $filter) {
                ?>
                <article class="card-group-item">
                    <header class="card-header">
                        <h6 class="title"><?= $filter ?> </h6>
                    </header>
                    <div class="filter-content">
                        <div class="card-body">
                            <?php foreach ($filters->getFilterValues() as $filterValue) {

                                if ($filterValue->name == $filter) {
                                    ?>
                                    <div data-filter="<?=$filter?>">
                                        <div>
                                            <input class="form-check-input" type="checkbox" name="checkbox" value="<?= $filterValue->value ?>">
                                        </div>
                                        <span class="form-check-label" style="margin-left: 20px">
                                        <?= $filterValue->value ?>
                                                 </span>
                                    </div>
                                <?php }
                            } ?>
                            <!-- form-check.// -->



                        </div> <!-- card-body.// -->

                    </div>
                    <?php } ?>
                </article> <!-- card-group-item.// -->



            </div>

        </div>
        <div class="col-10" id="products-container">
            <div class="row">
                <?php
                foreach ($products as $product){
                    ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card">
                            <a href="index.php?target=product&action=show&prdId=<?= $product->id ?>"><img class="card-img-top" width="170" height="250" src="<?= $product->image_url ?>" alt="Card image cap"></a>
                            <div class="card-body">
                                <h4 class="card-title"><a href="product.html" title="View Product"><?= $product->name ?></a></h4>
                                <div class="row">
                                    <?php
                                        ?>
                                        <div class="col">
                                            <p class="btn btn-danger btn-block"><?= $product->price ?> Euro</p>
                                        </div>
                                        <?php

                                    ?>

                                    <div class="col">
                                        <a class="btn btn-success btn-block" href="index.php?target=cart&action=add&id=<?= $product->id ?>">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="col-10">
            <div id="vue-instance">
                <div v-for="p in products">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card">
                            <a :href="'index.php?target=product&action=show&prdId=' + p.id"> <img class="card-img-top" width="170" height="250" :src="p.image_url" alt="Card image cap"></a>
                            <div class="card-body">
                                <h4 class="card-title"><a :href="'index.php?target=product&action=show&prdId=' + p.id" title="View Product">{{p.name}}</a></h4>
                                <div class="row">
                                    <div class="col">
                                        <p class="btn btn-danger btn-block">{{p.price}} Euro</p>
                                    </div>
                                    <div class="col">
                                        <a :href="'index.php?target=cart&action=add&id=' + p.id" class="btn btn-success btn-block">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>



    <nav aria-label="Page navigation example">
        <ul class="pagination">

            <?php if($page>1){
                $previousPage=--$page;
                ?>
                <li class="page-item"><a class="page-link" href="index.php?target=product&action=show&typId=<?= $_GET["typId"] ?>&page=<?=$previousPage?>">Previous</a></li>
                <?php
            }
            for ($i = 1; $i <= $totalPages + 1; $i++) {
                ?>
                <li class="page-item"><a class="page-link" href="index.php?target=product&action=show&typId=<?= $_GET["typId"] ?>&page=<?= $i ?>"><?= $i ?></a></li>
                <?php
            }
            if($page<$totalPages){
                $nextPage=++$page;
                ?>
                <li class="page-item"><a class="page-link" href="index.php?target=product&action=show&typId=<?= $_GET["typId"] ?>&page=<?=$nextPage?>">Next</a></li>

                <?php
            }
            ?>


        </ul>
    </nav>
    <?php
}else {
    include_once "index.php";
}
