<?php include 'common/header.php'; ?>
<div>
    <div class="row" style='width: 80%; margin: 0 auto;'>
        <h3>Complete the form to Join Us</h3>
        <?php if($errors->has()) echo "<div class=\"callout callout-danger  has-error\" style=\"color: red;margin-left: 155px\"><p> Oops! Please correct the fields highlighted</p></div>"; ?>
        
        <?= Form::open(array('route'=>'create_new_account','name'=>'new_account')); ?>
        
        <table class='mradi_table' style="width:80%;" >
            <tr>
                <td width='150px;'>First Name</td>
                <td class="<?=($errors->has('firstname')?'has-error':'')?>"><?= Form::text('firstname', Input::old('firstname'), array('class' => "form-control mradi_forms ".($errors->has('firstname')?'has-error':''),'id'=>'firstname')); ?></td>
            </tr>
            <tr>
                <td width='150px;'>Middle Name</td>
                <td class="<?=($errors->has('middlename')?'has-error':'')?>"><?= Form::text('middlename', Input::old('middlename'), array('class' => "form-control mradi_forms ".($errors->has('middlename')?'has-error':''),'id'=>'middlename')); ?></td>
            </tr>
            <tr>
                <td width='150px;'>Surname</td>
                <td class="<?=($errors->has('lastname')?'has-error':'')?>"><?= Form::text('lastname', Input::old('lastname'), array('class' => "form-control mradi_forms ".($errors->has('lastname')?'has-error':''),'id'=>'lastname')); ?></td>
            </tr>
            <tr>
                <td>Gender </td>
                <td style="padding: 5px;" class="<?=($errors->has('gender')?'has-error':'')?>"><?=($errors->has('gender')?'<font color=red>**</font>':'')?>
                    <input type="radio" name="gender"  value="M" class="" /> Male
                    <input type="radio" name="gender"  value="F" class=""/> Female
               </td>            
            </tr>
            <tr>
                <td width='150px;'>Email Address</td>
                <td class="<?=($errors->has('email')?'has-error':'')?>"><?= Form::text('email', Input::old('email'), array('class' => "form-control mradi_forms email ".($errors->has('email')?'has-error':''),'id'=>'email')); ?></td>
            </tr>
                     
<!--            <tr>
                <td>Username</td>
                <td><?= Form::text('username', '', array('class' => 'form-control mradi_forms required','id'=>'username')); ?></td>
            </tr>-->
            <tr>
                <td>Country</td>
                <td class="<?=($errors->has('country')?'has-error':'')?>">
                     <?php
                            $rs = DB::select("SELECT ID,CODE FROM countries_dbx ");
                            $countries[''] = 'Select Country';
                            foreach ($rs as $cats) {
                                $countries[$cats->CODE] = $cats->ID;
                            }
                            ?>
                    <?= Form::select('country',$countries,Input::old('country'),array("class"=>"form-control mradi_forms ".($errors->has('country')?'has-error':''))) ?> 
                
                </td>
            </tr>
            <tr>
                <td>Phone Number</td>
                <td class="<?=($errors->has('phone_number')?'has-error':'')?>">
                <input type="text" name="phone_number" id="phone_number" value="<?= Input::old('phone_number') ?>" class="form-control mradi_forms <?= ($errors->has('phone_number')?'has-error':'')?>" />
                </td>
            </tr>
            <tr>
                <td>Account Type</td>
                <td style="padding: 5px;" class="<?=($errors->has('account_type')?'has-error':'')?>">
                    <input type="radio" name="account_type"  value="ENTREPRENEUR" class="" /> Entrepreneur
                    <input type="radio" name="account_type"  value="INVESTOR" class=""/> Investor
               </td>            
            </tr> 
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class="btn btn-primary mradi_forms" id="submit_form" value="Submit" style="display: none"/></td>
            </tr>            
            <?= Form::close(); ?>
        </table>

        
    </div>

</div>
</div>
</center>
</div>

<?php include 'common/footer.php'; ?>
                            