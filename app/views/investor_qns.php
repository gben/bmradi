<?php include 'common/header.php'; ?>
<div class="panel-body" style="width: 80%;margin: auto">
    <div class="alert alert-warning" style="margin: auto">For you to become an investor you need to understand the gains and risks of investing.
    Please fill the questionnaire below to proceed</div>
    <br/>
    <?php echo Form::open(array('route' => 'inv_qns')); ?>
    <ol>
        <li>Most early stage companies:<br />
            <input type="radio" name="ent_qns_1" value="A" />Succeed<br />
            <input type="radio" name="ent_qns_1" value="B" />Break Even<br />  
            <input type="radio" name="ent_qns_1" value="C" />Fail  <br />  
        </li><br />
        <li>If I invest in the equity of a growing business, and the business fails: <br />
            <input type="radio" name="ent_qns_2" value="A" />No one will be liable to pay me back the amount I invested, and my investment will be lost<br />
            <input type="radio" name="ent_qns_2" value="B" />The entrepreneurs who founded the startup will be personally liable to pay me back the amount I invested <br />  
            <input type="radio" name="ent_qns_2" value="C" />The broker or finder who arranged the transaction will be liable to pay me back the amount I invested  <br />  
        </li><br />
        <li>If I invest in the equity of a growing business, and I decide I want my money back:<br />
            <input type="radio" name="ent_qns_3" value="A" />I will be able to surrender my shares to the company, and it will give my money back <br />
            <input type="radio" name="ent_qns_3" value="B" />I will be able to sell my shares on a stock exchange at any time<br />  
            <input type="radio" name="ent_qns_3" value="C" />I may not be able to sell my shares unless the startup is bought by another company or floats on a stock exchange<br />  
        </li><br />
        <li>Growing business generally: <br />
            <input type="radio" name="ent_qns_4" value="A" />Do not pay dividends to their investors <br />
            <input type="radio" name="ent_qns_4" value="B" />Begin paying dividends to their investors within a year after the investment is made  <br />  
            <input type="radio" name="ent_qns_4" value="C" />Pay dividends to their investors from immediately after the investment is made  <br />  
        </li><br />
        <li>If I invest in the equity of a growing business, it succeeds, and I want to cash in on the success: <br />
            <input type="radio" name="ent_qns_5" value="A" />I will definitely be able to find someone to buy my shares in the startup at any point <br />
            <input type="radio" name="ent_qns_5" value="B" />Unless the startup is bought by another company or floats on a stock exchange, it may be difficult to find someone to buy my shares  <br />  
            <input type="radio" name="ent_qns_5" value="C" />The startup will always be required to buy back my shares at a set price  <br />  
        </li><br />
        <li>If my shares represents 1% of the company's equity at the time I make the investment, and then the company issues additional shares at a later date: <br />
            <input type="radio" name="ent_qns_6" value="A" />My shares will continue to represent 1% of the startup's equity <br />
            <input type="radio" name="ent_qns_6" value="B" />Due to dilution, my shares will come to represent less than 1% of the startup's equity  <br />  
            <input type="radio" name="ent_qns_6" value="C" />Due to accretion, my shares will come to represent more than 1% of the startup's equity over time  <br />  
        </li><br />
        <li>Best practice when investing in startups involves: <br />
            <input type="radio" name="ent_qns_7" value="A" />Investing a small proportion of your available capital in startups, allocating the majority of your capital to safer investments<br />
            <input type="radio" name="ent_qns_7" value="B" />Investing most of your available capital in startups, with very little allocated to safer investments <br />  
        </li><br />

    </ol>
    <div style="width: 50%;text-align: right">
        <?php echo Form::submit('Submit', array("class" => "btn btn-flat btn-success")); ?>
    </div>    
    <?php echo Form::close(); ?>
</div>

<?php include 'common/footer.php'; ?>
                            
