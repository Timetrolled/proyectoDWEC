<?php
include("./config.php");
   
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['loginUser'];
    $password = md5($_POST['loginPassword']);

    $sql = "SELECT * FROM usuarios WHERE usuario_nick = '$usuario' AND usuario_clave = '$password' AND usuario_bloqueado = 0";

    $resultado = mysqli_query($con, $sql);
    $devuelto = mysqli_num_rows($resultado);

    if ($devuelto>0) {
        $_SESSION["usuario"] = $usuario;
        
        $sqlFechaConexion = "UPDATE usuarios set usuario_fecha_ultima_conexion = CURRENT_TIMESTAMP() WHERE usuario_nick = '$usuario'";

        mysqli_query($con,$sqlFechaConexion);

        header("Location:index.php");


    }else{
        // Si no lo encuentra, miramos si al menos existe el usuario para restar número de intentos
        $sql = "SELECT * FROM usuarios WHERE usuario_nick = '$usuario' AND usuario_bloqueado = 0";

        $resultado = mysqli_query($con,$sql);
        $devuelto = mysqli_num_rows($resultado);
        if ($devuelto>0) {
            $fila = $resultado->fetch_assoc();

            $num_intentos = $fila["usuario_numero_intentos"];

            if ($num_intentos > 3) {
                $sql = "UPDATE usuarios SET usuario_bloqueado = 1 WHERE usuario_nick = '$usuario'";
            
                mysqli_query($con,$sql);
                header("Location:registro.php?errorLogin=Cuenta bloqueada por número de intentos<br>Contacte con el administrador");
            }else{
                $num_intentos++;

                $sql = "UPDATE usuarios SET usuario_numero_intentos = $num_intentos WHERE usuario_nick = '$usuario'";
                
                mysqli_query($con,$sql);
    
                header("Location:registro.php?errorLogin=Numero de intentos: $num_intentos");
            }
        }else{
            // Si no hay nada, mandamos error al login por GET
            header("Location:registro.php?errorLogin=Error en el login");
        }
		
	}
}


?>