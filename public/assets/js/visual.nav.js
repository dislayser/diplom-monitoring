$(document).ready(function() {
	const VISUAL = $('#visual');
	const MAP = $("#map");
	// Настройка масштабирования
	let scale = parseFloat(VISUAL.css("transform").split("(")[1].split(")")[0]);
	var minScale = 0.2;
	var maxScale = 3;
	var step = 0.1;

	function zoom_in(){
		if (scale < maxScale) {
			scale += step;
			VISUAL.css("transform", "scale(" + scale + ")");
		}
	}

	function zoom_out(){
		if (scale > minScale) {
			scale -= step;
			VISUAL.css("transform", "scale(" + scale + ")");
		}
	}

	// Функция для масштабирования к точке, куда смотрит мышь
	function zoom_to_point(pointX, pointY, direction){

		// Изменяем масштаб
		if(direction === 'in' && scale < maxScale) {
			scale += step;
		} else if(direction === 'out' && scale > minScale) {
			scale -= step;
		}

		// Определяем новые координаты для смещения элемента
		var offsetX = (pointX - parseInt(VISUAL.css("left")));
		var offsetY = (pointY - parseInt(VISUAL.css("top")));

		// Применяем изменения к элементу
		VISUAL.css({
			"transform": "scale(" + scale + ")",
			"transform-origin": pointX + "px " + pointY + "px",
		});
	}

	// Кнопки
	$("#zoom-in").click(function() {zoom_in();});
	$("#zoom-out").click(function() {zoom_out();});

	// Для перемещения мышкой
	VISUAL.draggable({
		cursor: "move",
	});

	// Обработчик колеса мыши
	VISUAL.on('wheel', function(e){
		e.preventDefault();
		

		//console.log(e);

		let deltaY = e.originalEvent.deltaY;
		
		var mouseX = e.clientX - parseInt(VISUAL.css("left"));
		var mouseY = e.clientY - parseInt(VISUAL.css("top"));

		//console.log(MAP.width() * scale, MAP.height() * scale)

		if (deltaY > 0) { 
			zoom_to_point(mouseX, mouseY, 'out');
		}
		if (deltaY < 0) { 
			zoom_to_point(mouseX, mouseY, 'in');
		}
	});

	//Навигация для мобильных устройств
	if (isMobile) {
		mobile_draggable();
	}
	function mobile_draggable(){
		
        let startX;
        let startY;
        let isDragging = false;

        
        let v_left, v_top; 


        const VISUAL = $('#visual');

        VISUAL.on('touchstart mousedown', function(event) {
            if (event.type === 'mousedown') {
                isDragging = true;
            } else {
                startX = event.originalEvent.touches[0].clientX;
                startY = event.originalEvent.touches[0].clientY;
                
                v_left = parseInt(VISUAL.css("left"));
                v_top = parseInt(VISUAL.css("top"));
            }
        });

        VISUAL.on('touchmove mousemove', function(event) {
            event.preventDefault(); // предотвращаем прокрутку страницы при свайпе

            if (isDragging) {
                return; // если уже перетаскиваем элемент, не обрабатываем свайпы
            }

            let currentX, currentY;

            if (event.type === 'mousemove') {
                currentX = event.clientX;
                currentY = event.clientY;
            } else {
                currentX = event.originalEvent.touches[0].clientX;
                currentY = event.originalEvent.touches[0].clientY;
            }

            let deltaX = currentX - startX;
            let deltaY = currentY - startY;

            console.log(deltaX, deltaY);
            
            VISUAL.css('left', (v_left + (deltaX)) + "px");
            VISUAL.css('top',  (v_top  + (deltaY)) + "px");
        });

        $(document).on('mouseup touchend', function() {
            isDragging = false;
        });
	}

});
