$(document).ready(function () {
	const VISUAL = $('#visual');
	const minScale = 0.2;
	const maxScale = 3;
	const step = 0.1;

	// Read initial scale from computed transform matrix: matrix(s, 0, 0, s, 0, 0)
	const computedTransform = VISUAL.css("transform");
	let scale = (computedTransform && computedTransform !== 'none')
		? (parseFloat(computedTransform.split("(")[1]) || 1)
		: 1;

	// Switch to center-based transform-origin and compensate left/top so the
	// element doesn't visually jump (the inline style has a hardcoded origin).
	{
		const originParts = VISUAL.css("transform-origin").split(" ");
		const ox = parseFloat(originParts[0]);
		const oy = parseFloat(originParts[1]);
		const W  = VISUAL.outerWidth();
		const H  = VISUAL.outerHeight();
		const L  = parseFloat(VISUAL.css("left")) || 0;
		const T  = parseFloat(VISUAL.css("top"))  || 0;
		VISUAL.css({
			"transform-origin": "50% 50%",
			"left": (L + (W / 2 - ox) * (scale - 1)) + "px",
			"top":  (T + (H / 2 - oy) * (scale - 1)) + "px",
		});
	}

	function clamp(s) {
		return Math.round(Math.min(maxScale, Math.max(minScale, s)) * 10) / 10;
	}

	// Scale around an optional viewport point (clientX/clientY).
	// With transform-origin: 50% 50%, the element's center stays fixed on pure
	// scale change, so we shift left/top to keep the cursor-pointed spot fixed.
	function setScale(newScale, mx, my) {
		const oldScale = scale;
		scale = clamp(newScale);
		if (scale === oldScale) return;

		const update = { "transform": "scale(" + scale + ")" };

		if (mx !== undefined) {
			const rect = VISUAL[0].getBoundingClientRect();
			const cx   = rect.left + rect.width  / 2;
			const cy   = rect.top  + rect.height / 2;
			const ratio = (oldScale - scale) / oldScale;
			update["left"] = ((parseFloat(VISUAL.css("left")) || 0) + (mx - cx) * ratio) + "px";
			update["top"]  = ((parseFloat(VISUAL.css("top"))  || 0) + (my - cy) * ratio) + "px";
		}

		VISUAL.css(update);
	}

	// Кнопки
	$("#zoom-in").click(function ()  { setScale(scale + step); });
	$("#zoom-out").click(function () { setScale(scale - step); });

	// Перемещение мышкой
	VISUAL.draggable({ cursor: "move" });

	// Колёсико мыши
	VISUAL.on('wheel', function (e) {
		e.preventDefault();
		const dir = e.originalEvent.deltaY < 0 ? step : -step;
		setScale(scale + dir, e.clientX, e.clientY);
	});

	// Навигация для мобильных устройств
	if (typeof isMobile !== 'undefined' && isMobile) {
		mobileDraggable();
	}

	function mobileDraggable() {
		let startX, startY, v_left, v_top;

		VISUAL.on('touchstart', function (event) {
			const touch = event.originalEvent.touches[0];
			startX = touch.clientX;
			startY = touch.clientY;
			v_left = parseFloat(VISUAL.css("left")) || 0;
			v_top  = parseFloat(VISUAL.css("top"))  || 0;
		});

		VISUAL.on('touchmove', function (event) {
			event.preventDefault();
			const touch = event.originalEvent.touches[0];
			VISUAL.css({
				'left': (v_left + touch.clientX - startX) + "px",
				'top':  (v_top  + touch.clientY - startY) + "px",
			});
		});
	}
});
