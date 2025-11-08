<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="img/svg" href="./img/datos_operador/nature-svgrepo-com.svg">
    <title>Conexión EcoRisaralda</title>
    <link rel="stylesheet" href="./css/style_Registro2_Operador.css">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <!-- div que contiene el logo de la empresa con hipervinculo a la pagina principal-->
        <div id="logotipo">
            <!-- imagen de logo -->
             <a href="Pagina_Inicio.html"><img src="./img/datos_operador/nature-svgrepo-com.svg" alt="Logo empresa" id="logo"></a>

            <!-- div de texto de logo -->
            <div>
                <a class="header-brand" href="Pagina_Inicio.html"><h3>Conexion</h3><h5>EcoRisaralda</h5></a>
                <p id="Operador">Operador</p>
            </div>
            
        </div>
        <!-- parte derecha del encabezado -->
         <div id="parte_derecha">
   
               <button id="cuenta"><a href="inicio_sesion.html">¿Ya tienes una cuenta?</a></button>
               
                
               <!-- dropdown -->
                <img src="./img/datos_operador/menu-alt-2-svgrepo-com.png" alt="Menu Desplegable" id="dropdown">
         </div>

      </header>

      <main id="principal">
 <div id="titulo">
    <a id="indicador"> < Regresar </a>
    <h1>Cuentanos un poco más sobre tí</h1>
 </div>
 <div class="input_align">
    <label for="Name">Nombre</label>
    <input type="text" placeholder="Ingrese su nombre" class="inputs">
 </div>
 <div class="input_align">
    
        <label for="lastname">Apellido</label>
        
   
    <input id="nombre" type="text" placeholder="Ingrese su apellido" class="inputs">
 </div>
 <div class="input_align">
     
        <label for="pais">País donde reside</label>
        
    
    <select name="country"  id="paises" >
        <option value="Seleccionar">Seleccionar</option>
        <option value="Colombia">Colombia</option>
        <option value="Perú">Perú</option>
    </select>
 </div>
 <div class="input_align">
    <label for="date">Fecha de nacimiento</label>
    <div id="align_date">
        

        <!-- Selector de Mes -->
        <select id="mes" name="mes">
          <option value="">Mes</option>
          <option value="1">Enero</option>
          <option value="2">Febrero</option>
          <option value="3">Marzo</option>
          <option value="4">Abril</option>
          <option value="5">Mayo</option>
          <option value="6">Junio</option>
          <option value="7">Julio</option>
          <option value="8">Agosto</option>
          <option value="9">Septiembre</option>
          <option value="10">Octubre</option>
          <option value="11">Noviembre</option>
          <option value="12">Diciembre</option>
        </select>
        
        <!-- Selector de Día -->
        <select id="dia" name="dia">
          <option value="">Día</option>
          <!-- Días del 1 al 31 -->
          <!-- Puedes generar esto automáticamente con JS si lo prefieres -->
          <!-- Aquí están manualmente -->
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
        </select>
        
        <!-- Selector de Año -->
        <select id="anio" name="anio">
          <option value="">Año</option>
          <!-- Años de 1993 a 2025 -->
          <!-- También puede generarse con JS -->
          <!-- Manualmente aquí -->
          <option value="2025">2025</option>
          <option value="2024">2024</option>
          <option value="2023">2023</option>
          <option value="2022">2022</option>
          <option value="2021">2021</option>
          <option value="2020">2020</option>
          <option value="2019">2019</option>
          <option value="2018">2018</option>
          <option value="2017">2017</option>
          <option value="2016">2016</option>
          <option value="2015">2015</option>
          <option value="2014">2014</option>
          <option value="2013">2013</option>
          <option value="2012">2012</option>
          <option value="2011">2011</option>
          <option value="2010">2010</option>
          <option value="2009">2009</option>
          <option value="2008">2008</option>
          <option value="2007">2007</option>
          <option value="2006">2006</option>
          <option value="2005">2005</option>
          <option value="2004">2004</option>
          <option value="2003">2003</option>
          <option value="2002">2002</option>
          <option value="2001">2001</option>
          <option value="2000">2000</option>
          <option value="1999">1999</option>
          <option value="1998">1998</option>
          <option value="1997">1997</option>
          <option value="1996">1996</option>
          <option value="1995">1995</option>
          <option value="1994">1994</option>
          <option value="1993">1993</option>
        </select>
        
    </div>

 </div>
 <div class="input_align">
    <label for="NT">NT(Número de identificación tributaria)</label>
    <input type="number" placeholder="Ingrese el numero de identificación tributaria" class="inputs">
 </div>
 <div id="align_terminos">
 <div class="terminos_container" >
 <input type="checkbox" id="caja">
 <p class="terminos">He leido y acepto los 
    <a href="#">Terminos y condiciones</a>
    de Conexión EcoRisaralda</p>
 </div>
 <div class="terminos_container" >
    <input type="checkbox" id="caja">
    <p class="terminos">He leido y aceptado la 
       <a href="#">política de privacidad</a>
       de Conexión EcoRisaralda</p>
    </div>
    </div>
    <a href="./preferencias.html"><button id="Siguiente" >Finalizar</button></a>
 

      </main>
</body>
</html>
