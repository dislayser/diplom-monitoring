<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Масштабирование карты к точке</title>
<style>
    #visual {
        width: 400px;
        height: 300px;
        border: 1px solid #ccc;
        overflow: hidden;
        position: relative;
    }
    #map {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        transition: transform 0.3s ease;
        transform-origin: 0 0;
    }
</style>
</head>
<body>

<div id="visual">
    <img src="assets/img/data/monitoring/1.png" class="map" alt="" id="map">
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var visual = $("#visual");
        var map = $("#map");

        visual.on("wheel", function(event) {
            event.preventDefault();
            var deltaY = event.originalEvent.deltaY;
            var scaleMultiplier = 1 + (deltaY > 0 ? -0.1 : 0.1);
            var mouseX = event.clientX - visual.offset().left;
            var mouseY = event.clientY - visual.offset().top;
            var prevScale = parseFloat(map.css("transform").split("(")[1].split(")")[0].split(",")[0]);
            var newScale = prevScale * scaleMultiplier;
            var deltaX = (mouseX * (1 - scaleMultiplier)) / prevScale;
            var deltaY = (mouseY * (1 - scaleMultiplier)) / prevScale;

            map.css({
                transform: "scale(" + newScale + ") translate(" + deltaX + "px, " + deltaY + "px)"
            });
        });
    });
</script>

</body>
</html>
