<?php
if (extension_loaded('gd') && function_exists('gd_info')) {
    echo "PHP GD library is installed on your web server";
}
else {
    echo "PHP GD library is NOT installed on your web server";
}

echo "<pre>"; var_dump(gd_info()); echo "</pre>";

// Let's target an image, copy it, rotate it, and save it
$img = imagecreatefromjpeg("testgd.jpg");
$imgRotated = imagerotate($img, 45, 1);
imagejpeg($imgRotated, "testgdRotated.jpg", 100);

?>

<img src="testgd.jpg" />
<img src="testgdRotated.jpg" />
