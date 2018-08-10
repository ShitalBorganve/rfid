<!DOCTYPE html>
<html>
<head>
<?php echo '<title>'.$title.'</title>'.$meta_scripts.$css_scripts; ?>
<style>
#display-photo-container{
  height: 10em;
  margin-bottom: 10px;
}
</style>
</head>

<body>
<?php echo $navbar_scripts; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
    <?php
        echo "Message Left: <b>".$MessagesLeft."</b><br>";
        echo "APICODE: <b>".$ApiCode."</b><br>";
        echo "Expires On: <b>".date("F d, Y",strtotime($ExpiresOn))."</b><br>";
        echo "Max Messages: <b>".$MaxMessages."</b><br>";
    
    ?>
    </div>
  </div>

</div>
<?php echo $modaljs_scripts;

?>





<?php echo $js_scripts; ?>

</body>
</html>