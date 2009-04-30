<?php

    $BBDD = "eltinglao";
    $SELECT_TB = "SELECT * FROM tipo_banda ORDER BY DESCRIPCION";
    

    include 'connection.php';

    

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="es_ES" xml:lang="es_ES">

    <head>
        <title>Gestor de Contenidos - El Tinglao.net</title>
        <link href="./css/estilo_admin.css" rel="stylesheet" type="text/css" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
    </head>

    <body>
        <div id="container">
            <div id="header">
                <h1>Gestor de Contenidos</h1>
                <h2>El Tinglao.net</h2>
            </div>            
            <?php include 'sidebar.html'; ?>
            <div id="main">
                <h4>Años</h4>
                <table border="0">
                    <?php
                        $result = mysql_db_query("eltinglao", $SELECT_TB);
                        while($row = mysql_fetch_array($result)){

                            echo $row["descripcion"] . "<br/>";

                            $SELECT_B = "SELECT * FROM banda WHERE id_tipo=" . $row["id_tipo"];
                            $result_b = mysql_db_query("eltinglao", $SELECT_B);
                            while($row_b = mysql_fetch_array($result_b)){

                                $id_banda = $row_b["id_banda"];
                                echo "&nbsp;&nbsp;&nbsp;|-----" . $row_b["nombre"] . "<br/>";

                                $SELECT_TG = "select distinct tg.descripcion, tg.id_tipo
                                              from album al
                                              join tipo_grabacion tg
                                              on al.id_tipo_grabacion = tg.id_tipo
                                              where id_banda =" . $row_b["id_banda"]
                                              . " ORDER BY tg.descripcion";
                                $result_tg = mysql_db_query("eltinglao", $SELECT_TG);
                                while($row_tg = mysql_fetch_array($result_tg)){

                                    $id_tg = $row_tg["id_tipo"];
                                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|-----" . $row_tg["descripcion"] . "<br/>";

                                    $SELECT_ANIO = "SELECT DISTINCT an.anio, an.id_anio
                                                    FROM album al
                                                    JOIN anio an
                                                    ON al.id_anio = an.id_anio
                                                    WHERE id_banda = ". $row_b["id_banda"]
                                                    . " ORDER BY an.anio";

                                    $result_anio = mysql_db_query("eltinglao", $SELECT_ANIO);
                                    while($row_anio = mysql_fetch_array($result_anio)){

                                        $id_anio = $row_anio["id_anio"];
                                        $url = "visor.php?id_tg=" . $id_tg . "&id_banda=" . $id_banda . "&id_anio=" . $id_anio;
                                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|-----" . $row_anio["anio"] . " <a href=\"$url\">$url</a><br/>";
                                        
                                    }

                                }


                            }

                        }
                    ?>
                    

                </table>

            </div><!-- main -->

            <div id="footer">El Tinglao.net</div><!-- footer -->


        </div>
    </body>
</html>


