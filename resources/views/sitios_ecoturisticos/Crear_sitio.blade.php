<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear sitio</title>
</head>
<body>
    
<main>
    <form action="Crear_sitio" method="POST"  enctype="multipart/form-data">
    @csrf
    <div>
        <label for="nombre">Nombre de la empresa</label>
        <input type="text" name="nombre" id='nombre'>
           @error('name')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

        <label for="slogan">Slogan</label>
        <input type="text" name='slogan' id='slogan'>
           @error('slogan')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        <label for="portada">Sube una imagen de portada</label>
        <input type="file" name="portada" id='portada'>
           @error('cover')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
           @enderror

    </div>
    <label for="descripcion">Descripción</label>
    <input type="text" name='descripcion' id='descripcion'>
       @error('description')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror



    <div>
        <label for="localizacion">Localizacion</label>
        <input type="text" name='localizacion' id='localizacion'>
           @error('localization')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror

        <input type="file" name="mapa">
    </div>
    <div>
        <input type="file" name="clima_img">
    <label for="clima">Clima</label>
    <input type="text" name="clima" id="clima">

    </div>
    <div>
        <label for="caracteristicas">Localizacion</label>
        <input type="text" name='caracteristicas' id='caracteristicas'>




        <input type="file" name="caracteristicas_img">
    </div>

    <div>
    <input type="file" name="flora_img">
    <label for="flora">Flora y fauna</label>
    <input type="text" name="flora" id="flora">

    </div>
     <div>
        <label for="infraestructura">infraestructura</label>
        <input type="text" name='infraestructura' id='infraestructura'>




        <input type="file" name="infraestructura_img">
    </div>

    <label for="recomendacion">Recomendaciones</label>
    <input type="text" name='recomendacion' id='recomendacion'>


    <div>
        <input type="checkbox" name="terminos">
        <input type="checkbox" name="pliticas">

    </div>
    <button>Finalizar</button>
 

    </form>


</main>



</body>
</html>