<?php include 'common/header.php'; ?>
<div class="panel-body"  style="width: 80%;margin: auto">
    <div class="alert alert-warning" style="margin: auto">For you create a campaign, you need to meet certain criteria.
    Please fill the questionnaire below to proceed.</div>
    <br/>
    <?php echo Form::open(array('route' => 'ent_qns')); ?>
    <ol>
        <li>I have a team in place <br />
            <input type="radio" name="ent_qns_1" value="YES" />YES <br />
            <input type="radio" name="ent_qns_1" value="NO" />NO  <br />                             
        </li><br />
        <li>My company was incorporated more than 2 years ago<br />
            <input type="radio" name="ent_qns_2" value="YES" />YES <br />
            <input type="radio" name="ent_qns_2" value="NO" />NO<br />
        </li><br />
        <li>My company is incorporated in Kenya<br />
            <input type="radio" name="ent_qns_3" value="YES" />YES <br />
            <input type="radio" name="ent_qns_3" value="NO" />NO<br />
        </li><br />
        <li>I have a marketing plan in place to create momentum for my campaign<br />
            <input type="radio" name="ent_qns_4" value="YES" />YES <br />
            <input type="radio" name="ent_qns_4" value="NO" />NO<br />
        </li><br />
        <li>I am able to adopt the Memorandums and Articles of Association used by MradiFund.com<br />
            <input type="radio" name="ent_qns_5" value="YES" />YES <br />
            <input type="radio" name="ent_qns_5" value="NO" />NO<br />
        </li><br />
        <li>I am able to adopt the format required by MradiFund.com to upload any additional documents<br />
            <input type="radio" name="ent_qns_6" value="YES" />YES <br />
            <input type="radio" name="ent_qns_6" value="NO" />NO<br />
        </li><br />
        <li>I can produce a great, high quality video for my campaign page<br />
            <input type="radio" name="ent_qns_7" value="YES" />YES <br />
            <input type="radio" name="ent_qns_7" value="NO" />NO<br />
        </li><br />
    </ol>
    <div style="width: 50%;text-align: right">
        <?php echo Form::submit('Submit', array("class" => "btn btn-flat btn-success")); ?>
    </div>  
    <?php echo Form::close(); ?>
</div>          
<?php include 'common/footer.php'; ?>
                            
