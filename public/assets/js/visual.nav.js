$(document).ready(function() {
	const VISUAL = $('#visual');
	// Настройка масштабирования
	var scale = parseFloat(VISUAL.css("transform").split("(")[1].split(")")[0]);
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
		var offsetX = (pointX - VISUAL.offset().left);
		var offsetY = (pointY - VISUAL.offset().top);

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
		let deltaY = e.originalEvent.deltaY;
		
		var mouseX = e.clientX - VISUAL.offset().left;
		var mouseY = e.clientY - VISUAL.offset().top;

		//console.log(mouseX, mouseY)

		if (deltaY > 0) { 
			zoom_to_point(mouseX, mouseY, 'out');
		}
		if (deltaY < 0) { 
			zoom_to_point(mouseX, mouseY, 'in');
		}
	});
	
});
