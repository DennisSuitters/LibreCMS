<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
require 'db.php';
$i = 0;
foreach ($_POST['proof_items'] as $id) {
  $s = $db -> prepare("UPDATE content SET ord=:ord WHERE id=:id");
  $s -> execute(
    array(
      ':ord' => $i,
      ':id'  => $id
    )
  );
  $i++;
}
