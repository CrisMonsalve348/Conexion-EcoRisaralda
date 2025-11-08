<div>
<head>
    <title>roles</title>
</head>
    <header class="header">
        <!-- div que contiene el logo de la empresa con hipervinculo a la pagina principal-->
        <div id="logotipo">
            <!-- imagen de logo -->
            <a href="Pagina_Inicio.html"><img src="img/Pagina_inicio/nature-svgrepo-com.svg" alt="Logo empresa" id="logo"></a>
            
            <!-- div de texto de logo -->
            <div>
                <a class="header-brand" href="Pagina_Inicio.html"><h3>Conexion</h3><h5>EcoRisaralda</h5></a>
            </div>
            
        </div>
        <!-- parte derecha del encabezado -->
        <div id="parte_derecha">
            <!-- barra de busqueda -->     
            <div id="buscador">
                <img src="./img/roles/search-svgrepo-com.svg" alt="Buscar" id="buscar">
                <p>Buscar</p>
            </div>       
            <!-- botones de inicio de sesion -->
            <button id="cuenta"><a href="inicio_sesion.html">¿Ya tienes una cuenta?</a></button>
            
            
            <!-- dropdown -->
            <img src="./img/roles/menu-alt-2-svgrepo-com.png" alt="Menu Desplegable" id="dropdown">
        </div>
        
    </header>
    <main>
        
        <div class="conteinerimg">
            <a href="{{route('operario')}}">
                <img src="./img/roles/apreton-de-manos.png" alt="Operador" class="rolimg">
                <h1>Operario</h1>
                <p class="descripcion">Este usuario se caracteriza por colaborar con las empresas para subur inormación de los sitios, reucerde que necesita un identificador tributario para poder registrarse con este rol</p>
            </a>
        </div>
        <div id="separador"></div>
        <div class="conteinerimg">
            <a href="{{route('turista')}}">
                <img src="./img/roles/caminante.png" alt="Turista" class="rolimg">
                
                <h1>Turista</h1>
                <p class="descripcion">El usuario estandar de Conexión EcoRisaralda, podrás tener acceso a elegir tus preferencias y se te recomendarán los sitios de tu gusto, guardar tus sitios favoritos, tener acceso a nuestro chatbot y dejar tus reseñas</p>
            </a>
        </div>
    </main>
</div>
    
    