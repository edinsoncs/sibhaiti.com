<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2><?php echo isset($subject) ? $subject : NULL; ?></h2>
        <div>
            <?php echo isset($text) ? $text : NULL; ?>
        </div>
        <div>
            <?php echo isset($url) ? $url : NULL; ?>
        </div>
    </body>
</html>