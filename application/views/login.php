<?php
echo $image;
echo "<br />";
echo $word;
echo form_open('captcha/verify');
    $data = array(
        'name'          => 'captcha',
        'id'            => 'username',
        'maxlength'     => '100',
        'size'          => '50',
        'style'         => 'width:50%'
    );

echo form_input($data);
    echo '<input type="submit" name="" value="submit" >';
echo form_close();