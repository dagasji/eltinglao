<?php

    $BBDD = "eltinglao";
    $SELECT = "SELECT * FROM anio";

    include 'connection.php';

    $metodo = $_POST['metodo'];
    $id = $_POST['id'];
    $anio = $_POST['anio'];
    

    //NUEVO
    if($metodo == 'nuevo' && $anio != ''){
        $INSERT = "INSERT INTO anio (anio) VALUES('$anio')";
        $result = mysql_db_query("eltinglao", $INSERT);
    }
    
    //MODIFICAR
    if($metodo == 'modificar' && $anio != ''){
        
        $UPDATE = "UPDATE anio SET anio = '$anio'"
                . " WHERE id_anio = $id";
        
        $result = mysql_db_query("eltinglao", $UPDATE);

    }

    //ELIMINAR
    if($metodo == 'delete' && $id != ''){

        $DELETE = "DELETE FROM anio WHERE id_anio = $id";

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
            function editar(id, anio){
                document.formulario.metodo.value = 'modificar';
                document.formulario.id.value = id;
                document.formulario.anio.value = anio;
                

            }

            function eliminar(id){
                document.formulario.metodo.value = 'delete';
                document.formulario.id.value = id;
                document.formulario.submit();
            }

            function validar(){
                if(document.formulario.anio.value == ''){
                    alert("Debe indicar un Año");
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
                <h4>Años</h4>
                <table border="0">
                    <tr>
                        <td style="width:60px"><b>Código</b></td>
                        <td style="width:60px"><b>Año</b></td>                        
                    </tr>                    
                    <?php
                        $result = mysql_db_query("eltinglao", $SELECT);
                        while($row = mysql_fetch_array($result)){
                    ?>
                        <tr>
                            <td>
                                <a href="#" onclick="javascript:editar(<?php echo $row["id_anio"]?>, '<?php echo $row["anio"]?>')"><?php echo $row["id_anio"]?></a>
                            </td>
                            <td>
                                <?php echo $row["anio"]?>
                            </td>
                            <td>
                                <a href="#" onclick="javascript:eliminar(<?php echo $row["id_anio"]?> )"><img src="./imagenes/btn_eliminar.JPG" alt="Eliminar" border="0"/></a>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                </table>
                <h4>Detalle</h4>
                <form name="formulario" method="post" action="adminAnio.php"  onSubmit="return validar()">
                    <input type="hidden" name="metodo" value="nuevo" />
                    <input type="hidden" name="id" />
                    <table>                        
                        <tr>
                            <td>Año</td>
                            <td><input type="text" name="anio"/></td>
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


