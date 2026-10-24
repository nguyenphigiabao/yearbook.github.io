<?php

include 'core.inc.php';

if(!logged_in()){
    redirect('index.php');
}

$user_id = (int)($_GET['user_id'] ?? 0);

if($user_id < 1){
    die('Invalid user ID');
}

if(!isset($_FILES['uploaded'])){
    die('No file uploaded');
}

$file = $_FILES['uploaded'];

// Upload error controleren
if($file['error'] !== UPLOAD_ERR_OK){
    redirect('user.php?file_error&id='.$user_id);
}

// Controleren of het daadwerkelijk een afbeelding is
$check = getimagesize($file['tmp_name']);

if($check === false){
    redirect('user.php?type_error&id='.$user_id);
}

// Extensie ophalen
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

$allowed_extensions = [
    'jpg',
    'jpeg',
    'png',
    'gif'
];

if(!in_array($ext, $allowed_extensions)){
    redirect('user.php?file_error&id='.$user_id);
}


// Upload map
$target_dir = __DIR__ . '/uploads/';

// Nieuwe bestandsnaam
$filename = 'profile_'.$user_id.'.'.$ext;

$target_file = $target_dir . $filename;


// Bestaande profielfoto verwijderen
$extensions = ['jpg', 'jpeg', 'png', 'gif'];

foreach($extensions as $existing_ext){

    $existing_file = $target_dir . 'profile_'.$user_id.'.'.$existing_ext;

    if(file_exists($existing_file)){
        unlink($existing_file);
    }
}


// Grote afbeelding comprimeren
if($file['size'] > 1100000){

    $compressedImage = compressImage(
        $file['tmp_name'],
        $target_file,
        90
    );

    if(!$compressedImage){
        die('Image compression failed');
    }

}else{

    if(!move_uploaded_file(
        $file['tmp_name'],
        $target_file
    )){
        die('There was an error uploading the file');
    }
}


// Klaar
redirect('user.php?id='.$user_id);
?>