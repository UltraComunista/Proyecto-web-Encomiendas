function confirmarBorrado(idSucursal) {
    Swal.fire({
        title: '¿Estás seguro de borrar la sucursal?',
        text: "No podrás revertir esto",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, borrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Asegúrate de cambiar 'ruta-a-tu-controlador' por la URL correcta que maneja la acción de borrado
            window.location = "sucursales"
        }
    });
}
