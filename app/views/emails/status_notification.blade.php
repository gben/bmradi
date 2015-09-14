<!DOCTYPE html>
<!--
Mradifund Email template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <style>
        body {padding: 20px; font-family: 'Century Gothic'; font-weight: 400; font-size: 14px;}
        #container { border: 1px #7b8a8b solid; }
        .footer { font-size: 10px;}
    </style>
    <body>
        <div id="container">
            <p>
                Dear {{Session::get('email_names')}},<br/><br/>
                <b>Re:Campaign {{Session::get('campaign_status')}}</b>
                <br /><br />{{Session::get('email_message')}}
            </p>
            <br>
            <br>
            Kind Regards,<br>
            MradiFund Admin
            <hr />
            <p class="footer">
                All rights reserved &copy; <?= date('Y'); ?> Mradifund
            </p>
        </div>
    </body>
</html>