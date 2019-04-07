<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Meda Page
 *
 * media.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Media
 * @package    core/layout/media.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Move Settings to Header.
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_media.php';
else{?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>"><?php echo localize('Content');?></a></li>
    <li class="breadcrumb-item active"><?php echo localize('Media');?></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <?php if($help['media_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['media_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['media_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['media_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="m-0 p-0">
    <div id="elfinder" style="margin-top:45px"></div>
  </div>
</main>
<?php }
