const API_URL_RECETAS = 'http://localhost/PHP/PHP_PROYECTO/php/controllers/recetas.php';
const API_URL_TIPOS = 'http://localhost/PHP/PHP_PROYECTO/php/controllers/tipos.php';
const API_URL_ALERGENOS = 'http://localhost/PHP/PHP_PROYECTO/php/controllers/alergenos.php';
const errorElement = document.getElementById('createError');

let listaTipos = []
let listaAlergenos = []

/**
 * 
 * @param {*} str string
 * @returns string limpio de caracteres html
 * Limpia una cadena de texto convirtiendo ciertos carácteres potencialmente peligrosos en sus equivalentes html seguros
 * [^...] coincide con cualquier carácter que no esté en el conjunto
 * \w Carácteres de palabra, letras, números, guión bajo
 * . @- Admite puntos, espacios, arrobas y guiones medios
 * /gi Flags o banderas para que la búsqueda de carácteres sea global (g) e insensible a mayúsculas y minúsculas (i)
 * 
 * function(c){return '&#' + caches.charCodeAt(0) + ';';} crea para cualquier caracter su código ASCII con charCodeAt()
 * Devuelve la entidad HTML numércia corresponiente, por ejemplo: &#60; para <
 * Esta función se utiliza para prevenir ataques XSS(Cross-Site-Scripting)
 */
function limpiarHTML(str){
    return str.replace(/[^\w. @-]/gi, function(e){
        return '&#' + e.charCodeAt(0) + ';';
    });
}

function validaciones(titulo, descripcion, comensales, preparacion, cocinar, temperatura, ingredientes, pasos){
    let errores = [];

    if(titulo.length <= 2 || titulo.length >= 50){
        errores.push('El titulo debe tener entre 2 y 50 caracteres.');
    }
    
    if(descripcion.length <= 2 || descripcion.length >= 250){
        errores.push('La descripción debe tener entre 2 y 250 caracteres.');
    }
    
    if(comensales.length <= 2 || comensales.length >= 12){
        errores.push('Los comensales deben tener entre 2 y 12 caracteres.');
    }
    
    if(preparacion.length <= 2 || preparacion.length >= 11){
        errores.push('La preparacion debe tener entre 2 y 11 caracteres.');
    }
    
    if(cocinar.length <= 2 || cocinar.length >= 11){
        errores.push('El tiempo de cocina debe tener entre 2 y 11 caracteres.');
    }
    
    if(temperatura.length <= 2 || temperatura.length >= 7){
        errores.push('La temperatura debe tener entre 2 y 7 caracteres.');
    }
    
    if(ingredientes.length <= 2 || ingredientes.length >= 500){
        errores.push('Los ingredientes deben tener entre 2 y 500 caracteres.');
    }
    
    if(pasos.length <= 2 || pasos.length >= 6500){
        errores.push('Los pasos deben tener entre 2 y 6500 caracteres.');
    }
    
    return errores;
}

function esEntero(str){
    return /^\d+$/.test(str);
}

function mostrarSelectTipo(listaTipos, selectTipo){
    selectTipo.innerHTML = '';
    listaTipos.forEach(tipo => {
        const sanitizedNombre = limpiarHTML(tipo.nombre);
        selectTipo.innerHTML += `
            <option value="${tipo.id}">${sanitizedNombre}</option>
        `
    });
}

function getTipos(){
    fetch(API_URL_TIPOS)
        .then(response => response.json())
        .then(tipos => {
            listaTipos = tipos
            console.log(tipos)
            getRecetas()
            const selectTipo = document.querySelector('#selectTipo')
            mostrarSelectTipo(listaTipos, selectTipo);
        })
        .catch(error => console.log('Error:', error))
}


// FALTA GET ALERGENOS!!


