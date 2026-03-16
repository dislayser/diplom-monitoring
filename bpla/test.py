import requests

url = "https://gastrack.opfobos.ru/api/post/gasData"  # Замените на нужный URL
file_path = "/var/www/gastrack.opfobos.ru/bpla/img/1.png"  # Замените на путь к вашему файлу

# Заголовки, если они требуются API
headers = {
    'Content-Type': 'multipart/form-data'
}

try:
    with open(file_path, 'rb') as file:
        files = {'file': file}
        response = requests.post(url, headers=headers, files=files)

    if response.status_code == 200:
        print("Файл успешно отправлен!")
    else:
        print(f"Ошибка при отправке файла: {response.status_code}")
        print(response.text)
except FileNotFoundError:
    print("Файл не найден. Проверьте путь.")
except Exception as e:
    print(f"Произошла ошибка: {e}")
