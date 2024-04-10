$(document).ready(function() {
    const map_item = $('img#map');

    // Данные карты
    let map = {
        'x': map_item.width(),
        'y': map_item.height(),
    };

    // Данные сектора
    let sector = {
        'x': 120,
        'y': 120,
        'opacity': 0.3,
    }

    function rand(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min; // Максимум и минимум включаются
      }
    
    // Функция, возвращающая блок 
    function grid_item(i, j, params = {}) {
        let grid_item = $('<div></div>');
        grid_item.addClass('grid-item');

        let rand_num = rand(0,255);

        grid_item.text(rand_num);
        
        let grid_item_color = `rgba(${rand_num}, ${255-rand_num}, 0, ${sector.opacity})`;
        
        // Вычисляем позицию элемента
        let posX = i * sector.x;
        let posY = j * sector.y;
        
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
    }
    
    // Размеры сетки
    let map_grid = {
        'x': Math.floor(map.x / sector.x),
        'y': Math.floor(map.y / sector.y),
    }
    
    // Создание и отображение сетки
    for (let i = 0; i < map_grid.x; i++) {
        for (let j = 0; j < map_grid.y; j++) {
            // Создаем элемент для отображения номера сектора
            if (i && j && 40<rand(1,100)){

                let grid = grid_item(i,j);
            
                // Вставляем элемент в DOM
                $('#visual').append(grid);
            }
        }
    }
});
