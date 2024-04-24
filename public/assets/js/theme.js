document.addEventListener('DOMContentLoaded', function () {
    const htmlElement = document.documentElement;
    const theme_icon = document.getElementById('theme-icon');

    // Проверяем, есть ли куки с темой
    const themeCookie = getCookie("theme");
    if (themeCookie) {
        set_theme(themeCookie);
    } else { 
        //Получение данных об установленной в системе теме
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            set_theme('dark');
        } else {
            set_theme('light');
        }
    }    

    //Нажатие на кнопку смены темы 
    $(document).on("click", "#themeToggle", function() {
        const currentTheme = htmlElement.getAttribute('data-bs-theme');
        if (currentTheme === 'dark'){
            set_theme('light');
        } else if (currentTheme === 'light'){
            set_theme('dark');
        } else {
            set_theme('light');
        }

    });

    //Функция установки темы
    function set_theme(theme){
        document.cookie = "theme=" + theme + "; expires=" + new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toUTCString() + "; path=/";
        htmlElement.setAttribute('data-bs-theme', theme);
        if (theme === 'dark'){
            theme_icon.classList.remove('bi-moon-fill');
            theme_icon.classList.remove('text-black');
            theme_icon.classList.add('bi-brightness-high-fill');
            theme_icon.classList.add('text-warning');
        } else
        if (theme === 'light'){
            theme_icon.classList.remove('bi-brightness-high-fill');
            theme_icon.classList.remove('text-warning');
            theme_icon.classList.add('bi-moon-fill');
            theme_icon.classList.add('text-black');
        }
    }

});