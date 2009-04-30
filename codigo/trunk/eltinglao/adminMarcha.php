<?php

    $BBDD = "eltinglao";    

    include 'connection.php';

    $idAlbum = $_REQUEST['idalbum'];
    $metodo = $_POST['metodo'];
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $fichero = $_POST['fichero'];


    $SELECT = "SELECT * FROM marcha WHERE id_album= " . $idAlbum;

    //NUEVO
    if($metodo == 'nuevo' && $nombre != '' && $fichero != '' && $idAlbum != ''){
        $INSERT = "INSERT INTO marcha (nombre, fichero, id_album) " .
            "VALUES('$nombre', '$fichero', $idAlbum)";
        $result = mysql_db_query("eltinglao", $INSERT);
    }
    
    //MODIFICAR
    if($metodo == 'modificar' && $nombre != '' && $fichero != '' && $id != ''){

        $UPDATE = "UPDATE marcha SET nombre = '$nombre'"
                . ", fichero = '$fichero' WHERE id_marcha = $id";
        
        $result = mysql_db_query("eltinglao", $UPDATE);

    }

    //ELIMINAR
    if($metodo == 'delete' && $id != ''){

        $DELETE = "DELETE FROM marcha WHERE id_marcha = $id";

        $result = mysql_db_query("eltinglao", $DELETE);

    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="es_ES" xml:lang="es_ES">

    <head>
        <title>Gestor de Contenidos - El Tinglao.net</title>
        <link href="./css/estilo_admin.css" rel="stylesheet" type="text/css" />
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">

        <script>
            function editar(id, nombre, fichero){
                document.formulario.metodo.value = 'modificar';
                document.formulario.id.value = id;
                document.formulario.nombre.value = nombre;
                document.formulario.fichero.value = fichero;

            }

            function eliminar(id){
                document.formulario.metodo.value = 'delete';
                document.formulario.id.value = id;
                document.formulario.submit();
            }

            function validar(){
                if(document.formulario.descripcion.value == ''){
                    alert("Debe indicar una descripcion");
                    return false;

                }
                if(document.formulario.carpeta.value == ''){
                    alert("Debe indicar una carpeta");
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
                <h4>Marchas</h4>
                <table border="0">
                    <tr>
                        <td><b>C&oacute;digo</b></td>
                        <td>&nbsp;</td>
                        <td><b>Nombre marcha</b></td>
                        <td>&nbsp;&nbsp;</td>
                        <td><b>Fichero</b></td>
                    </tr>
                    <?php
                        $result = mysql_db_query("eltinglao", $SELECT);
                        while($row = mysql_fetch_array($result)){
                    ?>
                        <tr>
                            <td>
                                <a href="#" onclick="javascript:editar(<?php echo $row["id_marcha"]?>, '<?php echo $row["nombre"]?>', '<?php echo $row["fichero"]?>')"><?php echo $row["id_marcha"]?></a>
                            </td>
                            <td></td>
                            <td>
                                <?php echo $row["nombre"]?>
                            </td>
                            <td></td>
                            <td>
                                <?php echo $row["fichero"]?>
                            </td>
                            <td>
                                <a href="#" onclick="javascript:eliminar(<?php echo $row["id_marcha"]?> )"><img src="./imagenes/btn_eliminar.JPG" alt="Eliminar" border="0"/></a>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                </table>
                <h4>Detalle</h4>
                <form name="formulario" method="post" action="adminMarcha.php"  onSubmit="return validar()">
                    <input type="hidden" name="metodo" value="nuevo"/>
                    <input type="hidden" name="id" />
                    <input type="hidden" name="idalbum" value="<?php echo $idAlbum ?>"/>
                    <table>                        
                        <tr>
                            <td>Descripción</td>
                            <td><input type="text" name="nombre"/></td>
                        </tr>
                        <tr>
                            <td>Carpeta</td>
                            <td><input type="text" name="fichero"/></td>
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


