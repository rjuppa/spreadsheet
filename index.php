<?php
function my_autoloader($class) {
    include 'classes/' . $class . '.class.php';
}

spl_autoload_register('my_autoloader');

//echo phpinfo();
?>

<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Spreadsheet</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="dist/css/bootstrap.css">
<link rel="stylesheet" href="dist/css/bootstrap.css.map">
<link rel="stylesheet" href="app.css">
</head>
<body>

<div class="container">
    <div class="row">
        <h4>Spreadsheet</h4>
        <?php
        $cli = '';
        $sh = new Sheet();
        $errs = array();
        $method = $_SERVER['REQUEST_METHOD'];
        if( $method == 'POST'){
            $cli = $_POST['cli'];
            $arr = explode('<br />', nl2br($cli));
            foreach($arr as $cmd){
                $cmd = preg_replace("/[^a-zA-Z0-9.(:)=]/", "", $cmd);
                if( $cmd) {
                    try{
                        $sh->command($cmd);
                    }
                    catch (Exception $e){
                        array_push($errs, $e->getMessage());
                    }
                }
            }

            //var_dump($arr);
        }

        echo $sh->renderSheet();

        ?>
    </div>

    <div class="clearfix"></div>
    <hr>
    <div class="col-md-6">
        <label>CLI:</label>
        <form action="" method="post">
            <textarea name="cli" rows="10" cols="40" ><?php echo $cli; ?></textarea>
            <div class="clearfix"></div>
            <input type="submit" value="Enter" class="btn btn-success">
        </form>
        <div class="clearfix"></div>
        <label>Hint:</label>
        <pre>
c5=1.3
b2=1000
c2=0.26
d2=0
g2=SUM(b2:d2)
c8=sum(c1:c5)
d8=8.01
e8=sum(c8:d8)
        </pre>
    </div>
    <div class="col-md-6">
        <label>Errors:</label>
        <?php
            foreach($errs as $err){
                echo '<div class="label-danger">' . $err . '</div>';
            }
        ?>
    </div>
    <div class="clearfix"></div>
    <a href="test.php" target="_blank">testy</a>
</div>


<?php
//$sh = new Sheet();
//var_dump($sh);

//echo $sh->renderSheet();


?>
</body>
</html>
