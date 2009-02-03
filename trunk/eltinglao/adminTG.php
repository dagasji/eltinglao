<?php

    $BBDD = "eltinglao";
    $SELECT = "SELECT * FROM tipo_grabacion";

    include 'connection.php';

    $metodo = $_POST['metodo'];
    $id = $_POST['id'];
    $descripcion = $_POST['descripcion'];
    $carpeta = $_POST['carpeta'];

    //NUEVO
    if($metodo == 'nuevo' && $descripcion != '' && $carpeta != ''){        
        $INSERT = "INSERT INTO tipo_grabacion (descripcion, carpeta) " .
            "VALUES('$descripcion', '$carpeta')";
        $result = mysql_db_query("eltinglao", $INSERT);
    }
    
    //MODIFICAR
    if($metodo == 'modificar' && $descripcion != '' && $carpeta != ''){
        
        $UPDATE = "UPDATE tipo_grabacion SET descripcion = '$descripcion'"
                . ", carpeta = '$carpeta' WHERE id_tipo = $id";
        
        $result = mysql_db_query("eltinglao", $UPDATE);

    }

    //ELIMINAR
    if($metodo == 'delete' && $id != ''){

        $DELETE = "DELETE FROM tipo_grabacion WHERE id_tipo = $id";

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
            function editar(id, descripcion, carpeta){
                document.formulario.metodo.value = 'modificar';
                document.formulario.id.value = id;
                document.formulario.descripcion.value = descripcion;
                document.formulario.carpeta.value = carpeta;

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
                <h4>Tipos de Grabaci&oacute;n</h4>
                <table border="0">
                    <tr>
                        <td style="width:80px"><b>Código</b></td>
                        <td style="width:150px"><b>Descripción</b></td>
                        <td style="width:100px"><b>Carpeta</b></td>
                    </tr>
                    <?php
                        $result = mysql_db_query("eltinglao", $SELECT);
                        while($row = mysql_fetch_array($result)){
                    ?>
                        <tr>
                            <td>
                                <a href="#" onclick="javascript:editar(<?php echo $row["id_tipo"]?>, '<?php echo $row["descripcion"]?>', '<?php echo $row["carpeta"]?>')"><?php echo $row["id_tipo"]?></a>
                            </td>
                            <td>
                                <?php echo $row["descripcion"]?>
                            </td>
                            <td>
                                <?php echo $row["carpeta"]?>
                            </td>
                            <td>
                                <a href="#" onclick="javascript:eliminar(<?php echo $row["id_tipo"]?> )"><img src="./imagenes/btn_eliminar.JPG" alt="Eliminar" border="0"/></a>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                </table>
                <h4>Detalle</h4>
                <form name="formulario" method="post" action="adminTG.php"  onSubmit="return validar()">
                    <input type="hidden" name="metodo" value="nuevo" />
                    <input type="hidden" name="id" />
                    <table>                        
                        <tr>
                            <td>Descripción</td>
                            <td><input type="text" name="descripcion"/></td>
                        </tr>
                        <tr>
                            <td>Carpeta</td>
                            <td><input type="text" name="carpeta"/></td>
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


