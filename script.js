let registro = document.querySelector("#registro");

let login = document.querySelector("#login");

registro.style.display = 'none';

let registrarse = document.querySelector("#registrate");

registrarse.addEventListener("click",function () {
    registro.style.display = 'flex';
    login.style.display = 'none';
})

const botonRegistro = document.querySelector("#btnRegistro");

botonRegistro.addEventListener("click",function () {
    registro.style.display = 'flex';
    login.style.display = 'none';
})