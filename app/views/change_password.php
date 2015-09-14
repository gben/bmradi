<?php include 'common/header.php'; ?>
<div>

    <div class="row block-center" style='width: 80%; margin: 0 auto;'>
        <h3>Change Password</h3>
        <?php
        if ($errors->has()) {
            echo "<div class=\"callout callout-danger  has-error\" style=\"color: red;margin-left: 155px\">";
            foreach ($errors->all() as $error) {
                echo $error . "<br/>";
            }
            echo "</div>";
        }
        
        ?>

        <?= Form::open(array('route' => 'prx_change_password','name'=>'change_password')); ?>
        <table class='mradi_table' style="width:80%;" >
            <tr>
                <td style="width:150px;">New Password</td>
                <td class="<?=($errors->has('password')?'has-error':'')?>"><input type='password' class="form-control mradi_forms" name='password' value='' /></td>
            </tr>
            <tr>
                <td style="width:150px;">Confirm Password</td>
                <td class="<?=($errors->has('password_confirm')?'has-error':'')?>"><input type='password' class="form-control mradi_forms" name='password_confirm' value='' /></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <br />
                    <?php echo Session::get('login_message'); ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><button class="btn btn-primary mradi_forms">Change Password</button></td>
            </tr>
            <?= Form::close(); ?>
        </table>

    </div>

</div>

<?php include 'common/footer.php'; ?>
                            
