<form action="<?php echo base_url('login/verify'); ?>" method="post">
<!-- the form elements you need followed by the captcha image and the captcha form element-->
<input type="text" name="word" />
<?php echo $image;

 // this will show the captcha image?>
<input type="submit" name="submit" value="submit" />
</form>