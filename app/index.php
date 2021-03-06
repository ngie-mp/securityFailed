<?php

$countCom        = 0;
$countSelect     = 0;
$selectedComment = null;

$mysqli = mysqli_connect('mysql', 'root', 'root');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$result = mysqli_query($mysqli,"CREATE DATABASE IF NOT EXISTS security_woot;");
$result = mysqli_query($mysqli,"CREATE TABLE IF NOT EXISTS `security_woot`.`comments` ( `id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(30) NOT NULL , `content` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");

$mysqli->close();
$mysqli = mysqli_connect('mysql', 'root', 'root', 'security_woot');

$comment    = isset($_POST['comment']) && !empty($_POST['comment']) ? htmlentities($_POST['comment']) : false;
$username   = isset($_POST['username']) ? htmlentities($_POST['username']) : false;
$idComment  = isset($_POST['idComment']) && !empty($_POST['idComment']) ? (int)$_POST['idComment'] : false;
$id         = isset($_GET['id']) && !empty($_GET['id']) ? (int)$_GET['id'] : false;


if ($comment && $username) {
    $comment = str_replace(array("<script>", "</script>"),"", $comment);
    $result = mysqli_query($mysqli, 'INSERT INTO security_woot.comments (username, content) VALUES("'.$username.'", "'.$comment.'")');
    header('Location:index.php');
} else if ($idComment) {
    if(is_numeric($idComment)){
        $selectedComment = mysqli_query($mysqli, 'SELECT * FROM comments WHERE id = ' . $idComment .' LIMIT 1 ;');
    }
} else if ($id) {
    if(is_numeric($id)){
        $id = mysqli_query($mysqli, 'DELETE FROM comments WHERE id = ' . $id);
    }
    header('Location:index.php');
} else if ((isset($_POST['comment']) && $_POST['comment'] == "")
            && isset($_POST['username'])  && !$idComment){
    header('Location:index.php');
}

// Récuperation des commentaires
$comments = mysqli_query($mysqli, "SELECT * FROM comments ;");

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php include('./partials/head.php');?>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-2 side-nav">
          <?php include('./partials/nav.php');?>
        </div>
        <div class="col bonus-padding">
          <h1>
          <i class="em em-female-technologist"></i>
            Hack and smile guys, hack and smile
          <i class="em em-male-technologist"></i>
          </h1>
          <form method="POST" action="index.php">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Show</label>
              </div>
              <select class="custom-select" name="idComment" id="inputGroupSelect01">
              <option value="">All...</option>
                <?php foreach ($comments as $com): ?>
                    <?php $countSelect++; ?>
                    <option value="<?= $com['id'] ?>"><?= $countSelect ?></option>
                <?php endforeach; ?>
              </select>
              <button type="submit" class="btn btn-info">Submit</button>
            </div>
          </form>
          <form method="POST" action="index.php">
            <div class="form-group">
              <input name="username" placeholder="Username" class="form-control">
              <textarea name="comment" class="form-control" id="" cols="30" rows="10"></textarea>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
          <?php $comments = !empty($selectedComment) ? $selectedComment : $comments ;?>
          <?php foreach ($comments as $com): ?>
          <?php $countCom++; ?>
            <div class="comments-container">
                <span class="title"><?= $com['username'] ;?></span>
                <p>
                    <?= $com['content'] ;?>
                </p>
                <span class="user-id">#<?= $countCom ;?> From <?= $com['username'] ;?></span>
                <a href="?id=<?= $com['id'] ;?>" class="btn btn-secondary">Delete</a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </body>
</html>
