<?php
include 'includes/conecta.php';
error_reporting(0);
if (isset($_POST['guardar'])) {
    if (isset($_FILES['foto']['name'])) {
        $numero = 0;
        $nombreEstablecimiento = $conecta -> real_escape_string($_POST['NombreEstablecimiento']);
        $direccionEstablecimiento = $conecta -> real_escape_string($_POST['DireccionEstablecimiento']);
        $nombreEncargado = $conecta -> real_escape_string($_POST['NombreEncargado']);
        $apellidosEncargado = $conecta -> real_escape_string($_POST['ApellidosEncargado']);
        $numeroCelular = $conecta -> real_escape_string($_POST['NumeroCelular']);
        $emailEncargado = $conecta -> real_escape_string($_POST['EmailEncargado']);
        $passwordEncargado = $conecta -> real_escape_string(md5($_POST['PasswordEncargado']));
        $permiso = 0;
        $calificacion = 0;
        $tamanoArchivo = $_FILES['foto']['size'];
        $imagenSubida = fopen($_FILES['foto']['tmp_name'], 'r');
        $binariosImagen = fread($imagenSubida, $tamanoArchivo);
        $binariosImagen = mysqli_escape_string($conecta, $binariosImagen);
        $query = "INSERT INTO establecimiento (Nombres_Establecimiento, Direccion_Establecimiento, Nombre_Encargado, 
        Apellidos_Encargado, NumeroCelular_Encargado,Email_Encargado, Password_Encargado, Permiso, Calificacion, Logo) 
        values ('$nombreEstablecimiento','$direccionEstablecimiento', '$nombreEncargado', '$apellidosEncargado', 
        '$numeroCelular','$emailEncargado','$passwordEncargado','$permiso','$calificacion','$binariosImagen')";
        $verificar_correoCliente = mysqli_query($conecta, "SELECT * FROM clientes WHERE Email_Cliente='$emailEncargado' ");
        $verificar_correoEstablecimiento = mysqli_query($conecta, "SELECT * FROM establecimiento WHERE Email_Encargado='$emailEncargado' ");
        if(mysqli_num_rows($verificar_correoCliente) > 0 || mysqli_num_rows($verificar_correoEstablecimiento) > 0){
          echo '
           <script>
           alert("Este correo ya esta registrado, intenta con otro diferente");
           </script>
             ';
               exit();
         }
        $res = $conecta->query($query);
        if ($res > 0) {
            $numero = 1;
        } else {
            $numero = 0;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href='https://fonts.googleapis.com/css?family=Bungee' rel='stylesheet'>
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Merienda+One" />
  <link rel="stylesheet" href="css/style-registroEstablecimiento.css">
  <title>Registro de establecimiento</title>
</head>
<body>
  <section class="form-register">
    
    <div>
      

        <form method="post" enctype="multipart/form-data">
          <div class="form-group">
              <center><h4>REGISTRO DE ESTABLECIMIENTO</h4></center>
              <h5>Nombre del establecimiento:</h5>
              <input type="text" minlength ="3" maxlength="40" name="NombreEstablecimiento" placeholder="Ingrese el Nombre" 
              class="form-control controls" required pattern ="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ]{1,100}[ ]{0,10}[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+">
              <h5>Direccion:</h5>    
              <input type="text" minlength ="3" maxlength="40" name="DireccionEstablecimiento" placeholder="Ingrese la direccion" 
              class="form-control controls" required pattern ="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ]{1,100}[ ]{0,10}[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+">
              <h5>Nombre del encargado:</h5>
              <input type="text" minlength ="3" maxlength="40" name="NombreEncargado" placeholder="Ingrese el nombre del encargado" 
              class="form-control controls" required pattern ="[a-zA-ZñÑáéíóúÁÉÍÓÚ]{1,100}[ ]{0,10}[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+">
              <h5>Apellidos del encargado:</h5>
              <input type="text" minlength ="3" maxlength="40" name="ApellidosEncargado" placeholder="Ingrese los apellidos del encargado" 
              class="form-control controls" required pattern ="[a-zA-ZñÑáéíóúÁÉÍÓÚ]{1,100}[ ]{0,10}[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+">
              <h5>Telefono:</h5>
              <input type="number" min="60000000"  max="79999999" name="NumeroCelular" placeholder="Ingrese el numero de telefono" 
              class="form-control controls" required >
              <h5>Correo electronico:</h5>
              <input type="text" name="EmailEncargado" placeholder="Ingrese el correo electronico" 
              class="form-control controls" required pattern =".+@(gmail|hotmail|outlook).(com|es)">
              <h5>Contraseña:</h5>
              <input type="password" minlength ="8" maxlength="40" name="PasswordEncargado" 
              placeholder="Ingrese una contraseña" class="form-control controls" required pattern = "(?=.*[a-zñÑ0-9])(?=.*[A-Z])(?=.*[!@#$&]).{8,40}" title = "Ingrese una contraseña válida: Min 8 caracteres, max 40. Al menos una letra mayúsucula y un carácter especial(!@#$&)">
              <h5>Confirmar Contraseña:</h5>
              <input type="password" minlength ="8" maxlength="40" name="PasswordEncargado" 
              placeholder="Ingrese una contraseña" class="form-control controls" required pattern = "(?=.*[a-zñÑ0-9])(?=.*[A-Z])(?=.*[!@#$&]).{8,40}" title = "Ingrese una contraseña válida: Min 8 caracteres, max 40. Al menos una letra mayúsucula y un carácter especial(!@#$&)">
              <h5>Logo:</h5>
              <input accept = "image/png, image/jpeg" type="file" class="form-control-file" name="foto" required>
              <h5>Documento solicitud:</h5>
              <input accept = "application/pdf" type="file" class="form-control-file" name="documento" required>
          </div>
          <div class="form-group">
              <button><input class="botons" type="submit" value="Registrar" name="guardar"></button>
              <a class="botons" href="logout.php">Atras</a>
          </div>
      </form>
      <div id="imagenes">
      <img src="images/reloj.png" id="reloj" >
      <img src="images/lechuga.png" id="lechuga" >
      <img src="images/zanahoria.png" id="zanahoria" >
      <img src="images/hamburguesa.png" id="hamburguesa">
      </div>
    </div>
    
  </section>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    var x = <?php echo $numero;?>;
  </script>
  <script src="js/sweetAlert.js"></script>
</body>
</html>
