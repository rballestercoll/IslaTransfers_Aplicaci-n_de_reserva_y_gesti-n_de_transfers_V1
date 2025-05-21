<?php
$url_api = 'http://mi_apache/admin/estadisticas-zonas';

$json = @file_get_contents($url_api);

if ($json === false) {
    echo '<p>Error al obtener los datos desde la API en ' . esc_html($url_api) . '</p>';
    return;
}

$data = json_decode($json, true);

if ($data === null) {
    echo '<p>Error al procesar JSON recibido de la API.</p>';
    return;
}

if (empty($data)) {
    echo '<p>No hay zonas registradas.</p>';
    return;
}

echo '<ul>';
foreach ($data as $zona) {
    echo '<li>' . esc_html($zona['descripcion']) . '</li>';
}
echo '</ul>';
