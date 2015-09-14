<!-- Main content -->
<?php 
$data = DB::select("SELECT title as 'Role_Name' from role where id = ?",array($row_id));
$title = strtoupper($data[0]->Role_Name);
?>
<section class="content">
{{ Form::open(array('name'=>'roles','url'=>'/edit/roles')) }}
<div class="role gridCell" title="<?=$row_id?>" style="">
	<div class="rowCell">
		<div class="titleCell">Role</div>
		<div class="contentCell"><?=$title?></div>
	</div>
	<div class="actionsCell">
                <?=(Helpers::hasPermission("role", "select")?'<input type="button" name="update" value="Edit" class="gridEditButton">':'')?>
                <?=(Helpers::hasPermission("role", "delete")?'<input type="button" name="delete" value="Delete" class="gridDeleteButton">':'')?>
                <input type="hidden" name="cell" value="<?=$row_id?>"/>
	</div>
</div>
{{ Form::close() }}         
</section><!-- /.content -->
@include('admin.includes.lessfooter')