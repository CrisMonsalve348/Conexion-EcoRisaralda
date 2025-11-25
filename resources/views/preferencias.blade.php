<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="img/svg" href="./img/inicio_sesion/nature-svgrepo-com.svg">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Conexión EcoRisaralda</title>
    @vite('resources/css/style_Preferencias.css')
    
</head>
<body>
    <header>
        <h1>Tú decides el camino, elige una opción</h1>
    </header>
    <main id="main_container">
     <form action="/guardar-preferencias" method="POST">
         @csrf 
         <div class="preferences-grid"> @foreach ($preferences as $preference) 
        <label class="preference-card"> 
        <input type="checkbox" name="preferences[]" value="{{ $preference->id }}"> <div class="card-content"> 
        <img src="#" alt=""> 
        <p>{{ $preference->name }}</p> 
    </div> 
</label>
 @endforeach 
</div> 
  <input type="submit" value="Enviar" name="enviar">
<a href="modulos_loguin/Usuario/pagina_inicio_loguin.html"><button id="omitir">Omitir ></button></a>
</form>
    </main>
    <div id="botones">
      
    </div>

</body>
</html>