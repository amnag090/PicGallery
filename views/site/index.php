<?php

use yii\widgets\LinkPager;
use app\models\Users;
use app\models\Photos;
use app\models\album;
use app\models\Category;
/* @var $this yii\web\View */

$this->title = 'PicGallery';
?>
<div class="site-index">
    <div class="row">
       
        <div class="col-md-3">
            <h2>Category</h2>
            <?php 
            foreach($category as $cat){
                echo "<a style='margin: 5px;' class='btn btn-primary' href='index.php?r=site%2Fgallerytwo&id=".$cat->cid."'>$cat->name</a>";
            }
            ?>
        </div>        
       
        <div class="col-md-9">
            <div class="row">
            <?php
                foreach ($models as $model) {
                    echo " <div class=\"col-md-4\">";
                    //echo $model->aid;
                    $photo = Photos::findOne(['aid' => $model->aid]);
                    echo "<a    href='index.php?r=site%2Fgallery&id=".$model->aid."'><img style='box-shadow: 0px 0px 5px black;' src='$photo->url' class='img img-responsive' alt='' ></a>";
                    echo "<h4 class='text-center'>$model->name</h4>";
                    echo "</div>";
                }

            ?>
            </div>
        </div>
    </div>
    <?php 
        // display pagination
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
        
    ?>
</div>
