<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parqueaderos Cercanos</title>


  



    <!--<script src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY&callback=initMap" async defer></script>-->
     
    <link rel="icon" href="../img/parqueadero.ico" type="image/x-icon">

    
    <script>
        function initMap() {
            // Ubicación inicial (puede ser la ubicación del usuario)
            var location = {lat: -34.397, lng: 150.644};

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: location
            });

            // Marcadores de parqueaderos (pueden ser cargados dinámicamente)
            var markers = [
                {lat: -34.397, lng: 150.644, name: 'Parqueadero 1'},
                {lat: -34.397, lng: 150.744, name: 'Parqueadero 2'}
            ];

            markers.forEach(function(marker) {
                new google.maps.Marker({
                    position: {lat: marker.lat, lng: marker.lng},
                    map: map,
                    title: marker.name
                });
            });
        }
    </script>
</head>
<body>
    <h2>Parqueaderos Cercanos</h2>

    <ul>
            <li><a href="dashboard.php">Inicio</a></li>
           
    </ul>


    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7874.6669383635235!2d-75.39908409118651!3d9.303691298574096!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e5914497166e783%3A0xcbe5af396d4f7728!2sGran%20Centro%20El%20Parque!5e0!3m2!1ses!2sco!4v1725126280751!5m2!1ses!2sco" width="500" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    <!--<div id="map" style="height: 500px; width: 100%;"></div>-->
</body>
</html>
