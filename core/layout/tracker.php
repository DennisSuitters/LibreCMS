<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Visitor Tracker</h4>
    <div class="pull-right">
      <div class="btn-group" data-toggle="tooltip" data-placement="left" title="Purge All">
        <button class="btn btn-default trash" onclick="purge('0','tracker')"><?php svg('libre-gui-purge',($config['iconsColor']==1?true:null));?></button>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#activity" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-condensed table-striped table-hover">
        <thead>
          <tr>
            <th class="col-xs-3" data-toggle="tooltip" data-placement="top" title="Clicking on Links will show the History of that Page in Date Order.">Page</th>
            <th class="col-xs-2" data-toggle="tooltip" data-placement="top" title="Clicking on Origin Links will open that URL in a new window.">Origin</th>
            <th class="col-xs-1 text-center" data-toggle="tooltip" data-placement="top" title="Clicking on IP Links will Do a WhoIs on that IP in a new window.">IP</th>
            <th class="col-xs-1 text-center">Browser</th>
            <th class="col-xs-1 text-center">OS</th>
            <th class="col-xs-4 text-center">Date</th>
          </tr>
        </thead>
        <tbody id="l_tracker">
<?php
$is=0;
$ie=50;
$action=(isset($args[1])?$args[1]:'');
include'core'.DS.'layout'.DS.'tracker_items.php';?>
        </tbody>
      </table>
    </div>
  </div>
</div>
