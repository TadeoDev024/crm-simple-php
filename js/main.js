// js/main.js

document.addEventListener('DOMContentLoaded', () => {
    
    const form = document.getElementById('formNuevoCliente');

    form.addEventListener('submit', async (e) => {
        e.preventDefault(); // 1. Evitamos que el formulario recargue la página

        // 2. Capturamos los datos del formulario
        const formData = new FormData(form);

        try {
            // 3. Enviamos los datos al servidor (PHP)
            const response = await fetch('guardar_cliente.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            // 4. Si el servidor responde 'ok', mostramos SweetAlert
            if (data.status === 'success') {
                Swal.fire({
                    title: '¡Guardado!',
                    text: 'El cliente se ha registrado correctamente.',
                    icon: 'success',
                    confirmButtonColor: '#0d6efd',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload(); // Recargamos para ver el nuevo cliente en la tabla
                    }
                });
                
                // Opcional: Cerrar el modal programáticamente
                // var myModalEl = document.getElementById('modalNuevoCliente');
                // var modal = bootstrap.Modal.getInstance(myModalEl);
                // modal.hide();
                
                form.reset(); // Limpiamos el formulario
            } else {
                // Si hubo error en PHP
                Swal.fire('Error', 'Hubo un problema al guardar: ' + data.message, 'error');
            }

        } catch (error) {
            console.error('Error:', error);
            Swal.fire('Error', 'Error de conexión con el servidor', 'error');
        }
    });
});