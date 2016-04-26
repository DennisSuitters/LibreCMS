<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="col-xs-6">Messages Settings</h4>
        <div class="pull-right">
            <div class="btn-group">
                <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/messages';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><?php svg('back');?></a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <h4 class="page-header">Contact Subjects</h4>
        <div class="form-group">
            <div class="clearfix">
                <div class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">If no entries are made, an input text box will be used instead of a dropdown.<br>If email's are left blank, the messages will be sent to the site email set in Preferences.</div>
            </div>
            <label class="control-label col-xs-5 col-sm-3 col-lg-2">&nbsp;</label>
            <form target="sp" method="post" action="core/add_data.php">
                <input type="hidden" name="act" value="add_subject">
                <div class="input-group col-xs-12 col-sm-9 col-lg-10">
                    <span class="input-group-addon">Subject</span>
                    <input type="text" class="form-control" name="sub" value="" placeholder="Enter a Subject...">
                    <div class="input-group-addon">Email</div>
                    <input type="text" class="form-control" name="eml" value="" placeholder="Enter an Email...">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><?php svg('plus');?></button>
                    </div>
                </div>
            </form>
        </div>
        <div id="subjects">
<?php $ss=$db->prepare("SELECT * FROM choices WHERE contentType='subject' ORDER BY title ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?php echo$rs['id'];?>" class="form-group">
                <label class="control-label col-xs-5 col-sm-3 col-lg-2">&nbsp;</label>
                <div class="input-group col-xs-12 col-sm-9 col-lg-10">
                    <div class="input-group-addon">Subject</div>
                    <input type="text" class="form-control" value="<?php echo$rs['title'];?>" onchange="update('<?php echo$rs['id'];?>','subject','title',$(this).val());" placeholder="Enter a Subject...">
                    <div class="input-group-addon">Email</div>
                    <input type="text" class="form-control" value="<?php echo$rs['url'];?>" onchange="update('<?php echo$rs['id'];?>','subject','url',$(this).val());" placeholder="Enter an Email...">
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
        <h4 class="page-header">AutoReply Email Layout</h4>
        <div class="form-group clearfix">
            <label for="contactAutoReplySubject" class="control-label col-xs-5 col-sm-3 col-lg-2">Subject</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <input type="text" id="contactAutoReplySubject" class="form-control textinput" value="<?php echo$config['contactAutoReplySubject'];?>" data-dbid="1" data-dbt="config" data-dbc="contactAutoReplySubject">
            </div>
            <div class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">Tokens: {name} {first} {last} {date}</div>
        </div>
        <div class="form-group clearfix">
            <label for="contactAutoReplyLayout" class="control-label col-xs-5 col-sm-3 col-lg-2">Layout</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <form method="post" target="sp" action="core/update.php">
                    <input type="hidden" name="id" value="1">
                    <input type="hidden" name="t" value="config">
                    <input type="hidden" name="c" value="contactAutoReplyLayout">
                    <textarea id="contactAutoReplyLayout" class="form-control summernote" name="da"><?php echo$config['contactAutoReplyLayout'];?></textarea>
                </form>
            </div>
            <div class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">Tokens: {name} {first} {last} {date}</div>
        </div>
    </div>
</div>
