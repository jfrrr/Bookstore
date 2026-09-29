<?php

$width = 600;
$height = 800;
$im = imagecreatetruecolor($width, $height);

// Enable antialiasing
imageantialias($im, true);

// Background (warm clean bookstore shelf / studio backdrop)
$bgColor = imagecolorallocate($im, 245, 242, 238);
imagefilledrectangle($im, 0, 0, $width, $height, $bgColor);

// Book parameters (3D perspective / angled book)
// Let's create a beautiful front-3D book mockup:
// Spine on left, front cover in center, page edges visible on right

// Shadow
for ($i = 0; $i < 30; $i++) {
    $alpha = (int)(110 + ($i / 30) * 17);
    $shadowColor = imagecolorallocatealpha($im, 40, 30, 25, $alpha);
    imagefilledrectangle($im, 100 - $i, 80 + $i, 520 + $i, 730 + $i, $shadowColor);
}

// Front Cover background
$coverColor = imagecolorallocate($im, 252, 250, 246); // Atomic habits is off-white
imagefilledrectangle($im, 110, 70, 500, 720, $coverColor);

// Spine on the left edge (crease effect)
for ($x = 110; $x <= 135; $x++) {
    $pct = ($x - 110) / 25;
    $shade = (int)(180 + $pct * 70);
    $spineShade = imagecolorallocate($im, $shade, $shade - 5, $shade - 10);
    imageline($im, $x, 70, $x, 720, $spineShade);
}

// Spine crease highlight line
$highlight = imagecolorallocate($im, 255, 255, 255);
imageline($im, 136, 70, 136, 720, $highlight);

// Right pages edge (layered paper effect)
for ($x = 501; $x <= 518; $x++) {
    $stripe = ($x % 2 == 0) ? 230 : 210;
    $pageColor = imagecolorallocate($im, $stripe, $stripe - 5, $stripe - 10);
    imageline($im, $x, 75, $x, 715, $pageColor);
}

// Text fonts
$fontTitle = 'C:/Windows/Fonts/georgiab.ttf';
$fontRegular = 'C:/Windows/Fonts/arial.ttf';

$textColor = imagecolorallocate($im, 25, 25, 25);
$accentColor = imagecolorallocate($im, 220, 100, 20);

// Draw Atomic Habits title
imagettftext($im, 32, 0, 160, 280, $accentColor, $fontTitle, "ATOMIC");
imagettftext($im, 32, 0, 160, 330, $textColor, $fontTitle, "HABITS");

// Subtitle
imagettftext($im, 12, 0, 160, 380, $textColor, $fontRegular, "Perubahan Kecil yang Memberikan");
imagettftext($im, 12, 0, 160, 400, $textColor, $fontRegular, "Hasil Luar Biasa");

// Author
imagettftext($im, 15, 0, 160, 640, $textColor, $fontTitle, "James Clear");

// Book border outline
$outlineColor = imagecolorallocatealpha($im, 100, 80, 70, 80);
imagerectangle($im, 110, 70, 500, 720, $outlineColor);

imagejpeg($im, 'C:/Project/Project BookStore/bookstore/storage/app/public/test_gd.jpg', 95);
imagedestroy($im);
echo "OK\n";
