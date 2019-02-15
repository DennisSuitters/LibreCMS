<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$cart='';
$dti=$ti-86400;
$q=$db->prepare("DELETE FROM `".$prefix."cart` WHERE ti<:ti");
$q->execute(
  array(
    ':ti'=>$dti
  )
);
$q=$db->prepare("SELECT SUM(quantity) as quantity FROM `".$prefix."cart` WHERE si=:si");
$q->execute(
  array(
    ':si'=>SESSIONID
  )
);
$r=$q->fetch(PDO::FETCH_ASSOC);
$cart=$theme['settings']['cart_menu'];
$cart=preg_replace('/<print cart=[\"\']?quantity[\"\']?>/',$r['quantity'],$cart);