function getRecetas(){
    fetch(API_URL_RECETAS)
        .then(response => response.json())
        .then(recetas => {
            const tableBody = document.querySelector('#recetasTable tbody')
            tableBody.innerHTML = ''
            console.log(recetas)
            recetas.forEach(receta => {
                const sanitizedNombre = limpiarHTML(receta.nombre)
                const sanitizedDescripcion = (receta.descripcion == null)? ' ' : limpiarHTML(receta.descripcion)
                const sanitizedComensales = limpiarHTML(receta.comensales)
                const sanitizedPreparacion = limpiarHTML(receta.preparacion)
                const sanitizedCocinar = limpiarHTML(receta.cocinar)
            // PARA EVITAR CAMPOR NULOS Y QUE SE MUESTREN TODAS LAS RECETAS UTILIZAR EL SIGUIENTE CODIGO
                const sanitizedTemperatura = (receta.temperatura == null)? ' ' : limpiarHTML(receta.temperatura)
                const sanitizedIngredientes = limpiarHTML(receta.ingredientes)
                const sanitizedPasos = limpiarHTML(receta.pasos)
                const tipoSeleccionado = listaTipos.find(tipo => tipo.id == receta.id_tipo)

                let optionsHTML = ''

                listaTipos.forEach(tipo => {
                    const sanitizedNombre = limpiarHTML(tipo.nombre)

                    optionsHTML += `
                        <option value= "${tipo.id}"
                            ${(tipo.id == tipoSeleccionado)? 'selected' : ' '}>
                                ${sanitizedNombre}
                        </option>
                    `
                })

                tableBody.innerHTML += `
                    <tr data-id="${receta.id}" class="view-mode">
                        <td>
                            ${receta.id}
                        </td>
                        <td>
                            <span class="listado">${tipoSeleccionado.nombre}</span>
                            <select class="edicion">${optionsHTML}</select>
                        </td>
                        <td>
                            <span class="listado">${sanitizedNombre}</span>
                            <input class="edicion" type="text" value="${sanitizedNombre}">
                        </td>
                        <td>
                            <span class="listado">${sanitizedDescripcion}</span>
                            <textarea class="edicion">${sanitizedDescripcion}</textarea>
                        </td>
                        <td>
                            <span class="listado">${sanitizedComensales}</span>
                            <input class="edicion" type="text" value="${sanitizedComensales}">
                        </td>
                        <td>
                            <span class="listado">${sanitizedPreparacion}</span>
                            <input class="edicion" type="text" value="${sanitizedPreparacion}">
                        </td>
                        <td>
                            <span class="listado">${sanitizedCocinar}</span>
                            <input class="edicion" type="text" value="${sanitizedCocinar}">
                        </td>
                        <td>
                            <span class="listado">${sanitizedTemperatura}</span>
                            <input class="edicion" type="text" value="${sanitizedTemperatura}">
                        </td>
                        <td>
                            <span class="listado">${sanitizedIngredientes}</span>
                            <textarea class="edicion">${sanitizedIngredientes}</textarea>
                        </td>
                        <td>
                            <span class="listado">${sanitizedPasos}</span>
                            <textarea class="edicion">${sanitizedPasos}</textarea>
                        </td>
                        <td class="td-btn">
                            <button class="listado" onclick="editMode(${receta.id})">Editar</button>
                            <button class="listado" onclick="deleteReceta(${receta.id})">Eliminar</button>
                            <button class="edicion" onclick="updateReceta(${receta.id})">Guardar</button>
                            <button class="edicion" onclick="cancelEdit(${receta.id})">Cancelar</button>
                        </td>
                    </tr>
                `
            });
        })
        .catch(error => console.log('Error:', error))
}



// TAS QUEDAO POR AQUI



// // CREAR RECETAS
// function createReceta(event){
//     event.preventDefault();
//     const titulo = document.getElementById('createTitulo').value.trim();
//     const precio = document.getElementById('createPrecio').value.trim();
//     const id_director = document.getElementById('createDirector').value.trim();

//     let erroresValidaciones = validaciones(titulo, precio, id_director);
    
//     if(erroresValidaciones.length > 0){
//         mostrarErrores(erroresValidaciones);
//         return;
//     }

//     errorElement.textContent = '';

