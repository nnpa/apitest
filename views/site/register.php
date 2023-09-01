<br>
<br>
<?php foreach($errors as $error):?>
    <?php echo $error;?>
<?php endforeach; ?>
<br>
<br>
<form method="POST">
    <b>Email</b><input type="text" name="email"><br><br>
    <b>Имя</b><input type="text" name="name"><br><br>

    <input class="btn btn-success" type="submit">
</form>