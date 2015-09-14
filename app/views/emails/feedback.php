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
            <h3>Mradifund website feedback</h3>
            <p>
                From: <?php echo $names; ?>, 
                <br />Email: <?php echo $email_address; ?>
                <br />
                <br />
                Message: <?php echo $description; ?>
            </p>
            <hr />
            <p class="footer">
                All rights reserved &copy; <?= date('Y'); ?> Mradifund
            </p>
        
    </body>
</html>