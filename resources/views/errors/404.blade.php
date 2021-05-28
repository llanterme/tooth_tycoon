<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@600;900&display=swap" rel="stylesheet">
    <style>
        body {
  background-color: #95c2de;
}

.mainbox {
  background-color: #95c2de;
  margin: auto;
  height: 600px;
  width: 600px;
  position: relative;
}

  .err {
    color: #ffffff;
    font-family: 'Nunito Sans', sans-serif;
    font-size: 11rem;
    text-align: center;
  }


.far {
  position: absolute;
  font-size: 8.5rem;
  left: 42%;
  top: 15%;
  color: #ffffff;
}


.msg {
    text-align: center;
    font-family: 'Nunito Sans', sans-serif;
    font-size: 1.6rem;
    position:absolute;
    left: 16%;
    top: 45%;
    width: 75%;
  }

a {
  text-decoration: none;
  color: white;
}

a:hover {
  text-decoration: underline;
}
    </style>
</head>
<body>
    <div class="mainbox">
        <div class="err">404</div>
        <div class="msg">Maybe this page moved? Got deleted? Is hiding out in quarantine? Never existed in the first place?<p>Let's go <a href="{{ asset('/') }}">home</a> and try from there.</p></div>
    </div>
</body>
</html>
