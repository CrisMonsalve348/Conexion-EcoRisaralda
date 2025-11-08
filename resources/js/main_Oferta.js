// se le agrega a la pagina un evento cuando se hace scroll
window.onscroll = function() {
    // se toma el valor del elemento boton Arriba para trabajar con el
    const btn = document.getElementById("botonArriba");
    // condicional que valida su aparicion y desaparicion en la pagina
    // el boton se activa cuando se a escroleado como minimo 100px
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
      btn.style.display = "block";
    } else {
      btn.style.display = "none";
    }
  };
  
  // Volver arriba al hacer clic
  document.getElementById("botonArriba").addEventListener("click", function() {
    window.scrollTo({
      top: 0,
      // scroll suave
      behavior: "smooth"
    });
  });
  
  // fin flecha de regreso