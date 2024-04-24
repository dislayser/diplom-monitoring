$(document).ready(function() {
    //Карта
    const map_item = $('img#map');
    //Типы газов
    let gas_types = [];
    //Данные газа
    let gas_data = [];
    // Данные сектора
    let sector = {
        'x': 120, //120
        'y': 120, //120
        'opacity': $('#sector_opacity').val(),
    }
    //Выбранный газ
    let selected_gas = getCookie('gas_type');
    //Типы газов из БД
    let gas_types_db = [];
    getOne('get', {}, 'json', BASE_URL + 'api/get/gasTypes', function(data){
        gas_types_db = data;
    });

    get_data();

    function get_data(device_id = $('#device').val()){
        //Получение данных о газе
        if (device_id > 0){
            getOne('get', {'id': device_id}, 'json', BASE_URL + 'api/get/gasData', function(data){
                if (data.data){
					console.log(data);

                    gas_data = data.data;
                    gas_types = getGasTypes(gas_data);
                    console.log(gas_types);

                    map_item.attr('src', BASE_URL + "assets/img/data/monitoring/" + data.map_file);
                    select_gas(gas_types);

                    selected_gas = getCookie('gas_type'); 
                    if (selected_gas) {
                        $('#gas_types').val(selected_gas);
                        setGradation_nums();
                    }
                    grid_create(map_item, gas_data);
                }
            });
        }
    }

    //Находит список газов
    function getGasTypes(obj){
        let keys = [];

        console.log(obj);
        for (const [key_x, x] of Object.entries(obj)) {    
            for (const [key_y, y] of Object.entries(x)) {
                keys = Object.keys(y);
                break;
            }
            break;
        }

        return keys;
    }
    
    //Прозрачность
    $('#sector_opacity').change(function(){
        let opacity = $(this).val();
        setCookie('sector_opacity', opacity);
        $('.grid-item').each(function() {
            let currentColor = $(this).css('background-color');
            $(this).css('background-color', currentColor.replace(/[\d\.]+\)$/g, opacity + ')'));
        });
    });
    //Устройство
    $('#device').change(function(){
        $('.grid-item').remove();
        map_item.attr('src', "");
        $('option#gas_type').remove();

        setCookie('device', $('#device').val())
        get_data();
    });
    //Тип газа
    $('#gas_types').change(function(){
        selected_gas = $('#gas_types').val();
        grid_create(map_item, gas_data);

        setCookie('gas_type', $('#gas_types').val())
        setGradation_nums();
    });

    //Устанавливает начальную градацию и конечную
    function setGradation_nums(){
        let $num_start = $('small[data-num="start"]');
        let $num_end = $('small[data-num="end"]');
        for (const [key, item] of Object.entries(gas_types_db)) {
            if (item['name'] == selected_gas){
                $num_start.text(item['num_start']);
                $num_end.text(item['num_end']);
                break;
            } 
        } 
    }

    function grid_create(map_item, gas_array){
        $('.grid-item').remove();
        // Данные карты
        sector['opacity']= $('#sector_opacity').val();
        
        let map = {
            'x': map_item.width(),
            'y': map_item.height(),
            'matrix' : null,
            'offset' : {
                'x' : 0,
                'y' : 0,
            },
        };
        
        // Размеры сетки
        map.matrix = {
            'x': Math.floor(map.x / sector.x),
            'y': Math.floor(map.y / sector.y),
        };

        console.log(map);
        // Создание и отображение сетки
        for (const [i, x] of Object.entries(gas_array)) {    
            for (const [j, y] of Object.entries(x)) {
                let grid = grid_item(i,j, sector, map);
                // Вставляем элемент в DOM
                $('#visual').append(grid);
            }
        }
    }


    function rand(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min; // Максимум и минимум включаются
    }
    
    //Для линий
    function grid_line(i, j, sector){
        
        let grid_item = $('<div></div>');
        grid_item.addClass('grid-line');

        // Вычисляем позицию элемента
        let posX = i * sector.x;
        let posY = j * sector.y;

        if (i == 0){
            // Устанавливаем позицию элемента
            grid_item.css({
                'position': 'absolute',
                'left': posX + 'px',
                'top': posY + 'px',
                'width': map.x + 'px',
                'height': '1px',
                'background-color': 'black',
            });
        }
        if (j == 0){
            // Устанавливаем позицию элемента
            grid_item.css({
                'position': 'absolute',
                'left': posX + 'px',
                'top': posY + 'px',
                'width': '1px',
                'height': map.y + 'px',
                'background-color': 'black',
            });
        }

        return grid_item;
    }

    // Функция, возвращающая блок 
    function grid_item(i, j, sector, map) {
        if (selected_gas) {
            let grid_item = $('<div></div>');
            grid_item.addClass('grid-item');
    
            let num = gas_data[i][j][selected_gas];
    
            grid_item.text(num);
            
            let grid_item_color = `rgba(${num*7}, ${255-(num*7)}, 0, ${sector.opacity})`;
            
            // Вычисляем позицию элемента
            let posX = map.offset.x + (i * sector.x);
            let posY = map.offset.x + (j * sector.y);
            
            // Устанавливаем позицию элемента
            grid_item.css({
                'position': 'absolute',
                'left': posX + 'px',
                'top': posY + 'px',
                'width': sector.x + 'px',
                'height': sector.y + 'px',
                'line-height': sector.y + 'px',
                'text-align': 'center',
                'background-color': grid_item_color, // Прозрачный фон
            });
    
            return grid_item;
        }else{
            return '';
        }
    }

    // Создает список газов
    function select_gas(gas_types){
        let options = null;
        for (let i = 0; i < gas_types.length; i++) {
            let item = $(`<option id="gas_type">`);
            item.val(gas_types[i]);
            item.text(gas_types[i]);
            $('#gas_types').append(item);
        }
        return options;
    }
});
