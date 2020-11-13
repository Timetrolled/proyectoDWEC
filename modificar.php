
<?php 



include("./config.php");


if (isset($_SESSION["usuario"])) {
    if (isset($_POST["submit"])) {
        if(isset($_FILES['image'])){
                $usuario =  $_SESSION["usuario"];
                
                // Array vacio para los errores que pueden ocurrir
                $errors=array();

                //extensiones permitidas
                $allowed_ext= array('jpg','jpeg','png','gif');
                
                
                $file_name =$_FILES['image']['name']; // Nombre del archivo
                $file_ext = explode('.',$file_name); // Extension del archivo
                $file_ext = strtolower(end($file_ext)); // Entension del archivo procesada
                
                $file_size=$_FILES['image']['size']; // Tamaño del archivo
                $file_tmp= $_FILES['image']['tmp_name']; // Archivo temporal

                
                $type = pathinfo($file_tmp, PATHINFO_EXTENSION); // Tipo del archivo 
                $data = file_get_contents( $file_tmp ); // Datos del archivo
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data); // Ponemos el tipo de dato, con su tipo y codificacion
                echo "Base64 is ".$base64;
                
                if(in_array($file_ext,$allowed_ext) === false){
                    $errors[]='Extension not allowed';
                }
                
                if($file_size > 2097152){
                    $errors[]= 'File size must be under 2mb';
                    
                }
                // Si en el array no hay ningun error, actualiza la base de datos
                if(empty($errors)){
                    if(move_uploaded_file($file_tmp, 'images/'.$file_name)){
                        $sql = "UPDATE usuarios SET usuario_fotografia = '$base64' WHERE usuario_nick = '$usuario'";
                        mysqli_query($con,$sql);    
                        header("Location: index.php");
            }
            }else{
                foreach($errors as $error){
                    echo $error , '<br/>'; 
                }
            }

        }
    }
}else{
    header("Location: registro.php");
}

?>
