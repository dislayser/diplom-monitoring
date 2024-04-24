$(document).ready(function() {
	// HTML OBJ
	const IMG_MAP = $('img#map');
	const SELECT_DEVICE = $('#device');
	const SELECT_GAS_TYPE = $('#gas_types');
	const SELECT_OPACITY = $('#sector_opacity');

	// GLOBAL DATA
	let DB_GAS = [];
	let DB_TYPES = [];
	let curDevice = getCookie('device');
	let curGasType = getCookie('gas_type')
	let sector = {
        'x': 120,
        'y': 120,
        'opacity': SELECT_OPACITY.val(),
		'class' : 'grid_sector', 
    };

    getOne('get', {}, 'json', BASE_URL + 'api/get/gasTypes', function(data){
        DB_TYPES = data;
    });

	if (curDevice > 0){
		update();
	} 

	// SELECT changes events
	SELECT_DEVICE.change(function(){
		if (curDevice != SELECT_DEVICE.val()){
			setCookie('device', SELECT_DEVICE.val());
			update();
		}
	});
	SELECT_GAS_TYPE.change(function(){
        setCookie('gas_type', SELECT_GAS_TYPE.val());
		update();
	});
	SELECT_OPACITY.change(function(){
        setCookie('sector_opacity', SELECT_OPACITY.val());
		update();
	});

	function update(){
		getOne('get', {'id': getCookie('device')}, 'json', BASE_URL + 'api/get/gasData', function(data){
			curDevice = getCookie('device');
			DB_GAS = data;
			console.log(DB_GAS);
			if (DB_GAS.data){
				IMG_MAP.attr('src', BASE_URL + "assets/img/data/monitoring/" + DB_GAS.map_file);
				gas_options(DB_GAS.data);
			}else{
				$('option#gas_type').remove();
				$(sector.class).remove();
				IMG_MAP.attr('src', '');
			}
		});

		if (curGasType != getCookie('gas_type')) {
			curGasType = getCookie('gas_type');
			setGradation_nums();
			createSectors()
		}
	}

	function createSectors(){

	}

	function createGrid(){

	}

    //Устанавливает начальную градацию и конечную
    function setGradation_nums(){
        let $num_start = $('small[data-num="start"]');
        let $num_end = $('small[data-num="end"]');
        for (const [key, item] of Object.entries(DB_TYPES)) {
            if (item['name'] == selected_gas){
                $num_start.text(item['num_start']);
                $num_end.text(item['num_end']);
                break;
            } 
        } 
    }

	//Находит список газов
	function gas_options(obj){
		if (obj){
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
		let options = null;
		for (let i = 0; i < gas_types.length; i++) {
			let item = $(`<option id="gas_type">`);
			item.val(gas_types[i]);
			item.text(gas_types[i]);
			SELECT_GAS_TYPE.append(item);
		}
		return gas_types;
	}
});
