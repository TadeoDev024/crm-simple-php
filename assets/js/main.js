// assets/js/main.js

document.addEventListener('DOMContentLoaded', () => {
    
    const form = document.getElementById('formNuevoCliente');
    const btnGuardar = document.getElementById('btnGuardar');

    if(form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // 1. UI: Poner botón en estado de carga
            const textoOriginal = btnGuardar.innerText;
            btnGuardar.disabled = true;
            btnGuardar.innerText = 'Guardando...';

            const formData = new FormData(form);

            try {
                // 2. Enviar a la API (Nota la ruta relativa)
                const response = await fetch('api/guardar_cliente.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.status === 'success') {
                    Swal.fire({
                        title: '¡Guardado!',
                        text: 'Cliente registrado con éxito',
                        icon: 'success',
                        confirmButtonColor: '#0d6efd'
                    }).then(() => {
                        window.location.reload();
                    });
                    
                    form.reset();
                    // Cerrar modal (opcional, ya que recargamos la página)
                } else {
                    Swal.fire('Error', data.message || 'Error desconocido', 'error');
                }

            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'Fallo de conexión con el servidor', 'error');
            } finally {
                // 3. UI: Restaurar botón (por si hubo error y no recargamos)
                btnGuardar.disabled = false;
                btnGuardar.innerText = textoOriginal;
            }
        });
    }
});