import config
import time
import requests
import json
import random
import noise

# Полный API URL
URL = config.api_url + config.api_url_path

def rand_num(min_value, max_value):
    return round(random.uniform(min_value, max_value), 2)

def rand_data(matrix_data):
    # Инициализация пустой матрицы данных
    data = {}

    # Проходим по всем столбцам матрицы
    for i in range(matrix_data['x']):
        if [i, -1] in matrix_data['miss']:
            continue
        data[str(i)] = {}

        # Проходим по всем строкам матрицы
        for j in range(matrix_data['y']):
            # Проверяем, если текущая ячейка должна быть пропущена
            if [i, j] in matrix_data['miss'] or [-1, j] in matrix_data['miss']:
                continue

            # Инициализация пустого словаря для текущей ячейки
            data[str(i)][str(j)] = {}

            # Заполнение данных для каждого типа газа
            for key, radius, initial_value in matrix_data['keys']:
                # Генерация шума Перлина в диапазоне от -1 до 1
                # Можно менять занчение lacunarity для небольшой рандомизации
                perlin_noise = noise.pnoise2(i * 0.1, j * 0.1, octaves=1, persistence=64, lacunarity=10, repeatx=1024, repeaty=1024, base=len(key))
                # Масштабируем шум в заданный диапазон
                value = initial_value + radius * perlin_noise
                # Округление до двух знаков после запятой
                value = round(value, 2)
                # Добавление данных в текущую ячейку
                data[str(i)][str(j)][key] = value

    return json.dumps(data)

# Параметры для генерации данных
matrix_params = {
    'x': 19,
    'y': 9,
    'keys': [
        ['Temp', 7, 20],
        ['SO2', 10, 22],
        ['CO', 3, 4.5],
        ['O3', 3, 5],
        ['PM10', 20, 50],
        ['PM25', 10, 25],
        ['Test', 100, 50],
    ],
    'miss': [
        [-1, 0],
        [0, -1],
    ]
}

# Отправка запроса 
def post(data):
    response = requests.post(URL, data=data)
    if response.status_code == 200:
        return 'Ответ от API: ', response.text
    else:
        print('Произошла ошибка при отправке запроса:', response.text)

def main():
    print('Скрипт с генерацией данный по газам запущен:')
    print('Интервал между запросами: ', config.gen_interval, 'сек.')

    while (True):           
        data = {
            "id" : config.device_id,
            "api_token" : config.device_token,
            "data" : rand_data(matrix_params)
        }

        # Записывает резальтат выволнения запроса и выводим
        result = post(data=data)
        print(result)

        #Задаем интервал
        time.sleep(config.gen_interval)

# Автозапуск
if __name__ == "__main__":
    main()