//     // Envio al comprobdor los datos
//     fetch(API_URL_PELICULAS, {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//         },
//         body: JSON.stringify({titulo, precio, id_director})
//     })
//     .then(response => response.json())
//     .then(result => {
//         console.log('Pelicula creada: ', result);
//         if(!parseInt(result['id'])){
//             erroresApi = Object.values(result['id']);
//             console.log("erroresApi:",  erroresApi);
//             mostrarErrores(erroresApi);
//         }else{
//             getRecetas();
//         }

//         event.target.reset();
//     })
//     .catch(error => {
//         console.log('Error: ', JSON.stringify(error));
//     })
// }

// // GUARDAR NUEVOS DATOS DE RECETA
// function updateReceta(id){
//     // Seleccionamos la fila que queremos editar
//     const row = document.querySelector(`tr[data-id="${id}"]`)
//     const newTitulo = row.querySelector('td:nth-child(2) input').value.trim()
//     const newPrecio = row.querySelector('td:nth-child(3) input').value.trim()
//     const newIdDirector = row.querySelector('td:nth-child(4) select').value.trim()

//     let erroresValidaciones = validaciones(newTitulo, newPrecio, newIdDirector);
//     if(erroresValidaciones.length > 0){
//         mostrarErrores(erroresValidaciones);
//         return;
//     }
//     errorElement.innerHTML = '';

//     fetch(`${API_URL_PELICULAS}?id=${id}`, {
//         method: 'PUT',
//         headers: {
//             'Content-Type': 'application/json',
//         },
//         body: JSON.stringify({titulo: newTitulo, precio: newPrecio, id_director: newIdDirector})
//     })
//     .then(response => response.json())
//     .then(result => {
//         console.log('Película actualizada: ', result)
//         if(!esEntero(result['affected'])){
//             erroresApi = Object.values(result['affected']);
//             mostrarErrores(erroresApi);
//         }else{
//             getRecetas();
//         }
//     })
//     .catch(error => {
//         console.log('Error: ', error)
//         alert("Error al actualizar la película. Por favor intentelo de nuevo")
//     })
// }

// function mostrarErrores(errores){
//     errorElement.innerHTML = '<ul>';
//     errores.forEach(error => {
//         return errorElement.innerHTML += `<li>${error}</li>`;
//     })
//     errorElement.innerHTML += '</ul>';
// }

// // EDITAR CAMPOS
// function editMode(id){
//     errorElement.innerHTML = '';
//     // Seleccionamos la fila que queremos editar
//     const row = document.querySelector(`tr[data-id="${id}"]`)
//     // Cambiamos el estilo y la visibilidad de la fila
//     row.querySelectorAll('.edicion').forEach(ro => {
//         ro.style.display = 'inline-block'
//     })

//     row.querySelectorAll('.listado').forEach(ro =>{
//         ro.style.display = 'none'
//     })
// }

// // CANCELAR EDICION
// function cancelEdit(id){
//     errorElement.innerHTML = '';
//     // Seleccionamos la fila que queremos editar
//     const row = document.querySelector(`tr[data-id="${id}"]`)
//     // Cambiamos el estilo y la visibilidad de la fila
//     row.querySelectorAll('.edicion').forEach(ro => {
//         ro.style.display = 'none'
//     })

//     row.querySelectorAll('.listado').forEach(ro =>{
//         ro.style.display = 'inline-block'
//     })
// }

// // ELIMINAR RECETAS
// function deleteReceta(id){
//     if(confirm('¿Estas seguro de que quieres eliminar esta pelicula?')){
//         fetch(`${API_URL_PELICULAS}?id=${id}`, {
//             method: 'DELETE',
//         })
//         .then(response => response.json())
//         .then(result => {
//             console.log('Usuario eliminado: ', result)
//             getRecetas()
//         })
//         .catch(error => {
//             console.log('Error: ', error)
//         })
//     }
// }

// document.getElementById('createForm').addEventListener('submit', createReceta)

// DOMContentLoaded -> Cuando el documento se ha cargado por completo llama a la funcion
document.addEventListener('DOMContentLoaded', getTipos)