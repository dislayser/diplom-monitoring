$('tbody').ready(function() {
    $('tbody tr').click(function() {
        // Проверяем наличие атрибута data-not-link в дочерних элементах td
        if (!$(event.target).closest('td[data-not-link]').length) {
            window.location = $(this).data('href');
        }
    });
});