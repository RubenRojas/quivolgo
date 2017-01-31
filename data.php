<?php


foreach ($_SERVER as $key => $value) {?> <pre> <b>[<?=$key?>] => </b> <?=var_dump($value)?> </pre> <?php }
