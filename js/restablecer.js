// Script para validar que las contraseñas coincidan en el formulario
document.querySelector('form').onsubmit = function(e){
    // Obtener los valores de las contraseñas
    const password = document.querySelector('input[name="nueva_password"]').value
    const confirm = document.querySelector('input[name="confirmar_password"]').value

    // Verificar si las contraseñas coinciden
    if(password !== confirm){
        alert('Las contraseñas no coinciden')
        // Prevenir el envío del formulario
        e.preventDefault()
    }
}