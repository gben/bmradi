<!-- Main content -->
<?php 
$data = DB::select("SELECT account_status as status from accounts_dbx where account_id = ?",array($row_id));
$status = strtoupper($data[0]->status);
?>
<section class="content">
    <div class="rowCell">
		<div class="titleCell">
                {{ Form::open(array('name'=>'entrepreneur','url'=>'/info/update/entrepreneur')) }}
                <input type="hidden" name="action" value="<?=($status=='ACTIVE'||$status=='1'?'INACTIVE':'ACTIVE')?>"/>
                <input type="hidden" name="id" value="<?=$row_id?>"/>
                {{ Form::hidden('route','entrepreneur_acc') }}
                <button class="btn btn-default" id="updatebtn" name="updatebtn" type="button" style="height:30px; padding-top: 1px">
                    <?=($status=='ACTIVE'||$status=='1'?'De-activate':'Activate')?> Account</button>
                {{ Form::label('send_email', 'and send email?') }}
                {{ Form::checkbox('send_email', '1', true) }}
                {{ Form::close() }}                 
                </div>
    </div>
</section><!-- /.content -->
@include('admin.includes.lessfooter')