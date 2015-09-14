<?php include 'common/header.php'; ?>
<div>
    <div class="row" style='width: 80%; margin: 0 auto;'>
        <?php
        
        ?>
        <h3>Complete your profile</h3>
        
        <?php if ($errors->has()) echo "<div class=\"callout callout-danger  has-error\" style=\"color: red;margin-left: 155px\"><p> Oops! Please correct the fields highlighted</p></div>"; ?>

        <?= Form::open(array('route'=>'complete_my_profile','name'=>'new_account','files'=>'true')); ?>

        <table class='mradi_table' style="width:80%;" >
            <tr>
                <td width='150px;'>Name</td>
                <td class="form-control mradi_forms"><?=Session::get('fullnames')?></td>
            </tr>
            <tr>
                <td width='150px;'>Email Address</td>
                <td class="form-control mradi_forms"><?=Session::get('username')?></td>
            </tr>
            <tr>
                <td width='150px;'>Gender</td>
                <td class="form-control mradi_forms"><?=(Session::get('gender')=='M'?'Male':'Female')?></td>
            </tr>
            <tr>
                <td width='150px;'>Phone Number</td>
                <td class="form-control mradi_forms"><?=Session::get('phone_no')?></td>
            </tr>
            <tr>
                <td width='150px;'>Date of Birth</td>
                <td class="<?=($errors->has('date_of_birth')?'has-error':'')?>"><?= Form::text('date_of_birth', Input::old('date_of_birth'),
                    array('class' => "form-control mradi_forms".($errors->has('firstname')?'has-error':''),
                    'id'=>'firstname','style'=>"font-size:12px !important")); ?></td>
            </tr>
            <tr>
                <td width='150px;'>ID/Passport</td>
                <td class="<?=($errors->has('id_passport')?'has-error':'')?>"><?= Form::text('id_passport', Input::old('id_passport'), array('class' => "form-control mradi_forms ".($errors->has('id_passport')?'has-error':''),'id'=>'id_passport')); ?></td>
            </tr>
            <tr>
                <td width='150px;'>PIN Number</td>
                <td class="<?=($errors->has('pin_number')?'has-error':'')?>"><?= Form::text('pin_number', Input::old('pin_number'), array('class' => "form-control mradi_forms ".($errors->has('pin_number')?'has-error':''),'id'=>'pin_number')); ?></td>
            </tr>
            <tr>
                <td width='150px;'>Postal Address</td>
                <td class="<?=($errors->has('postal_addr')?'has-error':'')?>"><?= Form::text('postal_addr', Input::old('postal_addr'), array('class' => "form-control mradi_forms ".($errors->has('postal_addr')?'has-error':''),'id'=>'postal_addr')); ?></td>
            </tr>
            <tr>
                <td width='150px;'>Brief Description</td>
                <td class="<?=($errors->has('brief_desc')?'has-error':'')?>"><?= Form::textarea('brief_desc', Input::old('brief_desc'), array('class' => "form-control mradi_forms ".($errors->has('brief_desc')?'has-error':''),'id'=>'brief_desc','rows'=>'3','placeholder'=>'Brief description about yourself')); ?></td>
            </tr>
            <tr>
                <td width='150px;'>Areas of interest</td>
                <td class="<?=($errors->has('country')?'has-error':'')?>">
                    <?php
                    $rs = DB::select("SELECT ID,TITLE FROM mradi_categories WHERE INTRASH='NO'");
                    foreach ($rs as $cats) {
                        //$categories[$cats->ID] = $cats->TITLE;
                        echo Form::checkbox('interest[]', $cats->ID, '', array("class" => "forms-control mradi_forms " . ($errors->has('interest') ? 'has-error' : ''), 'style="width:auto !important;padding:10px !important"')) . " " . $cats->TITLE . " ";
                    }
                    ?>
                    <!--                    width:auto !important;display:relative !important;height:15px !important"-->
                </td>
            </tr>
            <tr>
                <td width='150px;'>Location</td>
                <td class="<?=($errors->has('location')?'has-error':'')?>"><?= Form::text('location', Input::old('location'), array('class' => "form-control mradi_forms ".($errors->has('location')?'has-error':''),'id'=>'location')); ?></td>
            </tr>
            <tr>
                <td width='150px;'>Upload Profile Photo</td>
                <td class="<?=($errors->has('photo')?'has-error':'')?>">            
                    <?= Form::file('photo', array("accept"=>"image/*",'class' => "form-control mradi_forms ".($errors->has('photo')?'has-error':''),'id'=>'photo')); ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><div style="width: 50%;text-align: right">
                        <?php echo Form::submit('Submit', array("class" => "btn btn-flat btn-success")); ?>
                    </div>
                </td>
            </tr>            
            <?= Form::close(); ?>
        </table>


    </div>

</div>
</div>
</center>
</div>

<?php include 'common/footer.php'; ?>
                            