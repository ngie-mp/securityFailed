<?php

$hasPassed = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] === 'http://powned.hack';

?>

<!doctype html>
<html lang="en">
<?php include('./partials/head.php');?>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-2 side-nav">
        <?php include('./partials/nav.php');?>
      </div>
      <div class="col">
        <h1>
          Redirect challenge <br>
          <i class="em em-arrow_heading_up"></i>
          <i class="em em-grinning_face_with_one_large_and_one_small_eye"></i>
          <i class="em em-arrow_heading_down"></i>
        </h1>
        <div class="cookie-result">
          <?php if (!$hasPassed): ?>
              <p>You need access from <a href="http://powned.hack">http://powned.hack</a> to hack this page</p>
          <?php endif; ?>
          <?php if ($hasPassed): ?>
              <p>You passed ! <i class="em em-i_love_you_hand_sign"></i></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
