<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cebroad</title>
  <!-- Bootstrap -->
    <link href="/portfolio/cebroad/webroot/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/portfolio/cebroad/webroot/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/portfolio/cebroad/webroot/assets/css/form.css" rel="stylesheet">
    <link href="/portfolio/cebroad/webroot/assets/css/timeline.css" rel="stylesheet">
    <link href="/portfolio/cebroad/webroot/assets/css/signup.css" rel="stylesheet">
    <link href="/portfolio/cebroad/webroot/assets/css/main.css" rel="stylesheet">
    <script src="/portfolio/cebroad/webroot/assets/js/jquery.min.js"></script>
    <script src="/portfolio/cebroad/webroot/assets/js/jquery.Jcrop.js"></script>
    <script type="text/javascript">
    $(function(){

      $('#cropbox').Jcrop({
        aspectRatio: 1,
        onSelect: updateCoords
      });

    });

    function updateCoords(c)
    {
      $('#x').val(c.x);
      $('#y').val(c.y);
      $('#w').val(c.w);
      $('#h').val(c.h);
    };

    function checkCoords()
    {
      if (parseInt($('#w').val())) return true;
      alert('Please select a crop region then press submit.');
      return false;
    };

    function check() {
      if (window.confirm('You added the informations. Okay?')) {
        return true;
      } else {
        return false;
      }
    };

    function check2() {
      if (window.confirm('You did not add the informations. Okay?')) {
        return true;
      } else {
        return false;
      }
    };

  </script>
  <style type="text/css">
    #target {
      background-color: #ccc;
      width: 500px;
      height: 330px;
      font-size: 24px;
      display: block;
    }
  </style>
</head>
<body>
  <?php
      $url = 'views/'.$resource.'/'.$action.'.php';
      // echo $url;
  ?>

  <?php if (@file_get_contents($url)):?>
      <?php require($url); ?>
  <?php else: ?>
      <h1>Sorry, we couldn't find that page.</h1>
      <a href="/portfolio/cebroad/events/index">Go to the top page</a>
  <?php endif; ?>
</body>
</html>
