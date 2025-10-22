document.getElementById("formConsumo").addEventListener("submit", function(e) {
    e.preventDefault();

    const electrodomesticosSeleccionados = Array.from(
        document.querySelectorAll('input[name="electrodomesticos"]:checked')
    ).map(el => el.value);

    const data = {
        nombre: document.getElementById("nombre").value,
        direccion: document.getElementById("direccion").value,
        consumo: parseInt(document.getElementById("consumo").value),
        electrodomesticos: electrodomesticosSeleccionados,
        energia_renovable: document.querySelector('input[name="energia_renovable"]:checked').value,
        comentarios: document.getElementById("comentarios").value
    };

    fetch("api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(respuesta => {
        document.getElementById("resultado").innerHTML = respuesta.mensaje + "<br>" + (respuesta.sugerencia || "");
    })
    .catch(error => {
        document.getElementById("resultado").innerHTML = "❌ Error al conectar con el servidor.";
        console.error("Error:", error);
    });
});
