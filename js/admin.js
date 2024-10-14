let botones_eliminar = document.querySelectorAll('.btn-eliminar');
let botones_modificar = document.querySelectorAll('.btn_modificar');

botones_eliminar.forEach(boton => {
    boton.addEventListener('click', event => {
        let botonSeleccionado = event.currentTarget;
        let id = botonSeleccionado.getAttribute('data-id');
        let titulo = botonSeleccionado.getAttribute('data-titulo');

        if(confirm(`¿Seguro que quieres eliminar la película ${titulo}?`)){
            
            fetch('includes/control_peliculas.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + id + '&metodo=delete'
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    alert('Registro eliminado');
                    //eliminar fila de la tabla
                    const fila = document.getElementById(`fila-${id}`);
                    if(fila){
                        fila.remove();
                        //alert('fila  eliminada');
                    }
                }else{
                    alert('Error al eliminar: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error: '+ error);
                alert('Ocurrió un error al eliminar')
            })

        }
    })
});

botones_modificar.forEach(boton => {
    boton.addEventListener('click', event => {
        let botonSeleccionado = event.currentTarget;
        let id = botonSeleccionado.getAttribute('data-id');
        
        //formulario dinamico
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'includes/control_peliculas.php';

        const campoId = document.createElement('input');
        campoId.type = 'hidden';
        campoId.name = 'IDPelicula';
        campoId.value = id;
        form.appendChild(campoId);

        const campoMetodo = document.createElement('input');
        campoMetodo.type = 'hidden';
        campoMetodo.name = 'metodo';
        campoMetodo.value = 'modificar';
        form.appendChild(campoMetodo);

        document.body.appendChild(form);
        form.submit();
    })
})