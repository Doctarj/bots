<?php
?>

    <html>
    <head>
        <title>Поисковый агент</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/themes/style.css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
              integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
              crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
              integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp"
              crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>
    </head>

    <body>
    <div class="container">

        <div class="row">
            <div class="col-md-12 hidden-phone"><h1 class="page-header">Поисковый агент</h1></div>
        </div>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <h2>Введите адрес сайта</h2>

                <form method="post" action="index.php">
                    <input type="url" name="url" placeholder="адрес сайта">
                    <input class="btn btn-primary pull-right" type="submit" value="Find">
                </form>


            </div>
        </nav>
    </body>


    </html>
<?php
    $bots = "/robots.txt";
  $url = $_POST['url'];
 $arr = explode("/", $url);
   $urlBots = $url . $bots;

$headers = @get_headers($urlBots);
if($headers){
    echo "Файл robots.txt присутствует <br/>";
}
else{
    echo "Файл robots.txt отсутствует <br/>";
    die();
}

preg_match('^\d{3}^', $headers[4], $matches);

$size = $matches[0] / 1000;

if($size <= 32){
    echo "Размер файла robots.txt составляет $size, что находится в пределах допустимой нормы <br/>";
}
else{
    echo "Размера файла robots.txt составляет $size кб, что превышает допустимую норму <br/>";
}
$string = file_get_contents($urlBots);
$host = explode("Host", $string);
$host = count($host) - 1;

if($host >= 1){
    echo "Директива Host указана<br/>";
    if($host ==1){
        echo "В файле прописана 1 директива Host<br/>";
    }
    else{
        echo"В файле прописано несколько директив Host<br/>";
    }
}
else{
   echo "В файле robots.txt не указана директива Host<br/>";
}
$siteMap = explode("sitemap", $string);
$siteMap = count($siteMap) - 1;
if($siteMap >= 1){
    echo "Директива Sitemap указана<br/>";
}
else{
    echo "В файле robots.txt не указана директива Sitemap<br/>";
}
preg_match('^\d{3}^', $headers[0], $matches);
if($matches[0] == 200){
    echo "Файл robots.txt отдаёт код ответа сервера $matches[0]";
}
else{
  echo  "При обращении к файлу robots.txt сервер возвращает код ответа $matches[0]";
}