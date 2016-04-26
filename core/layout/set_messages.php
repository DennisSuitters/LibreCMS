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
