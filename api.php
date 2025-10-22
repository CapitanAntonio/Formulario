<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["mensaje" => "No se recibieron datos."]);
    exit;
}

$nombre = $data["nombre"];
$direccion = $data["direccion"];
$consumo = $data["consumo"];
$electrodomesticos = implode(",", $data["electrodomesticos"]);
$energia_renovable = $data["energia_renovable"];
$comentarios = $data["comentarios"];

$conexion = new mysqli("localhost", "root", "", "energiasr2", 3307);
if ($conexion->connect_error) {
    echo json_encode(["mensaje" => "❌ Error en la conexión a la base de datos."]);
    exit;
}

$sql = "INSERT INTO consumo_hogar2 
(nombre, direccion, consumo_kwh, electrodomesticos, energia_renovable, comentarios)
VALUES ('$nombre', '$direccion', '$consumo', '$electrodomesticos', '$energia_renovable', '$comentarios')";

if ($conexion->query($sql)) {
    $sugerencia = "";
    if ($consumo > 500) {
        $sugerencia = "Revisa tus electrodomésticos, apaga luces innecesarias y usa focos LED.";
    } elseif ($consumo > 300) {
        $sugerencia = "Reduce tu consumo apagando aparatos en modo espera y mejora la ventilación natural.";
    } else {
        $sugerencia = "¡Excelente! Tu consumo está dentro del rango eficiente.";
    }

    echo json_encode([
        "mensaje" => "✅ Registro guardado correctamente.",
        "sugerencia" => $sugerencia
    ]);
} else {
    echo json_encode(["mensaje" => "❌ Error al guardar los datos."]);
}

$conexion->close();
?>
