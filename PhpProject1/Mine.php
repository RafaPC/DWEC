/* 
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ejercicios PHP</title>
        <meta name="author" content="Rafael Prieto Ciprián">
    </head>
    <body>
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
		$tipo = $_POST['tipo'];
		print "$tipo";
		}else{
		
		$err = false;
        $errNombre = $errEdad = $errPwd = "";
        if (empty($_POST['nombre'])) {
            $err = true;
            $errNombre = 'Se requiere el nombre';
        }
        if (empty($_POST['edad'])) {
            $err = true;
            $errEdad = 'Se requiere la edad';
        }
        if (empty($_POST['password'])) {
            $err = true;
            $errPwd = 'Se requiere la contraseña';
        }
        if (!isset($_POST['edad'])) {
            $err = true;
            $errEdad = "La edad es requerida";
        }


        if (!isset($_POST['enviar'])) {
            //NO ENVIADO
            ?>

                <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!--form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars("form2.php"); ?>"-->

                <div>
                    <h1>Fichero</h1>
                    <input type="file" name="fichero" id="fichero">
                </div>

                <h1>Text</h1>
                <label>Nombre:</label>
                <input type="text" name="nombre" value="nombre">

                <div>
                    <h1>Number</h1>
                    <label>Edad:</label>
                    <input type="number_format" name="edad" value="edad">
                </div>


                <div>
                    <h1>Radio</h1>
                    <label>Sexo</label>
                    <input type="radio" name="sexo" value="m" checked>Mujer
                    <input type="radio" name="sexo" value="h">Hombre
                </div>
                <div>
                    <h1>Checkbox</h1><br>
                    <input type="checkbox" name="extras[]" value="garaje" checked>Garaje
                    <input type="checkbox" name="extras[]" value="piscina" checked>Piscina
                    <input type="checkbox" name="extras[]" value="jardin" checked>Jardin
                </div>

                <br>
                <!--label>País</label>
                                <select>
                                        <option value="none"></option>
                                        <option value="chiquitistan">Chiquitistán</option>
                                        <option value="andorra">Andorra</option>
                                        <option value="tabarnia">Tabarnia</option>
                                </select--> 


                <div><h1>Password</h1>
                    <label>Contraseña:</label>
                    <input type="password" name="password" value="password">
                </div>
                <textarea cols="30" rows="4" name="textcoment" value="textcoment">Aquí se escriben cosas </textarea>

                <br>
                <input type="submit" name="enviar" value="procesar">

                <div>
                    <input type="submit" name="tipo" value="acceder">Acceder</input>
                    <input type="submit" name="tipo" value="cambio">Cambio de contraseña</input>
                    <input type="submit" name="tipo" value="nuevo">Registro del usuario</input>
                </div>

            </form>
            <?php
        } else {

            $err = false;
            $errNombre = $errEdad = $errPwd = "";
            if (empty($_POST['nombre'])) {
                $err = true;
                $errNombre = 'Se requiere el nombre';
            }
            if (empty($_POST['edad'])) {
                $err = true;
                $errEdad = 'Se requiere la edad';
            }
            if (empty($_POST['password'])) {
                $err = true;
                $errPwd = 'Se requiere la contraseña';
            }


            if ($err == false) {
                $nombre = $_REQUEST['nombre'];
                print ("El nombre es: $nombre");

                $edad = $_REQUEST['edad'];
                print ("La edad es: $edad");

                print('<br>');
                $sexo = $_REQUEST['sexo'];
                print("El sexo es: $sexo");


                print('<br>');
                $extras = $_REQUEST['extras'];
                print('Los extras son {<br>');
                foreach ($extras as $extra)
                    print ("$extra<br>");
                print('}');

                print('<br>');
                $texto = $_REQUEST['textcoment'];
                print("El mensaje es este: <br> $texto");

                print('<br>');
                $contra = $_REQUEST['password'];
                print("La contra es $contra");
            }

            print('<br>');
            $file[] = $_FILES['file'];
            print_r($file);
        }
        }
		?>
    </body>
</html>