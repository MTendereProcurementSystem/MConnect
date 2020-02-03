<?php
/**
 * Created by PhpStorm.
 * User: paliiuc
 * Date: 8/6/18
 * Time: 2:14 PM
 */

use app\modules\status\helpers\TcpHelper;

?>

<h2>
    Server Status:

</h2>


<h4 id="all-status"></h4>

</br>

<ul class="list-group">
    <?php
    foreach ($items as $item) {
        if ($item->status == true) {
            ?>
            <li class="list-group-item list-group-item-success d-flex justify-content-between align-items-center">
                <h4> <?= $item->name ?> <span class="pull-right glyphicon glyphicon-ok "></span></h4>
            </li>
            <?php
        } else {
            ?>

            <li class="list-group-item list-group-item-danger d-flex justify-content-between align-items-center">
                <h4> <?= $item->name ?> <span class=" pull-right glyphicon glyphicon-remove"></span></h4>
            </li>

            <?php
        }
    }
    ?>
</ul>


<script>
    document.addEventListener('DOMContentLoaded', function(){
        if ($('.list-group-item-danger').length === 0) {
            $('#all-status').html('<span class="label label-success">All Systems Operational ;)</span>');
        }else if ($('.list-group-item-danger').length === $('.list-group-item').length) {
            $('#all-status').html('<span class="label label-danger">All Systems Down :(</span>');
    } else {
            $('#all-status').html('<span class="label label-warning">Systems Partially Down :/</span>');
        }
    }, false);
</script>


