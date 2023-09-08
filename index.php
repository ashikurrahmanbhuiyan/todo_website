<?php
    //connect to database
    include "connection.php";
    $insert = 0;
    //insert an todo list
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $title = $_POST['title'];
        $descion = $_POST['description'];
        $sql1 = "INSERT INTO `note` (`title`, `description`, `tstamp`)
        VALUES ('$title', '$descion', current_timestamp())";
        $result1 = mysqli_query($conn, $sql1) or die(mysqli_error($conn));
        if ($result1) $insert = 1;
    }


    //change the view
    $choice = 0;
    $choice = $_GET['page'];

    //delete an todo list
    $del = $_GET['del'];
    if($del){
      $sql2 = "DELETE from note where sno = '$del';";
      $result2 = mysqli_query($conn, $sql2);
    }

    //update an to list
    $update = $_GET['update'];
    if($update){
      $sql3 = "SELECT * from note where sno = '$update';";
      $row1 = mysqli_fetch_assoc(mysqli_query($conn, $sql3));
      $t1 = $row1['title'];
      $d1 = $row1['description'];
      $sql5 = "UPDATE note SET title = '$title', description = '$descion' where sno = '$update';";
      $result3 = mysqli_query($conn, $sql3);
    }
?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TO DO App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme = "dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>

        <li class="nav-item">
          <a class="nav-link " aria-disabled="true">Contact Us</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<?php
if ($insert) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your note has been inserted.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> ';
  }
 ?>
<?php
if($update){
  echo '<div class="container my-4">
    <form action = "'. $_SERVER['PHP_SELF'] .'" method = "POST">
  <div class="mb-3">
    <h2>Add a Note</h2>
    <label for="title" class="form-label">Note Title</label>
    <input type="Text" class="form-control" id="title" name ="title" aria-describedby="emailHelp" value = "'.$t1.'">
  </div>
  <div class="mb-3">
  <label for="description" class="form-label">Note Description</label>
  <textarea type = "Text" class="form-control" id="description" name = "description" rows="3">'.$d1.'</textarea>
</div>
  <button type="submit" class="btn btn-primary">Update</button>
</form>
</div>
<div class="d-flex flex-row-reverse">
    <a href = "index.php?page=1"><button type="button" name="card" class="btn btn-primary">Card</button></a>
    <a href = "index.php?page=0"><button type="button" name="list" class="btn btn-primary me-2">List</button></a>
</div>';
}
else{
echo '<div class="container my-4">
    <form action = "'. $_SERVER['PHP_SELF'] .'" method = "POST">
  <div class="mb-3">
    <h2>Add a Note</h2>
    <label for="title" class="form-label">Note Title</label>
    <input type="Text" class="form-control" id="title" name ="title" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
  <label for="description" class="form-label">Note Description</label>
  <textarea type = "Text" class="form-control" id="description" name = "description" rows="3"></textarea>
</div>
  <button type="submit" class="btn btn-primary">Add Note</button>
</form>
</div>
<div class="d-flex flex-row-reverse">
    <a href = "index.php?page=1"><button type="button" name="card" class="btn btn-primary">Card</button></a>
    <a href = "index.php?page=0"><button type="button" name="list" class="btn btn-primary me-2">List</button></a>
</div>';
}

    $sql = "SELECT * FROM note ORDER BY sno DESC";
    $result = mysqli_query($conn, $sql);
if($choice == 0){
echo '<div class="container my-4">';
echo '<table class="table" id = "myTable">
  <thead>
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">Title</th>
      <th scope="col mb-4">Description</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>';
    while($row = mysqli_fetch_assoc($result)){
    echo '<tr>
      <th scope="row">'.$row['sno'].'</th>
      <td>'.$row['title'].'</td>
      <td>'.$row['description'].'</td>
      <td>
      <a href = "index.php?page=0&del='.$row['sno'].'"><button type="button" class="btn btn-danger">Delete </button></a>
      <a href = "index.php?page=1&update='.$row1['sno'].'"><button type="button" class="btn btn-primary">Update</button></a>
      </td>
    </tr>';
    }

 echo' </tbody>
</table>';
}
?>
<?php
if($choice == 1){
?>
<dib class = "row g-0 text-center">
<?php
    while($row1 = mysqli_fetch_assoc($result)){
        echo '
        <div class="card col-sm-6 col-md-4"">
        <div class="card-body">
        <h5 class="card-title">'.$row1['title'].'</h5>
        <p class="card-text">'.$row1['description'].'</p>
        <p>'.$row1['tstamp'].'</p>
        <p>
          <a href="index.php?page=1&del='.$row1['sno'].'"><button type="button" class="btn btn-danger">Delete </button></a>
          <a href="index.php?page=1&update='.$row1['sno'].'"><button type="button" class="btn btn-primary">Update</button></a>
        </p>
        </div>
        </div>';
    }
?>
</row>
<?php
}
?>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
          new DataTable('#myTable');
    </script>
  </body>
</html>
