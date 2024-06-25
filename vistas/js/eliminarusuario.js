function confirmarEliminacion(idUsuario) {
    Swal.fire({
        title: "Are you sure?",
        text: "You will not be able to recover this user!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            // Realiza una solicitud AJAX al servidor para eliminar el usuario
            $.ajax({
                url: 'ajax/usuarios.ajax.php',
                method: 'POST',
                data: { 'idUsuario': idUsuario }
            }).done(function(response) {
                if(response == "ok") {
                    Swal.fire("Deleted!", "The user has been deleted.", "success");
                    // Aquí puedes agregar código para actualizar la vista, como recargar la página
                    location.reload();
                } else {
                    Swal.fire("Error!", "The user couldn't be deleted.", "error");
                }
            });
        }
    });
}