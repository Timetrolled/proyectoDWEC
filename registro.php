<?php 
include("./config.php");
include("./validaciones.php");
$errorLogin = "";
if (isset($_GET["errorLogin"])) {
  $errorLogin = $_GET["errorLogin"];
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registro</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />

  </head>
  <body>
    
    <main>
      <aside>
        <div id="imagen">
        <img src="./assets/images/ayudar.png" alt="" />
        </div>
        <p>
          ¿En qué puedo <br />
          ayudarte?
        </p>
      </aside>

      <section>
        <div id="login">
          <div id="acceder"><p>Accede a tu cuenta</p></div>

          <form action="login.php" method="POST">
            <span class="errorMessage"><?php echo $errorLogin ?></span>
            <input type="text" placeholder="Username" name="loginUser"/>
            <span class="errorMessage"></span>
            <input type="password" placeholder="Password" name="loginPassword"/>

            <p id="registrate">
              ¿Aún no tienes cuenta? <span>Registrate aquí</span>
            </p>

            <button type="submit">Acceder</button>
          </form>
        </div>

        <div id="registro">
          <div id="parrafoRegistro"><p>Registrarse</p></div>
          <form action="registro.php" method="POST">
          <span class="errorMessage"><?php 
              if (in_array("USUARIO EXISTENTE",$errores)) {
                echo "Este usuario ya está en uso";
              } 
            ?></span>

            <input type="text" name="nick" placeholder="Usuario" required value='<?php if (isset($_POST['nick'])) {
              echo $_POST['nick'];
            }?>'/>

            <span class="errorMessage"><?php 
              if (in_array("EMAIL NO VALIDO",$errores)) {
                echo "Este email no es válido";
              } 
            ?></span>

              <span class="errorMessage"><?php 
              if (in_array("EMAIL EXISTENTE",$errores)) {
                echo "Este email ya está en uso";
              } 
            ?></span>
            <input type="email" name="email" placeholder="Email" required value='<?php if (isset($_POST['email'])) {
              echo $_POST['email'];
            }?>'/>

            <span class="errorMessage"><?php 
              if (in_array("EMAIL",$errores)) {
                echo "Los emails no coinciden";
              } 
            ?>
            </span>

            <input
              type="email"
              name="emailConfirm"
              placeholder="Confirma email"
              value='<?php if (isset($_POST['emailConfirm'])) {
              echo $_POST['emailConfirm'];
            }?>'
            />


            <span class="errorMessage">
            <?php 
              if (in_array("PASSWORD INSEGURA",$errores)) {
                echo "La contraseña debe contener al menos 8 caracteres y debe incluir al menos una mayuscula,un numero y un caracter especial.";
              } 
            ?>
            </span>

            <input type="password" name="password" placeholder="Password" required/>

            <span class="errorMessage">
            <?php 
              if (in_array("PASSWORD",$errores)) {
                echo "La contraseña no coincide";
              } 
            ?>
            </span>

            <input
              type="password"
              name="passwordConfirm"
              id=""
              placeholder="Confirma password" required
            />

            <button type="submit"  id="btnRegistro">Registrarse</button>

            <!-- borrar He hecho un cambio en el script de 
            abajo, en vez de esperar al input este que he borrado
            espera a el campo "email", que tiene que ser obligatorio,
            asi evito que haya que tener un input dentro de un botón
            y haya "fallos" de css<input type="submit" name="btnRegistro" value="Registrarse"> -->
          </form>
        </div>
      </section>
    </main>
    <script src="./script.js"></script>
    <?php 
      if (isset($_POST['email'])) {
          echo '<script type="text/javascript">registro.style.display = "flex";
          login.style.display = "none";
          
          </script>';
      }else{
        echo '<script type="text/javascript">registro.style.display = "none";
          login.style.display = "flex";
          
          </script>';
      }

      
      

?>
  </body>
  
</html>
