<!DOCTYPE html>
<?php 


include("./config.php");
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    
    $cookie_usuario= "cookieUsuario";
    $cookie_value = $usuario;
    setcookie($cookie_usuario, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
}else{
    header("Location: ./registro.php");
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap" type="text/javascript"></script> -->

    
    <style>

body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    #map{
        height: 300px;
        width: 300px;
    }
    
    </style>
    </script>
</head>
<body onload="getLocation()">
    <?php
        echo "Bienvenido " . $usuario;

    ?>
    
    <form action="cerrarSesion.php" method="POST">
    <label for="enviar">Cerrar sesión</label>
    <input type="submit" name="enviar">
    </form>

    <!-- IMPORTANTISIMO EL enctype="multipart/form-data" -->
    <form action="modificar.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="image">
    <input type="submit" value="submit" name="submit">
    </form>
    fotito:
    <?php 
    
    // Cogemos la imagen

    $sql = "SELECT usuario_fotografia FROM usuarios where usuario_nick = '$usuario'";

    $resultado = mysqli_query($con,$sql);

    $imagen = $resultado->fetch_assoc();

    $imagen = $imagen["usuario_fotografia"];
    echo '<img src="' . $imagen . '" />';
    
    ?>

<br>

<p id="demo"></p>

<script>
var x = document.getElementById("demo");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.watchPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}
    
let latitud;
    let longitud;
function showPosition(position) {
    latitud = position.coords.latitude;
    longitud = position.coords.longitude;
    x.innerHTML="Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude;
}

let map;

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 36, lng: -4 },
    zoom: 8,
});
}


</script>
<br><br>
<img src="https://maps.googleapis.com/maps/api/staticmap?center=Brooklyn+Bridge,New+York,NY&zoom=13&size=600x300&maptype=roadmap
&markers=color:blue%7Clabel:S%7C40.702147,-74.015794
&key=" alt="">
</body>
<script>
    

</script>
</html>