<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="col-xs-6">Dashboard Settings</h4>
        <div class="pull-right">
            <div class="btn-group">
                <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/dashboard';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><?php svg('back');?></a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <h4 class="page-header">Google Analytics</h4>
        <div class="form-group">
            <div class="control-label col-xs-5 col-sm-3 col-lg-2"></div>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" id="options12" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="12"<?php if($config['options']{12}==1)echo' checked';?>>
                    <label for="options12">Enable</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="ga_clientID" class="control-label col-xs-5 col-sm-3 col-lg-2">clientID</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <input type="text" id="ga_clientID" class="form-control textinput" value="<?php echo$config['ga_clientID'];?>" data-dbid="1" data-dbt="config" data-dbc="ga_clientID" placeholder="Enter Your Google clientID..."<?php if($user['options']{1}==0)echo' readonly';?>>
            </div>
        </div>
        <h4 class="page-header">RSS Feeds</h4>
        <div class="form-group">
            <div class="control-label col-xs-5 col-sm-3 col-lg-2"></div>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" id="options10" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="10"<?php if($config['options']{10}==1)echo' checked';?>>
                    <label for="options10">Enable</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-5 col-sm-3 col-lg-2">&nbsp;</label>
            <form target="sp" method="post" action="core/add_data.php">
                <input type="hidden" name="act" value="add_dashrss">
                <div class="input-group col-xs-12 col-sm-9 col-lg-10">
                    <div class="input-group-addon">URL</div>
                    <input type="text" class="form-control" name="url" value="" placeholder="Enter a URL...">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><?php svg('plus');?></button>
                    </div>
                </div>
            </form>
        </div>
        <div id="rss">
<?php $ss=$db->prepare("SELECT * FROM choices WHERE contentType='dashrss' ORDER BY url ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?php echo$rs['id'];?>" class="form-group">
                <label class="control-label col-xs-5 col-sm-3 col-lg-2">&nbsp;</label>
                <div class="input-group col-xs-12 col-sm-9 col-lg-10">
                    <div class="input-group-addon">URL</div>
                    <input type="text" class="form-control" value="<?php echo$rs['url'];?>" onchange="update('<?php echo$rs['id'];?>','choices','url',$(this).val());" placeholder="Enter a URL...">
                    <div class="input-group-btn">
                        <form target="sp" action="core/purge.php">
                            <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                            <input type="hidden" name="t" value="choices">
                            <button class="btn btn-default trash"><?php svg('trash');?></button>
                        </form>
                    </div>
                </div>
            </div>
<?php }?>
        </div>
        <h4 class="page-header">LibreCMS Git Commits</h4>
        <div class="form-group">
            <div class="control-label col-xs-5 col-sm-3 col-lg-2"></div>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <div class="checkbox checkbox-success">
                    <input type="checkbox" id="options11" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="11"<?php if($config['options']{11}==1)echo' checked';?>>
                    <label for="options11">Enable</label>
                </div>
            </div>
        </div>
    </div>
</div>