<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/js/Modulos/Operador/js/marcador.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
  integrity="sha256-sA+4d3f08sYQK4Gg6k1Xy2b2uZ6w5M7H0G2P0L1Yk0g=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
  integrity="sha256-o9N1jA5wGk2q9o6u6w3eD0u5Q5jQh3w3z3b4g7zQm0Y=" crossorigin=""></script>

    <title>Crear sitio</title>
</head>
<body>

<main>
    <form action="{{ route('crear_sitio') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="nombre">Nombre del sitio</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}">
            @error('nombre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror


            <label for="slogan">Slogan</label>
            <input type="text" name="slogan" id="slogan" value="{{ old('slogan') }}">
            @error('slogan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <label for="portada">Imagen de portada</label>
            <input type="file" name="portada" id="portada">
            @error('portada')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>


        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion">{{ old('descripcion') }}</textarea>
        @error('descripcion')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror


        <div>
            <label for="localizacion">Localización</label>
            <textarea name="localizacion" id="localizacion">{{ old('localizacion') }}</textarea>
            @error('localizacion')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <div style="display:flex; gap:1rem; align-items:flex-start;">
    <div style="flex:1;">
        <div id="map" style="height:300px; border-radius:8px;"></div>
    </div>

    <div style="width:300px;">
        <p class="text-sm mb-2">Coordenadas seleccionadas:</p>
        <label>Latitud</label>
        <input type="text" id="lat" name="lat" value="{{ old('lat', $turisticPlace->lat ?? '') }}" readonly>
        <label>Longitud</label>
        <input type="text" id="lng" name="lng" value="{{ old('lng', $turisticPlace->lng ?? '') }}" readonly>

        <button type="button" id="btn-geolocate">Usar mi ubicación</button>
        <p class="text-xs text-gray-500 mt-2">Mueve el marcador o haz clic en el mapa para elegir la posición.</p>
    </div>
</div>
        </div>


        <div>
            <label for="clima_img">Imagen del clima</label>
            <input type="file" name="clima_img">
            @error('clima_img')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <label for="clima">Clima</label>
            <textarea name="clima" id="clima">{{ old('clima') }}</textarea>
            @error('clima')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>


        <div>
            <label for="caracteristicas">Características</label>
            <textarea name="caracteristicas" id="caracteristicas">{{ old('caracteristicas') }}</textarea>
            @error('caracteristicas')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <label for="caracteristicas_img">Imagen de características</label>
            <input type="file" name="caracteristicas_img">
        </div>


        <div>
            <label for="flora_img">Imagen de flora</label>
            <input type="file" name="flora_img">
            @error('flora_img')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <label for="flora">Flora y fauna</label>
            <textarea name="flora" id="flora">{{ old('flora') }}</textarea>
            @error('flora')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>


        <div>
            <label for="infraestructura_img">Imagen de infraestructura</label>
            <input type="file" name="infraestructura_img">
            @error('infraestructura_img')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <label for="infraestructura">Infraestructura</label>
            <textarea name="infraestructura" id="infraestructura">{{ old('infraestructura') }}</textarea>
            @error('infraestructura')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>


        <label for="recomendacion">Recomendaciones</label>
        <textarea name="recomendacion" id="recomendacion">{{ old('recomendacion') }}</textarea>
        @error('recomendacion')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror


        <div>
            <label>
                <input type="checkbox" name="terminos">
                Acepto términos
                  @error('terminos')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
            </label>

            <label>
                <input type="checkbox" name="politicas" >
                Acepto políticas
                  @error('politicas')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
            </label>
        </div>

        <button type="submit">Finalizar</button>
    </form>
</main>
<script src=""></script>
</body>
</html>
