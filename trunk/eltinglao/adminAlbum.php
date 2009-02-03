<?php

    $BBDD = "eltinglao";
        $SELECT = "SELECT al.id_album 'ID',
                    al.descripcion 'DESCRIPCION',
                    al.carpeta 'ALBUM_CARPETA',
                    an.anio 'ANIO',
                    an.id_anio 'ID_ANIO',
                    b.nombre 'BANDA',
                    b.id_banda 'ID_BANDA',
                    tg.descripcion 'TG',
                    tg.id_tipo 'ID_TG',
                    tb.descripcion 'TB'
                FROM album al,
                    anio an,
                    banda b,
                    tipo_grabacion tg,
                    tipo_banda tb
                WHERE al.id_anio = an.id_anio
                    AND al.id_tipo_grabacion = tg.id_tipo
                    AND al.id_banda = b.id_banda
                    AND tb.id_tipo = b.id_tipo";
    

    $SELECT_COMBO_ANIO = "SELECT * FROM anio a";
    $SELECT_COMBO_TG = "SELECT * FROM tipo_grabacion t";
    $SELECT_COMBO_B = "SELECT id_banda, nombre FROM banda b";

    include 'connection.php';

    $metodo = $_POST['metodo'];
    $id = $_POST['id'];
    $descripcion = $_POST['descripcion'];
    $carpeta = $_POST['carpeta'];
    $banda = $_POST['banda'];
    $tg = $_POST['tg'];
    $anio = $_POST['anio'];
    

    //NUEVO
    if($metodo == 'nuevo' && $descripcion != '' && $carpeta != '' && $banda != '' && $tg != '' && $anio != ''){
        $INSERT = "INSERT INTO album (descripcion, carpeta, id_anio, id_tipo_grabacion, id_banda) " .
            "VALUES('$descripcion', '$carpeta', $anio, $tg, $banda)";
        $result = mysql_db_query("eltinglao", $INSERT);
    }
    
    //MODIFICAR
    if($metodo == 'modificar' && $descripcion != '' && $carpeta != '' && $banda != '' && $tg != '' && $anio != ''){
        
        $UPDATE = "UPDATE album
                  SET descripcion = '$descripcion',
                      carpeta = '$carpeta',
                      id_anio=$anio,
                      id_tipo_grabacion=$tg,
                      id_banda=$banda
                  WHERE id_album = $id";
        
        $result = mysql_db_query("eltinglao", $UPDATE);

    }

    //ELIMINAR
    if($metodo == 'delete' && $id != ''){

        $DELETE = "DELETE FROM album WHERE id_album = $id";

        $result = mysql_db_query("eltinglao", $DELETE);

    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="es_ES" xml:lang="es_ES">

    <head>
        <title>Gestor de Contenidos - El Tinglao.net</title>
        <link href="./css/estilo_admin.css" rel="stylesheet" type="text/css" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <script>
            function editar(id, descripcion, carpeta, banda, tg, anio ){
                document.formulario.metodo.value = 'modificar';
                document.formulario.id.value = id;
                document.formulario.descripcion.value = descripcion;
                document.formulario.carpeta.value = carpeta;
                document.formulario.banda.value = banda;
                document.formulario.tg.value = tg;
                document.formulario.anio.value = anio;

            }

            function eliminar(id){
                document.formulario.metodo.value = 'delete';
                document.formulario.id.value = id;
                document.formulario.submit();
            }

            function validar(){
                if(document.formulario.descripcion.value == ''){
                    alert("Debe indicar un nombre para el album");
                    return false;

                }
                if(document.formulario.carpeta.value == ''){
                    alert("Debe indicar una carpeta");
                    return false;                    
                }
                if(document.formulario.tg.value == ''){
                    alert("Debe indicar un tipo de grabacion");
                    return false;
                }
                if(document.formulario.banda.value == ''){
                    alert("Debe indicar una banda");
                    return false;
                }
                if(document.formulario.anio.value == ''){
                    alert("Debe indicar un año");
                    return false;
                }

            }


        </script>

    </head>

    <body>
        <div id="container">
            <div id="header">
                <h1>Gestor de Contenidos</h1>
                <h2>El Tinglao.net</h2>
            </div>            
            <?php include 'sidebar.html'; ?>
            <div id="main">
                <h4>Album</h4>
                <table border="0" cellspacing="13" >
                    <tr>
                        <td><b>Cod.</b></td>
                        <td><b>Nombre</b></td>
                        <td><b>Carpeta</b></td>
                        <td ><b>Año</b></td>
                        <td><b>Banda</b></td>
                        <td ><b>Tipo Grab.</b></td>
                        <td ><b>&nbsp;</b></td>
                    </tr>
                    <?php
                        $result = mysql_db_query("eltinglao", $SELECT);
                        while($row = mysql_fetch_array($result)){
                    ?>
                        <tr>
                            <td>
                                <a href="#" onclick="javascript:editar(<?php echo $row["ID"]?> , '<?php echo $row["DESCRIPCION"]?>', '<?php echo $row["ALBUM_CARPETA"]?>', '<?php echo $row["ID_BANDA"]?>', '<?php echo $row["ID_TG"]?>', '<?php echo $row["ID_ANIO"]?>' )"><?php echo $row["ID"]?></a>
                            </td>
                            <td>
                                <?php echo $row["DESCRIPCION"]?>
                            </td>
                            <td>
                                <?php echo $row["ALBUM_CARPETA"]?>
                            </td>
                            <td>
                                <?php echo $row["ANIO"]?>
                            </td>
                            <td>
                                <?php echo $row["BANDA"]?>
                            </td>

                            <td>
                                <?php echo $row["TG"]?>
                            </td>
                            <td>
                                <a href="#" onclick="javascript:eliminar(<?php echo $row["ID"]?> )"><img src="./imagenes/btn_eliminar.JPG" alt="Eliminar" border="0"/></a>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                </table>
                <h4>Detalle</h4>
                <form name="formulario" method="post" action="adminAlbum.php"  onSubmit="return validar()">
                    <input type="hidden" name="metodo" value="nuevo" />
                    <input type="hidden" name="id" />
                    <table>                        
                        <tr>
                            <td>Nombre del Album</td>
                            <td><input type="text" name="descripcion"/></td>
                        </tr>
                        <tr>
                            <td>Carpeta</td>
                            <td><input type="text" name="carpeta"/></td>
                        </tr>
                        <tr>
                            <td>Banda</td>
                            <td>
                                <select name="banda">
                                        <option value=""></option>
                                    <?php
                                        $result = mysql_db_query("eltinglao", $SELECT_COMBO_B);
                                        while($combo_b = mysql_fetch_array($result)){
                                    ?>
                                        <option value="<?php echo $combo_b["id_banda"]?>"><?php echo $combo_b["nombre"]?></option>
                                    <?php
                                        }
                                    ?>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td>Tipo de grabaci&oacute;n</td>
                            <td>
                                <select name="tg">
                                        <option value=""></option>
                                    <?php
                                        $result = mysql_db_query("eltinglao", $SELECT_COMBO_TG);
                                        while($combo_tg = mysql_fetch_array($result)){
                                    ?>
                                        <option value="<?php echo $combo_tg["id_tipo"]?>"><?php echo $combo_tg["descripcion"]?></option>
                                    <?php
                                        }
                                    ?>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td>Año</td>
                            <td>
                                <select name="anio">
                                        <option value=""></option>
                                    <?php
                                        $result = mysql_db_query("eltinglao", $SELECT_COMBO_ANIO);
                                        while($combo_anio = mysql_fetch_array($result)){
                                    ?>
                                        <option value="<?php echo $combo_anio["id_anio"]?>"><?php echo $combo_anio["anio"]?></option>
                                    <?php
                                        }
                                    ?>
                                </select>

                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td><input type="submit" value="Guardar"/></td>
                        </tr>

                    </table>
                </form>

            </div><!-- main -->

            <div id="footer">El Tinglao.net</div><!-- footer -->


        </div>
    </body>
</html>


