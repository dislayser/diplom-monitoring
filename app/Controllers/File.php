<?php
// Функция для проверки файла
function file_check($file, $allowedTypes, $maxSize) {
    // Проверка на наличие ошибок при загрузке файла
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "Ошибка при загрузке файла.";
    }

    // Проверка размера файла
    if ($file['size'] > $maxSize) {
        return "Размер файла превышает допустимый лимит.";
    }

    // Проверка типа файла
    //$fileType = mime_content_type($file['tmp_name']);
    $fileType = $file['type'];
    
    if (!in_array($fileType, $allowedTypes)) {
        return "Недопустимый тип файла.";
    }

    return true;
}

// Функция для генерации уникального имени файла
function file_uniq_name($directory, $originalName) {
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    do {
        $uniqueName = uniqid('', true) . '.' . $extension;
    } while (file_exists($directory . $uniqueName));
    
    return $uniqueName;
}

// Функция для сохранения файла
function file_save($file, $directory) {
    // Генерация уникального имени файла
    $uniqueFileName = file_uniq_name($directory, $file['name']);
    
    // Перемещение файла в указанную директорию
    if (move_uploaded_file($file['tmp_name'], $directory . $uniqueFileName)) {
        return $uniqueFileName;
    } else {
        return "Ошибка при сохранении файла.";
    }
}
?>