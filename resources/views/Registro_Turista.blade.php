
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Turista</title>
    @vite(['resources/css/style_Registro_Turista.css', 'resources/js/Registro_Turista.js'])
</head>
<body>
    


<body>
    <header class="header">
        <!-- div que contiene el logo de la empresa con hipervinculo a la pagina principal-->
        <div id="logotipo">
            <!-- imagen de logo -->
             <a href="Pagina_Inicio.html"><img src="img/Pagina_inicio/nature-svgrepo-com.svg" alt="Logo empresa" id="logo"></a>

            <!-- div de texto de logo -->
            <div>
                <a class="header-brand" href="Pagina_Inicio.html"><h3>Conexion</h3><h5>EcoRisaralda</h5></a>
                <p id="turista">Turista</p>
            </div>
            
        </div>
        <!-- parte derecha del encabezado -->
         <div id="parte_derecha">
   
               <button id="cuenta"><a href="#">¿Ya tienes una cuenta?</a></button>
               
                
               <!-- dropdown -->
                <img src="./img/roles/menu-alt-2-svgrepo-com.png" alt="Menu Desplegable" id="dropdown">
         </div>

      </header>

      <main id="principal">
 <div id="titulo">
    <p id="indicador">Paso 1 de 2</p>
    <h1>Crea tu cuenta</h1>
 </div>
 <div class="input_align">
    <label for="email"  class="textosuperior" >Correo Eletrónico</label>
    <input type="email" placeholder="Ingrese su correo" class="inputs">
 </div>
 <div class="input_align">
    <div id="ojoycont1"> 
        <label  for="password" class="textosuperior" >Contraseña</label>
        <img class="ojo" src="./img/register_turista/view-svgrepo-com.png" alt="Ojo de demostramiento">
    </div>
    <input id="contraseña" type="password" placeholder="Ingrese su contraseña" class="inputs">
 </div>
 <div class="input_align">
    <div id="ojoycont2"> 
        <label  for="password" class="textosuperior">Confirme su contraseña</label>
        <img class="ojo" src="./img/register_turista/view-svgrepo-com.png" alt="Ojo de demostramiento">
    </div>
    <input id="contraseña" type="password" placeholder="Vuelva a ingresar su contraseña" class="inputs">
 </div>
 <div id="align_indicaciones">
    <p>Tu contraseña debe incluir</p>
    <ul>
        <li>Entre 8 y 15 caracteres</li>
        <li>Al menos una letra mayúscula</li>
        <li>Al menos un digito</li>
        <li>Opcional: Caracteres especiales como  @ ? # $ % ( ) _ = * \ : ; ' . / + < > & ¿ ,[</li>
    </ul>
 </div>
 <a href="Registro2_Turista.html"> <button id="Siguiene"> Siguiente  </button></a>
 

      </main>
</body>
</html>