if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_FILES['image'])) {
        $_SESSION['errormessages'][] = "Image error : Select an image";
    } else {
        $tempfile = $_FILES['image']['tmp_name'];
        $type = $_FILES['image']['type'];
        $image_name = addslashes($_FILES['image']['name']);
        if ($_FILES['image']['error'] > 0) {
            $_SESSION['errormessages'][] = "Upload error : please try again";
            header('location: /');
            exit(0);
        }
        if (empty($tempfile)) {
            $_SESSION['errormessages'][] = "Upload error : please try again";
        } else {
            $image_size = $_FILES['image']['size'];
            $oneMB = 1024 * 1024;
            $allowed = array('image/gif', 'image/png', 'image/jpg', 'image/jpeg');
            if ($image_size > (5 * $oneMB)) {
                $_SESSION['errormessages'][] = "Upload error : Image size too big. Max 5MB allowed.";
            } elseif ($image_size == FALSE) {
                $_SESSION['errormessages'][] = "Upload error : Only images allowed";
            } elseif (!in_array($type, $allowed)) {
                $_SESSION['errormessages'][] = "Upload error : Only gif, png & jpg extensions are allowed";
            } else {
                resize();
                header('location: index.php');
                exit(0);
            }
        }
    }
}

header('location:index.php');

function resizesmall($tempfile, $img_name, $type) {
    list($width, $height) = getimagesize($tempfile);
    $newWidth = 100;
    $newHeight = 100;
    if ($type == 'image/jpeg' || $type == 'image/jpg') {
        $src = imagecreatefromjpeg($tempfile);
        $tmp = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagejpeg($tmp, "img/" . $img_name . "", 80);
    } elseif ($type == 'image/gif') {
        $src = imagecreatefromgif($tempfile);
        $tmp = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagegif($tmp, "img/" . $img_name . "", 80);
    } elseif ($type == 'image/png') {
        $src = imagecreatefrompng($tempfile);
        $tmp = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagepng($tmp, "img/" . $img_name . "", 8);
    }

    imagedestroy($src);
    imagedestroy($tmp);
}


