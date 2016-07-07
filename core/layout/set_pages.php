<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="col-xs-6">Page Settings</h4>
        <div class="pull-right">
            <div class="btn-group">
                <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/pages';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><?php svg('back');?></a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <form target="sp" method="post" action="core/updatetheme.php">
            <div class="form-group">
                <div class="input-group col-xs-12">
                    <div class="input-group-addon">
                        File:
                    </div>
                    <select id="filesEditSelect" class="form-control" name="file">
<?php $fileDefault='meta_head.html';
$files=array();
foreach(glob("layout/".$config['theme']."/*.html")as$file){
    echo'<option value="'.$file.'"';
    if(stristr($file,$fileDefault)){
        echo' selected';
        $fileDefault=$file;
    }
    echo'>'.basename($file).'</option>';
}?>
                    </select>
                    <div class="input-group-btn">
                        <button id="filesEditLoad" class="btn btn-default" onclick="$('#block').css({'display':'block'});">Load</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
<?php $code=file_get_contents($fileDefault);?>
                <textarea id="code" name="code"><?php echo$code;?></textarea>
            </div>
            <div class="form-group text-right">
                <button id="codeSave" class="btn btn-default" onclick="populateTextarea();">Save</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        var editor=CodeMirror.fromTextArea(document.getElementById("code"),{
            lineNumbers:true,
            lineWrapping:true,
            mode:"text/html",
            autoRefresh:true
        });
        var charWidth=editor.defaultCharWidth(),basePadding=4;
        editor.refresh();
        $('#filesEditLoad').on({
            click:function(event){
                event.preventDefault();
                var url=$('#filesEditSelect').val();
                $.ajax({
                    url:url,
                    dataType:"text",
                    success:function(data){
                        $('#block').css("display","none");
                        editor.setValue(data).refresh();
                    }
                });
            }
        });
    });
    function populateTextarea(){
        $('#block').css({'display':'block'});
//        var code=editor.getValue();
//        $('#code').val(code);
    }
</script>