<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 07-08-17
 * Time: 13:07
 */
require 'connect.php';

$pdo = ("SELECT unites.type from ingredients JOIN 
          unites ON ingredients.unite_id = unites.id WHERE ingreditents.id = '". $_POST[id]."';");
echo 'data';