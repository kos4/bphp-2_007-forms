<?php
if (empty($_POST['file_name']) || !$_FILES['content']) {
  header('Location: index.html');
}

$path = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
$fileSize = '';
$filePath = '';
$error = '';

try {
  if (!is_dir($path)) {
    if (!mkdir($path, 0777, true) && !is_dir($path)) {
      throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
    }
  }

  $fileName = trim($_POST['file_name']);

  if (file_exists($path . $fileName)) {
    $error = 'Файл с таким именем уже загружен';
  } else {
    $fileSize = number_format($_FILES['content']['size'] / 1024, 4, ',', ' ') . 'Kb';
    $fileSize = 'Размер файла: ' . $fileSize . '<br />';
    $filePath = 'Полный путь до файла: ' . $path . $fileName . '<br />';
    move_uploaded_file($_FILES['content']['tmp_name'], $path . $fileName);
  }
} catch (\Exception $e) {
  $error = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="./assets/css/style.css">
  <title>Upload</title>
</head>
<body>
  <div class="wrapper">
    <div class="error">
      <?php echo $error; ?>
    </div>
    <div class="result">
      <?php echo $fileSize; ?>
      <?php echo $filePath; ?>
    </div>
  </div>
</body>
</html>
