<?php

    $BBDD = "eltinglao";
    $SELECT = "SELECT id_banda, nombre, b.carpeta, descripcion, b.id_tipo
               FROM banda b
               JOIN tipo_banda tb
               ON b.id_tipo = tb.id_tipo";

    $COMBO_TB = "SELECT * FROM tipo_banda t";

    include 'connection.php';

    $metodo = $_POST['metodo'];
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $carpeta = $_POST['carpeta'];
    $tb = $_POST['tb'];
    

    //NUEVO
    if($metodo == 'nuevo' && $nombre != '' && $carpeta != '' && tb != ''){
        $INSERT = "INSERT INTO banda (nombre, carpeta, id_tipo) " .
            "VALUES('$nombre', '$carpeta', $tb)";
        $result = mysql_db_query("eltinglao", $INSERT);
    }
    
    //MODIFICAR
    if($metodo == 'modificar' && $nombre != '' && $carpeta != '' && tb != ''){
        
        $UPDATE = "UPDATE banda SET nombre = '$nombre'"
                . ", carpeta = '$carpeta', id_tipo=$tb WHERE id_banda = $id";
        
        $result = mysql_db_query("eltinglao", $UPDATE);

    }

    //ELIMINAR
    if($metodo == 'delete' && $id != ''){

        $DELETE = "DELETE FROM banda WHERE id_banda = $id";

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
            function editar(id, nombre, carpeta, tb){
                document.formulario.metodo.value = 'modificar';
                document.formulario.id.value = id;
                document.formulario.nombre.value = nombre;
                document.formulario.carpeta.value = carpeta;
                document.formulario.tb.value = tb;

            }

            function eliminar(id){
                document.formulario.metodo.value = 'delete';
                document.formulario.id.value = id;
                document.formulario.submit();
            }

            function validar(){
                if(document.formulario.nombre.value == ''){
                    alert("Debe indicar un nombre para la banda");
                    return false;

                }
                if(document.formulario.carpeta.value == ''){
                    alert("Debe indicar una carpeta");
                    return false;                    
                }
                if(document.formulario.tb.value == ''){
                    alert("Debe indicar un tipo de banda");
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
                <h4>Banda</h4>                
                <table border="0">
                    <tr>
                        <td style="width:60px"><b>C&oacute;digo</b></td>
                        <td style="width:115px"><b>Nombre</b></td>
                        <td style="width:80px"><b>Carpeta</b></td>
                        <td style="width:120px"><b>Tipo de Banda</b></td>
                    </tr>
                    
                    <?php
                        $result = mysql_db_query("eltinglao", $SELECT);
                        while($row = mysql_fetch_array($result)){
                    ?>
                        <tr>
                            <td>
                                <a href="#" onclick="javascript:editar(<?php echo $row["id_banda"]?>, '<?php echo $row["nombre"]?>', '<?php echo $row["carpeta"]?>', '<?php echo $row["id_tipo"]?>')"><?php echo $row["id_banda"]?></a>
                            </td>
                            <td>
                                <?php echo $row["nombre"]?>
                            </td>
                            <td>
                                <?php echo $row["carpeta"]?>
                            </td>
                            <td>
                                <?php echo $row["descripcion"]?>
                            </td>
                            <td>
                                <a href="#" onclick="javascript:eliminar(<?php echo $row["id_banda"]?> )"><img src="./imagenes/btn_eliminar.JPG" alt="Eliminar" border="0"/></a>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                    
                </table>
                <h4>Detalle</h4>
                <form name="formulario" method="post" action="adminBanda.php"  onSubmit="return validar()">
                    <input type="hidden" name="metodo" value="nuevo" />
                    <input type="hidden" name="id" />
                    <table>                        
                        <tr>
                            <td>Nombre Banda</td>
                            <td><input type="text" name="nombre"/></td>
                        </tr>
                        <tr>
                            <td>Carpeta</td>
                            <td><input type="text" name="carpeta"/></td>
                        </tr>
                        <tr>
                            <td>Tipo de banda</td>
                            <td>
                                <select name="tb">
                                        <option value=""></option>
                                    <?php
                                        $result = mysql_db_query("eltinglao", $COMBO_TB);
                                        while($combo = mysql_fetch_array($result)){
                                    ?>
                                        <option value="<?php echo $combo["id_tipo"]?>"><?php echo $combo["descripcion"]?></option>
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


