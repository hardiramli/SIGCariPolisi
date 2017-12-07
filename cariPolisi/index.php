<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Mediku</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/main.css" />
        <link href="css/mediku2.css" rel="stylesheet">
        <style>
            #map {
                height: 100%;
            }
            /* Optional: Makes the sample page fill the window. */
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
            .controls {
                margin-top: 10px;
                border: 2px solid transparent;
                border-radius: 2px 0 0 2px;
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                height: 40px;
                outline: none;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            }

            #pac-input {
                background-color: #fff;
                font-family: Roboto;
                font-size: 18px;
                font-weight: 300;
                margin-left: 12px;
                padding: 0 11px 0 13px;
                text-overflow: ellipsis;
                width: 300px;
            }

            #pac-input:focus {
                border-color: #4d90fe;
            }

            .pac-container {
                font-family: Roboto;
            }

            #type-selector {
                color: #fff;
                background-color: #4d90fe;
                padding: 5px 11px 0px 11px;
            }

            #type-selector label {
                font-family: Roboto;
                font-size: 13px;
                font-weight: 300;
            }
            #target {
                width: 345px;
            }
        </style>
    </head>
    <body>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

        <div class="container">
            <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header col-md-12">
                        <div class="col-md-4">
                            <label style="font-size:30px"><a href="index.php"><img src="assets/medikuLogo.png" style="height: 40px"/>  Mediku<br></a> </label>                            
                        </div>
                        <div class="col-md-3">                          
                        </div>                       
                        <div class="col-md-5" id="kanan">
                            <label style="color:white;">Tugas Akhir Sistem Informasi Geografis People Power</label>                       
                        </div>
                    </div>
                </div>
            </nav>
        </div>       
    <body class="landing">

        <!-- Banner -->
        <section id="banner">
            <img src="assets/medikuLogo.png" style="height: 125px"/>
            <br>
            <label style="font-size:48px;color: white;">Mediku</label>
            <p>Temukan Rumah Sakit dan Puskesmas Terdekat di Sekitar Anda</p>
            <ul class="actions">
                <li><a href="map.php" class="button big special">Cari Sekarang</a></li>
            </ul>
        </section>
    </body>

</body>

</html>