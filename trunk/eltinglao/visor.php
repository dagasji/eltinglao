<?php

    $BBDD = "eltinglao";
    $id_anio = $_REQUEST['id_anio'];
    $id_banda = $_REQUEST['id_banda'];
    $id_tg = $_REQUEST['id_tg'];

    $SELECT_ALBUM = "SELECT al.id_album 'ID',
                            al.descripcion 'DESCRIPCION',
                            al.carpeta 'ALBUM_CARPETA',
                            an.anio 'ANIO_CARPETA',
                            b.carpeta 'BANDA_CARPETA',
                            tg.carpeta 'TG_CARPETA',
                            tb.carpeta 'TB_CARPETA'
                    FROM album al,
                        anio an,
                        banda b,
                        tipo_grabacion tg,
                        tipo_banda tb
                    WHERE al.id_anio = an.id_anio
                        AND al.id_tipo_grabacion = tg.id_tipo
                        AND al.id_banda = b.id_banda
                        AND tb.id_tipo = b.id_tipo
                        AND an.id_anio = $id_anio
                        AND tg.id_tipo = $id_tg
                        AND b.id_banda = $id_banda";


    include 'connection.php';
//echo $SELECT_ALBUM;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">

    <head>
        <title>El Tinglao.net</title>
        <link href="./css/styles.css" rel="stylesheet" type="text/css" />
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">

        <script>
                function mostrarReproductor(url){                        
                    window.open("./reproductor.php?url=" + url, "", "width=280,height=30,location=no,directories=no, status=no,scrollbars=no,toolbar=no, menubar=no,resizable=yes");
                }
        </script>

    </head>

    <body>
        <div id="container">
            <div id="content">
            <table width= "500px">
            <?php

                $result = mysql_db_query("eltinglao", $SELECT_ALBUM);

                while($row = mysql_fetch_array($result)){

                    $id = $row["ID"];
                    $nombre_album = $row["DESCRIPCION"];
                    $url = "http://localhost:85/eltinglao/" .
                           $row["TB_CARPETA"] . "/" .
                           $row["BANDA_CARPETA"] . "/" .
                           $row["TG_CARPETA"] . "/" .
                           $row["ANIO_CARPETA"] . "/" .
                           $row["ALBUM_CARPETA"] . "/";

                    $result_marcha = mysql_db_query($BBDD, "select * from marcha where id_album = $id");

                    echo "<tr>";
                    echo "<td colspan=\"3\" class=\"titulo\">" .$nombre_album ."</td>";
                    echo "</tr>";

                    while($row2 = mysql_fetch_array($result_marcha)){
                        $wma =  $url . $row2["fichero"];
                        $wma = str_replace(" ", "%20", $wma);
                        $mp3 = $wma;
                        $mp3 = substr($mp3, 0, strlen($wma) - 4) . ".mp3";

                        echo "<tr>";
                        echo "<td>" . $row2["nombre"] ."</td>";
                        echo "<td><a href=\"#\" onclick=\"javascript:mostrarReproductor('" . $wma . "')\">";
                        echo "<img src=\"./imagenes/play.png\" width=\"25%\" alt=\"Reproducir\" border=\"0\" /></a></td>";
                        echo "<td><a href=\"" . $mp3 . "\"><img src=\"./imagenes/disc.png\" width=\"35%\" alt=\"Descargar\"  border=\"0\"/></a></td>";
                        echo "</tr>";
                    }
                }

                mysql_close($link);
            ?>
            </table>
            </div>
        </div>

    </body>
</html>


