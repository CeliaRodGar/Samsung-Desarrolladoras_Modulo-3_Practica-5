<?php
  function validacionNombre($nombre) {
      $pattern = '/^[A-Za-záéíóúñÁÉÍÓÚ\s]+$/u';
      return preg_match($pattern, $nombre);
  }
  
  function validacionApellido($apellido) {
      $pattern = '/^[A-Za-záéíóúñÁÉÍÓÚ\s]+$/u';
      return preg_match($pattern, $apellido);
  }
  function validacionEmail($email) {
    $pattern = '/^[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/';
    return preg_match($pattern, $email);
  }

if($_POST){
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];

//Validación campos vacíos 
if (empty($nombre) || empty($apellido) || empty($email)) {
  echo "<br>Es necesario rellenar todos los campos.";
  echo '<p><a href="formulario.html">Haga click aquí para volver al formulario</a></p>';
  return;
}

//Validación de que los campos nombre y apellido sólo contengan letras
if (!validacionNombre($nombre)) {
  echo "<br>El nombre solo puede contener letras.";
  echo '<p><a href="formulario.html">Haga click aquí para volver al formulario</a></p>';
  return;
}

if (!validacionApellido($apellido)) {
  echo "<br>El apellido solo puede contener letras.";
  echo '<p><a href="formulario.html">Haga click aquí para volver al formulario</a></p>';
  return;
}

//Validación correo electrónico
if (!filter_var ($email, FILTER_VALIDATE_EMAIL)){
  echo "<br>Por favor, introduzca una dirección de correo electrónico válida.";
  echo '<p><a href="formulario.html">Haga click aquí para volver al formulario</a></p>';
  return;
}

//Conexión con PDO

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "practica4";

//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Comprobar que el correo electrónico ya se encuentra en la base de datos.
$sql = "SELECT * FROM usuario WHERE email = '$email'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<br>Esta dirección de correo electrónico ya se encuentra registrada.";
    $conn->close();
    echo '<p><a href="formulario.html">Haga click aquí para volver al formulario</a></p>';
    return;
}

$sql = "INSERT INTO usuario (nombre, apellido, email)
VALUES ('$nombre', '$apellido', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "El usuario se ha registrado correctamente.";
    echo "<p>Datos del usuario registrado:</p>";
        echo "<p>Nombre: $nombre</p>";
        echo "<p>Apellido: $apellido</p>";
        echo "<p>Email: $email</p>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

}


?>