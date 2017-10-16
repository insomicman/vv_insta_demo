<!DOCTYPE HTML>  
<html>
<head>
<link rel="stylesheet" type="text/css" href="CSS/page.css" />
</head>
<body>  
<?php 
// define variables and set to empty values
$nameErr = $name = $tag = $tagErr = "";
$totalLikes = 0;
//$selectedField = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"]) && $selectedField == 1) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function set_selected() {
  alert("Submit button clicked!");
}
?>

<h2 id="title">Enter Instagram Username:</h2><br>
<form id="username" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">  
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <input type="submit" name="submitName" value="Submit">
  
</form>


<?php
    $json = file_get_contents('https://www.instagram.com/'.$name.'/media/');
//  elseif($selectedField == 2){
 //   $json = file_get_contents('https://api.instagram.com/v1/tags/' . $tag . '/media/recent');
//  }
  $instagram_feed_data = json_decode($json, true);
  $numOfPics = count($instagram_feed_data['items']);
  //$followercount = $instagram_feed_data['user']['follows']['count'];
  if (isset($instagram_feed_data['items'])) {
    echo "<br><h3>Pictures Returned:".$numOfPics."</h3>";
    //echo "<br><h3>Followers:".$followercount."</h3>";
      foreach ($instagram_feed_data['items'] as $item) {
          $link = $item['link'];
          $img_url = $item['images']['low_resolution']['url'];
          $likes = $item['likes']['count'];
          $caption = isset($item['caption']) ? $item['caption']['text'] : '';
          $totalLikes += $likes;
          ?>
          <a href="<?= $link; ?>" target="_blank" class="instagram-post">
              <img src="<?= $img_url; ?>">
              <div class="caption"><?= $caption; ?></div>
          </a>
          <div class="likes"><?= "Likes: " . $likes; ?></div>
          <?php
      } echo "<br>Total Likes: " . $totalLikes;
  }elseif(isset($_POST['submit'])) echo '<script language="javascript">'.'alert("Nothing Returned! Please Enter a Valid Username.")'.'</script>';
?>
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="site.js"></script>
</body>
</html>