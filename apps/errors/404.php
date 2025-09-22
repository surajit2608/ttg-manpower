<?php
http_response_code(404);
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>404 Not Found :: <%SITE_TITLE%></title>
  <style type="text/css">
    .login-wrap {
      display: table;
      position: absolute;
      width: 100%;
      height: 100%;
      margin-top: -3rem;
      text-align: center;
    }

    .error-box {
      width: 400px;
      display: table-cell;
      text-align: center;
      vertical-align: middle;
    }

    .error-box .error404-500 {
      font-family: 'Rubik', serif;
      font-size: 8rem;
      font-weight: 900;
    }

    .error-box .error-blue {
      color: #309CE4;
    }

    .error-box .error-icon {
      margin: 0 1rem;
    }

    .error-box .error-green {
      color: #24C19C;
    }

    .error-box h3 {
      font-family: 'Rubik', serif;
      font-weight: 700;
      margin-bottom: 30px;
      font-size: 2rem;
      color: #666;
    }
  </style>
</head>

<body>

  <div class="login-wrap">
    <form class="error-box">
      <p>
        <span class="error404-500 error-blue">4</span>
        <span class="error404-500 error-icon">0</span>
        <span class="error404-500 error-green">4</span>
      </p>
      <h3>Ooops, 404 page not found!</h3>
      <p class="small text-center text-muted">The page you are looking for cannot be found. Go home by <a href="<%SITE_URL%>/">clicking here</a>!</p>
    </form>
  </div>

</body>

</html>