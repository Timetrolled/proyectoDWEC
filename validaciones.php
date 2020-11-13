<?php 
 
$usuario_nombre = "";
$usuario_apellido1 = "";
$usuario_apellido2 = "";
$usuario_nick = "";
$usuario_clave = "";
$usuario_fecha_alta = date('Y-m-d h:i:s',time());
$usuario_email = "";
$usuario_bloqueado = 1;
$usuario_numero_intentos = 0;




$ok = true;
$errores = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    


    if ($_POST['nick']) {
        $usuario_nick = $_POST['nick'];
    }

    $sql2 = "SELECT usuario_nick FROM usuarios where usuario_nick = '$usuario_nick'";
    $resultadoQuery = $con->query($sql2);
    $total = mysqli_num_rows($resultadoQuery);

    if ($total != 0) {
        array_push($errores,"USUARIO EXISTENTE");
        $ok = false;
    }

    $usuario_nick = desinfectar($usuario_nick);

  

    if ($_POST['email']) {
        $usuario_email = $_POST['email'];
    }

    if ($_POST['emailConfirm']) {
        $confirmaEmail = $_POST['emailConfirm'];
    }

    $sql2 = "SELECT usuario_email FROM usuarios where usuario_email = '$usuario_email'";
    $resultadoQuery = $con->query($sql2);
    $total = mysqli_num_rows($resultadoQuery);

    if ($total != 0) {
        array_push($errores,"EMAIL EXISTENTE");
        $ok = false;
    }

    if ($_POST['password']) {
        $usuario_clave = $_POST['password'];
    }

    if ($_POST['passwordConfirm']) {
        $usuario_clave_confirmar = $_POST['passwordConfirm'];
    }

    if ($usuario_email != $confirmaEmail) {
        array_push($errores,"EMAIL");
        $ok = false;
    }


    $uppercase = preg_match('@[A-Z]@', $usuario_clave);
    $lowercase = preg_match('@[a-z]@', $usuario_clave);
    $number    = preg_match('@[0-9]@', $usuario_clave);
    $specialChars = preg_match('@[^\w]@', $usuario_clave);

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($usuario_clave) < 8) {
        $ok = false;
        array_push($errores,"PASSWORD INSEGURA");
    }


    if ($usuario_clave != $usuario_clave_confirmar ) {
        array_push($errores,"PASSWORD");
        $ok = false;
    }else{
        $password = md5($usuario_clave);
    }



    if ($ok == true) {

        $usuario_token_aleatorio = md5($usuario_nick . $password);

        $sql = "INSERT INTO usuarios (usuario_nombre,usuario_apellido1,usuario_apellido2,usuario_nick,usuario_clave,usuario_fecha_alta,usuario_email,usuario_bloqueado,usuario_numero_intentos,usuario_token_aleatorio)
    
        VALUES ('$usuario_nombre','$usuario_apellido1','$usuario_apellido2','$usuario_nick', '$password', '$usuario_fecha_alta','$usuario_email','$usuario_bloqueado','$usuario_numero_intentos','$usuario_token_aleatorio')";
            if (mysqli_query($con, $sql)) {
                
  
                //----> MAIL

                $to      = $usuario_email; // Email que va a recibir el mensaje.
                $subject = 'Verificación | Registro'; //Concepto 
                $mensaje =  '
  
                Gracias por registrarte!
                Su cuenta ha sido creada, puede iniciar sesión con las siguientes credenciales después de haber activado su cuenta presionando la URL a continuación.
                 
                ------------------------
                Username: ' . $usuario_nick . '
                Password: ' . $password . '
                ------------------------
                 
                Haga click en este enlace para activar su cuenta:
                http://daniel.hermanosramos.net/helpdesk/verificacion.php?usuario_email=' . $usuario_email . '&usuario_token_aleatorio=' . $usuario_token_aleatorio . '';
                // Mensaje con enlace. 
                // $mensaje = 'http://daniel.hermanosramos.net/helpdesk/verificacion.php?usuario_email=' . $usuario_email . '&usuario_token_aleatorio=' . $usuario_token_aleatorio;
                $headers = 'From:soporte@hermanosramos.net' . "\r\n";
                mail($to, $subject, $mensaje , $headers); // Mandar el email

            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }
    }


}
function desinfectar($user){
    $user = strip_tags($user);
    $user = str_replace(" ","",$user);
    return $user;
}




?>