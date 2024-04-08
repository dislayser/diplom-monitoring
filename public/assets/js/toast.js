
class Toast {
    constructor(params){
        this.Placement_block = `<div class="toast-container p-3 top-0 end-0" id="toast_placement"></div>`;
        $('body').append(this.Placement_block);
        
        this.params = params;
        this.Placement = $('#toast_placement');
        this.Toasts = [];
    }

    create(){
        var $toast = $(`
            <div class="toast fade show">
                <div class="toast-header">
                    <div class="bd-placeholder-img rounded me-2 d-flex justify-content-center align-items-center text-warning" style="background: var(--bs-primary);width: 20px; height: 20px;">
                        ${this.params.logo}
                    </div>
                    <strong class="me-auto"></strong>
                    <small></small>
                    <button type="button" class="btn-close" aria-label="Закрыть"></button>
                </div>
                <div class="toast-body">
                </div>
            </div>
        `);

        //Подстановка текста
        $toast.find('strong').html(this.params.site);
        $toast.find('.toast-body').text(this.params.msg);
        // Добавляем элемент времени в тост
        const $timeElement = $toast.find('small');
        $timeElement.html(this.params.time);
        
        // Добавляем созданный тост в массив
        var created_time = new Date(); 
        this.Toasts.push({
            $toast,
            'time' : created_time.toLocaleTimeString(),
        });

        // Обновляем время каждую секунду
        const updateInterval = setInterval(() => {
            $timeElement.html(this.getTimeAgo(created_time));
        }, 1000);

        // Добавляем обработчик события для кнопки закрытия
        $toast.find('.btn-close').on('click', () => {
            clearInterval(updateInterval); // Останавливаем обновление времени при закрытии тоста
            this.removeToast($toast);
        });

        this.Placement.append($toast);

    }

    // Метод для удаления тоста из массива и из DOM
    removeToast($toast) {
        // Находим индекс тоста в массиве
        const index = this.Toasts.findIndex(item => item.$toast === $toast);
        if (index !== -1) {
            // Удаляем тост из массива
            this.Toasts.splice(index, 1);
            // Удаляем тост из DOM
            $toast.remove();
        }
    }

    // Метод для преобразования времени в формат "три секунды назад", "час назад" и т.д.
    getTimeAgo(time) {
        const currentTime = new Date();
        const pastTime = new Date(time);
        const elapsed = currentTime - pastTime;
        const seconds = Math.floor(elapsed / 1000);
        if (seconds < 60) {
            return 'Tолько что';
        }
        const minutes = Math.floor(seconds / 60);
        if (minutes < 60) {
            return `${minutes} ${this.pluralize(minutes, 'минуту', 'минуты', 'минут')} назад`;
        }
        const hours = Math.floor(minutes / 60);
        if (hours < 24) {
            return `${hours} ${this.pluralize(hours, 'час', 'часа', 'часов')} назад`;
        }
        const days = Math.floor(hours / 24);
        return `${days} ${this.pluralize(days, 'день', 'дня', 'дней')} назад`;
    }

    // Метод для склонения слов
    pluralize(number, one, two, many) {
        if (number % 10 === 1 && number % 100 !== 11) {
            return one;
        } else if (number % 10 >= 2 && number % 10 <= 4 && (number % 100 < 10 || number % 100 >= 20)) {
            return two;
        } else {
            return many;
        }
    }
}


