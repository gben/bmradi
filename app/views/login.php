<?php include 'common/header.php'; ?>
<div>

    <div class="row block-center" style='width: 80%; margin: 0 auto;'>

        <h3>Login</h3>
        <?= Form::open(array('route' => 'prx_user_authentication')); ?>
        <table class='mradi_table' style="width:80%;" >
            <tr>
                <td width='150px;'>Username</td>
                <td><?= Form::text('_username', '', array('class' => 'form-control mradi_forms')); ?></td>
            </tr>

            <tr>
                <td>Password</td>
                <td><input type='password' class="form-control mradi_forms" name='_password' value='' /></td>
            </tr>
            <tr>
                <td>Account type</td>
                <td class="<?=($errors->has('account_type')?'has-error':'')?>">
                    <?php
                    $account['other'] = 'Select Account';
                    $account['investor'] = 'Investor';
                    $account['entrepreneur'] = 'Entrepreneur';
                    ?>
                    <?= Form::select('account_type',$account,'',array("class"=>"form-control mradi_forms ".($errors->has('account_type')?'has-error':''))) ?> 

                </td>
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
                <td><button class="btn btn-success mradi_forms">Sign In</button></td>
            </tr>
            <?= Form::close(); ?>
        </table>
    </div>

</div>

<?php include 'common/footer.php'; ?>
                            
