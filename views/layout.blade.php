<!doctype html>
<html>
<head>
  <link rel="icon" href="/libs/221211icon.svg" type="image/svg+xml">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="/libs/bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/230107/views/style.css">


</head>
<body class="bg-lime-100">

    <div class="container" id="app">
    <div>
        <p>
            <header-nav></header-nav>
        </p>

        @yield("content")

        <p>
            footer
        </p>

    </div>
    </div>

  <script src="/libs/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>

  <script src="/libs/vue.js"></script>
  <script src="/230107/script.js"></script>


<!--


-->

</body>
</html>
