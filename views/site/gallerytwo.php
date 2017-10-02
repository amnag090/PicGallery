<?php

use yii\widgets\LinkPager;
use app\models\Users;
use app\models\Photos;
use app\models\Album;
use app\models\Category;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="row">
       
           
    <?php 
        $aid;
        
        $cid;
        foreach ($models as $model) {
            $cid = $model->cid;
        }
        echo "<h2>Category: ".Category::findOne(['cid' => $cid])->name."</h2>";
    ?>   
    
    <?php
        foreach ($models as $model) {
            echo " <div class=\"col-md-4\">";
            //echo $model->aid;
            //$photo = Photos::findOne(['aid' => $model->aid]);
            echo "<img style='box-shadow: 0px 0px 5px black;' src='$model->url' class='img img-responsive' alt=''>";
            echo "</div>";
        }

    ?>
    </div>
    <?php 
        // display pagination
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
        
    ?>
</div>
