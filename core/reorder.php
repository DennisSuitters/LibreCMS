<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$getcfg = false;
require 'db.php';
$i = 0;
foreach ($_POST['l'] as $id) {
  $s = $db -> prepare("UPDATE menu SET ord=:ord WHERE id=:id");
  $s -> execute(
    array(
      ':ord' => $i,
      ':id'  => $id
    )
  );
  $i++;
}
