let DB_GAS = [];
function device_change(){};
$(document).ready(function() {
	// HTML OBJ
	const VISUAL = $('#visual');
	const IMG_MAP = $('img#map');
	const SELECT_DEVICE = $('#device');
	const SELECT_GAS_TYPE = $('#gas_types');
	const SELECT_OPACITY = $('#sector_opacity');
	const SELECT_SECTOR_TYPE = $('#sector_type');
	const RAINBOW = $('.rainbow-gradation');
	const BTN_SAVE = $('#cp_save');
	const RADIO_SECTOR_SIZE = 'input[name="sector_size"]';
	const CHECKBOX_MESH = $('#set_mesh');


	// GLOBAL DATA
	let DB_TYPES = [];
	let DB_TYPES_ITEM = [];
	let DB_DEVICE = [];
	let map = {
		'width' : 0,
		'height' : 0,
		'offset' : {
			'x' : 0,
			'y' : 0,
		},
		'matrix' : {
			'x' : 0,
			'y' : 0,
		},
	};
	let sector = {
        'x': 0,
        'y': 0,
        'opacity': SELECT_OPACITY.val(),
		'class' : 'grid_sector',
		'size' : $(RADIO_SECTOR_SIZE + ':checked').val()
    };
	let mesh = {
		'class' : 'mesh_item',
		'color' : 'black',
		'border' : 1,
        'opacity': 0.5,
	}

    getOne('get', {}, 'json', BASE_URL + 'api/get/gasTypes', function(data){
        DB_TYPES = data;
		//canvas_rainbow();
		setGradation_nums();
    });

	if (SELECT_DEVICE.val() > 0){
		device_change();
	}

	// SELECT changes events
	SELECT_DEVICE.change(function(){device_change()});
	function device_change(){
		setCookie('device', SELECT_DEVICE.val());
		
		$('.' + sector.class).remove();
		getOne('get', {'id':SELECT_DEVICE.val()}, 'json', BASE_URL + 'api/get/deviceData', function(data){
			DB_DEVICE = data;
		});

		getOne('get', {'id':SELECT_DEVICE.val()}, 'json', BASE_URL + 'api/get/gasData', function(data){
			if (data.data != undefined){
				DB_GAS = data;
				console.log(DB_GAS);
				gas_options(data.data);
				IMG_MAP.attr('src', BASE_URL + "assets/img/data/monitoring/" + DB_GAS.map_file).on('load', function() {
					map.width = IMG_MAP.width();
					map.height = IMG_MAP.height();
					sector.x = DB_DEVICE.sector_x;
					sector.y = DB_DEVICE.sector_y;

					// Размеры сетки
					map.matrix = {
						'x': Math.floor(map.width / sector.x),
						'y': Math.floor(map.height / sector.y),
					};
				});
				update();
			}else{
				DB_GAS = [];
				IMG_MAP.attr('src', '');
				map.width = 0;
				map.height = 0;
				gas_options([]);
			}
		});

	}

	SELECT_GAS_TYPE.change(function(){gas_type_change()});
	function gas_type_change(){
        setCookie('gas_type', SELECT_GAS_TYPE.val());
		update();
	}

	SELECT_OPACITY.change(function(){opacity_change()});
	function opacity_change(){
        setCookie('sector_opacity', SELECT_OPACITY.val());
		sector.opacity = SELECT_OPACITY.val();

        $('.' + sector.class).each(function() {
            let currentColor = $(this).css('background-color');
            $(this).css('background-color', currentColor.replace(/[\d\.]+\)$/g, sector.opacity + ')'));
        });
	}

	SELECT_SECTOR_TYPE.change(function(){sector_type_change()});
	function sector_type_change(){
		update();
	}

	//Включение отключение сетки
	CHECKBOX_MESH.change(function(){checkbox_mesh_change()});
	function checkbox_mesh_change(){
		$('.'+mesh.class).remove();
		if(CHECKBOX_MESH[0].checked){
			createGrid();
		} 
	}

	//Кнопка сохранить
	BTN_SAVE.click(function(){
		checkbox_mesh_change();
		update();
	});

	$(document).on("click", "#toast_update_btn", function(){
		device_change();
	});

	//Обновление 
	function update(){
		$('.' + sector.class).remove();
		//load_btn(BTN_SAVE);
		if (SELECT_GAS_TYPE.val() !== '' && SELECT_GAS_TYPE.val()) {
			setGradation_nums();
			createSectors();
		}
		//load_btn_rm(BTN_SAVE);
	}

	function createSectors(){
        // Создание и отображение сетки

		let rainbow_ctx = null;
		if(SELECT_SECTOR_TYPE.val() == 'square'){
			rainbow_ctx = create_canvas(10);
		}else{
			rainbow_ctx = create_canvas();
		}

        for (const [i, x] of Object.entries(DB_GAS.data)) {    
            for (const [j, y] of Object.entries(x)) {
				//Для оптимизации выолнения операции
                setTimeout(function() {
					let item = sector_item(i,j, rainbow_ctx)
					VISUAL.append(item);
				}, 1);
            }
        }
	}
	function sector_item(i,j,rainbow_ctx){
		let item = $('<div>');
		let text = DB_GAS['data'][i][j][SELECT_GAS_TYPE.val()];

		item.attr({
			'class':sector.class,
			'data-col' : i,
			'data-row' : j
		});

		if(SELECT_SECTOR_TYPE.val() == 'square'){
			item.text(text);
		}

		let posX = map.offset.x + (i * sector.x);
		let posY = map.offset.y + (j * sector.y);
		let color = getColor(text, rainbow_ctx)

		item.css({
			'position': 'absolute',
			'left': posX + 'px',
			'top': posY + 'px',
			'width': sector.x + 'px',
			'height': sector.y + 'px',
			'font-size' : '0.5rem',
			'line-height': sector.y + 'px',
			'text-align': 'center',
			'background-color': color, // Прозрачный фон
		});

		return item;
	}

	function createGrid(){
		$('.'+mesh.class).remove();
		let v_lines = map.matrix.x;
		let h_lines = map.matrix.y;

		for (let i = 0; i < v_lines; i++) {
			let v_line = $('<div>');
			let posX = map.offset.x + ((i+1) * sector.x);
			v_line.attr({
				'class':mesh.class,
			});
			v_line.css({
                'position': 'absolute',
                'left': posX + 'px',
                'top': '0px',
                'width': mesh.border + 'px',
                'height': map.height,
				'opacity' : mesh.opacity,
                'background-color': mesh.color,
            });
			VISUAL.append(v_line);
		}
		for (let i = 0; i < h_lines; i++) {
			let h_line = $('<div>');
			let posY = map.offset.y + ((i+1) * sector.y);
			h_line.attr({
				'class':mesh.class,
			});
			h_line.css({
                'position': 'absolute',
                'left': '0px',
                'top': posY + 'px',
                'width': map.width,
                'height': mesh.border + 'px',
				'opacity' : mesh.opacity,
                'background-color': mesh.color,
            });
			VISUAL.append(h_line);
		}
	}

    //Устанавливает начальную градацию и конечную
    function setGradation_nums(){
        let $num_start = $('small[data-num="start"]');
        let $num_end = $('small[data-num="end"]');
        for (const [key, item] of Object.entries(DB_TYPES)) {
            if (item['name'] == getCookie('gas_type')){
				DB_TYPES_ITEM = item;
                $num_start.text(item['num_start']);
                $num_end.text(item['num_end']);
                break;
            } 
        } 
    }

	//Находит список газов
	function gas_options(obj){
		if (obj != undefined){
			let keys = [];
			for (const [key_x, x] of Object.entries(obj)) {    
				for (const [key_y, y] of Object.entries(x)) {
					keys = Object.keys(y);
					break;
				}
				break;
			}
			return select_gas(keys);
		}
	}
	// Создает список газов
	function select_gas(gas_types){
		$('option#gas_type').remove();
		let options = null;
		for (let i = 0; i < gas_types.length; i++) {
			let item = $(`<option id="gas_type">`);
			item.val(gas_types[i]);
			item.text(gas_types[i]);
			SELECT_GAS_TYPE.append(item);
			SELECT_GAS_TYPE.val(getCookie('gas_type'));
		}
		return gas_types;
	}

	//Работа с цветом
	function create_canvas(width = RAINBOW.width()){
		$('canvas#canvas_rainbow').remove();
		var canvas = document.createElement('canvas');
		canvas.id = 'canvas_rainbow';
        canvas.width = width;
        canvas.height = 1;
		canvas.style.display = 'none';
		
        var ctx = canvas.getContext('2d', { willReadFrequently: true });

		/*
		var colors = {
			'success' : getComputedStyle(document.documentElement).getPropertyValue('--bs-success'),
			'warning' : getComputedStyle(document.documentElement).getPropertyValue('--bs-warning'),
			'danger' : getComputedStyle(document.documentElement).getPropertyValue('--bs-danger'),
		};

		*/
		var colors = {
			'success': '#00FF00', // Зеленый
			'warning': '#FFFF00', // Желтый
			'danger': '#FF0000', // Красный
		};

        var gradient = ctx.createLinearGradient(0, 0, width, 1);
        gradient.addColorStop(0, colors.success);
        gradient.addColorStop(0.5, colors.warning);
        gradient.addColorStop(1, colors.danger);

        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, width, 1);

        RAINBOW.after(canvas);

		return ctx;
	}

	function getColor(val, ctx){
		let step = ($('canvas#canvas_rainbow').width() - 1) / (DB_TYPES_ITEM.num_end - DB_TYPES_ITEM.num_start);

		val = val - DB_TYPES_ITEM.num_start;

		var x = Math.min(Math.max(val, 0), (DB_TYPES_ITEM.num_end - DB_TYPES_ITEM.num_start));
		var y = 0;

		var pixel = ctx.getImageData(Math.round(x * step), y, 1, 1).data;

		let color = `rgba(${pixel[0]}, ${pixel[1]}, ${pixel[2]}, ${sector.opacity})`;
		return color;
	}

	//Загрузка
	function load_btn($button){
		$button.prop('disabled', true);
		$button.find('.spinner-border').show('fast');
	}
	function load_btn_rm($button){
		$button.prop('disabled', false);
		$button.find('.spinner-border').hide('fast');
	}

	//При наведении на сектор
	action_select_secror()
	function action_select_secror(){
		function active_sector(){

		}
		
	}
	function halveMatrix(arr) {
		let halvedArr = {};
		let rowCount = Object.keys(arr).length;
		let colCount = 0;
		
		// Определяем количество столбцов в матрице
		for (let row in arr) {
			let currentRowColCount = Object.keys(arr[row]).length;
			if (currentRowColCount > colCount) {
				colCount = currentRowColCount;
			}
		}
	
		// Уменьшаем размер матрицы
		for (let i = 1; i <= rowCount / 2; i++) {
			halvedArr[i] = {};
			for (let j = 1; j <= colCount / 2; j++) {
				let newRow = i;
				let newCol = j;
				let sum = 0;
				let count = 0;
				if (arr[i * 2 - 1] && arr[i * 2]) {
					if (arr[i * 2 - 1][j * 2 - 1] && arr[i * 2][j * 2 - 1]) {
						sum += arr[i * 2 - 1][j * 2 - 1].abc;
						count++;
					}
					if (arr[i * 2 - 1][j * 2] && arr[i * 2][j * 2]) {
						sum += arr[i * 2 - 1][j * 2].abc;
						count++;
					}
				}
				if (arr[i * 2] && arr[i * 2 + 1]) {
					if (arr[i * 2][j * 2 - 1] && arr[i * 2 + 1][j * 2 - 1]) {
						sum += arr[i * 2][j * 2 - 1].abc;
						count++;
					}
					if (arr[i * 2][j * 2] && arr[i * 2 + 1][j * 2]) {
						sum += arr[i * 2][j * 2].abc;
						count++;
					}
				}
				halvedArr[newRow][newCol] = sum / count;
			}
		}
		return halvedArr;
	}
	
});



