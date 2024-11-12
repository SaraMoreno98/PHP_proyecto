# Sistema de Recetas Sin Gluten

## Descripción del proyecto

El proyecto consiste en una plataforma web para la gestión y visualización de recetas sin gluten. Incluye un sistema de autenticación de usuarios y un panel de administración.

## Tecnologías utilizadas

- **Frontend**: HTML, JavaScript, CSS
- **Backend**: PHP
- **Base de datos**: MySQL

## Funcionalidades principales

- **Visualización de recetas**:
  - Categorización por tipos de comida (desayuno, almuerzo, cena, etc.)
  - Sistema de filtrado dinámico
  - Vista modal para detalles de recetas
- **Sistema de autenticación**:
  - Inicio de sesión con email y contraseña
  - Registro de nuevos usuarios
  - Recuperación de contraseña
  - Verificación de cuentas por email
- **Gestión de recetas**:
  - Funcionalidades CRUD completas
  - Validación de datos
  - Gestión de alérgenos
  - Manejo de imágenes
  - Filtrado por tipos

## Estructura del proyecto

El proyecto se divide en dos partes principales:

1. **Frontend**:
   - `index.php`: Página principal de visualización de recetas
   - `login.php`: Sistema de autenticación de usuarios
   - `close_session.php`: Gestión de cierre de sesión
   - `restablecer.php`: Restablecimiento de contraseña
   - `verificar.php`: Verificación de cuentas de usuario
   - `adminRecetas.php`: Administración para la gestión de recetas
   - `css/`: Archivos CSS
   - `js/`: Archivos JavaScript

2. **Backend**:
   - `controllers/`: Controladores de la API REST
   - `data/`: Clases de gestión de datos

## Instalación y uso

1. Clonar el repositorio:
   ```
   git clone https://github.com/SaraMoreno98/recetas-sin-gluten.git
   ```
2. Configurar la conexión a la base de datos en `data/config.php`.
3. Importar la estructura de la base de datos.
4. Ejecutar el proyecto en un servidor web.

## Documentación

Puedes encontrar la documentación técnica detallada en el archivo [documentacionProyecto_SaraMorenoOntiveros.pdf](documentacionProyecto_SaraMorenoOntiveros.pdf).

## Contacto y soporte

- GitHub: [@SaraMoreno98](https://github.com/SaraMoreno98)
- LinkedIn: [sara-moreno-ontiveros](https://es.linkedin.com/in/sara-moreno-ontiveros)
- Instagram: [@saramo_graphic](https://www.instagram.com/saramo_graphic/)
