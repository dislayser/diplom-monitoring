$(document).ready(function() {
    // Graphs
    var ctx_gasdata = document.getElementById('chart_gasdata');
    
    //Подготовка данных для диаграммы
    let gasdata_chart_labels = [];
    let gasdata_chart_data_total = [];

    //Интервал в дате
    function get_interval(interval = 7) {
        let currentDate = new Date();
        let dateArray = [];
    
        for (let i = 0; i <= interval; i++) {
            let day = currentDate.getDate();
            let month = currentDate.getMonth() + 1; // Месяцы в JavaScript начинаются с 0
            let year = currentDate.getFullYear();
    
            day = day < 10 ? '0' + day : day;
            month = month < 10 ? '0' + month : month;
    
            let formattedDate = `${day}.${month}.${year}`;
            dateArray.push(formattedDate);
    
            currentDate.setDate(currentDate.getDate() - 1);
        }
    
        return dateArray.reverse();
    }
    
    // DATA
    data_gasdata = get_interval(interval_gasdata).map(date => {
        let gasdata = data_gasdata.find(item => item.date === date);
        return gasdata || { date, total_gasdata: "0"};
    });

    //Парсинг данных
    for (let i = 0; i < data_gasdata.length; i++){
        let gasdata = data_gasdata[i];
        gasdata_chart_labels.push(gasdata.date);
        gasdata_chart_data_total.push(gasdata.total_gasdata);
    }


    //градиент
    ctx_gasdata = ctx_gasdata.getContext('2d');
    var gradient = ctx_gasdata.createLinearGradient(0, 0, 0, 600);
    gradient.addColorStop(0, '#007bffaa');
    gradient.addColorStop(1, 'transparent');

    // Options
    const options = {
        
            animations: {
                tension: {
                    easing: 'linear',
                    to: 0.4,
                    loop: false
                }
            },
            scales: {
                y:{
                    beginAtZero: true,
                    ticks: {stepSize: 1}
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    boxPadding: 3
                }
            }
        
    };
    

    // gasdata
    const chart_gasdata = new Chart(ctx_gasdata, {
        type: 'line',
        data: {
            labels: gasdata_chart_labels,
            datasets: [
                {
                    label: 'Всего',
                    data: gasdata_chart_data_total,
                    lineTension: 0,
                    backgroundColor: gradient,
                    borderColor: '#007bff',
                    borderWidth: 1,
                    fill: true,
                    pointBackgroundColor: '#007bff'
                },
            ]
        },
        options
    });
    
});