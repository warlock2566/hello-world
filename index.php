<?php
  session_start();
  require('../conn/dbConn.php');
  
  if (isset($_POST['upload']))
  {
    $fullname = $_POST['fullname'];
    $imageName = $_FILES['image']['name'];
    $imageTemp = $_FILES['image']['tmp_name'];
    $imageExt = explode('.', $imageName);
    $ext = strtolower($imageExt[1]);
    $validExt = array('jpg', 'jpeg', 'png');

    if (in_array($ext, $validExt))
    {
      $uploadFolder = 'uploads/' . $imageName;
      move_uploaded_file($imageTemp, $uploadFolder);

      $sql = "INSERT INTO images (fullname, image_name, image_path) VALUES (:fullname, :imageName, :imagePath)";
      $stmt = $conn->prepare($sql);
      $data = [
        ":fullname" => $fullname,
        ":imageName" => $imageName,
        ":imagePath" => $uploadFolder
      ];
      
      if ($stmt->execute($data))
      {
        if ($stmt->rowCount() > 0) 
        {
          echo "File was inserted successfully";
        }
      }
    }

  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="author" content="Michael Inouye">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Uploads || PHP</title>

  <!-- Bootstrap 5.2 CSS & JS files -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom CSS & JS files -->
  <link rel="stylesheet" href="./css/style.css">
  <script defer src="./js/script.js"></script>
</head>
<body>
  <div class="container vh-100 d-flex justify-content-center align-items-center">
    <form action="" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <input type="text" class="form-control" name="fullname" placeholder="Full Name">
      </div>
      <div class="mb-3">
        <input type="file" class="form-control" name="image">
      </div>

      <button type="submit" class="btn btn-primary" name="upload">Upload Image</button>
    </form>
  </div>
  
</body>
</html>