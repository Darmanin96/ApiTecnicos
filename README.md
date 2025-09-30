# 🌐 API-Tecnicos: Backend de Gestión de Gastos
Esta API actúa como el backend central para el proyecto de gestión de gastos, sirviendo de puente de datos entre la aplicación móvil (Proyecto-movil) y la plataforma de administración web (TecnicosTabla).

✨ Funcionalidad Principal
La API-Tecnicos proporciona los endpoints necesarios para:

Autenticar y obtener la lista de técnicos.

Registrar nuevos gastos de técnicos.

Consultar todos los registros de gastos.

Eliminar registros de gastos específicos.

🛠️ Estructura de Datos y Endpoints
La API interactúa con la base de datos a través de dos tablas clave: tecnicos y gastos_tecnicos.

1. Gestión de Técnicos (Tabla tecnicos)
Este endpoint se utiliza principalmente para la autenticación y la validación de usuarios en el Proyecto-movil.

Endpoint de Consulta:

GET /api/tecnicos

Descripción: Permite ver el listado completo de técnicos registrados en el sistema.

<img width="1423" height="884" alt="image" src="https://github.com/user-attachments/assets/c60a75e9-da67-48ad-8ce5-d8a855a56694" />

2. Gestión de Gastos (Tabla gastos_tecnicos)
Esta es la funcionalidad central que maneja el registro y la consulta de todos los gastos introducidos por los técnicos.

Consulta de Gastos
Endpoint de Consulta:

GET /api/gastos

Descripción: Retorna todos los registros de gastos, incluyendo detalles como el importe, la fecha, y las rutas a las imágenes asociadas.

<img width="1407" height="920" alt="image" src="https://github.com/user-attachments/assets/22673bd1-1426-4788-b7b2-8a6262393472" />

Eliminación de Gastos
Endpoint de Eliminación:

DELETE /api/gastos/{id}

Descripción: Permite eliminar un registro de gasto específico utilizando su identificador (id). Esta funcionalidad es crucial para la administración en TecnicosTabla.

<img width="1398" height="646" alt="image" src="https://github.com/user-attachments/assets/211d1303-5ac5-4432-8244-288ebfdd54f3" />

Registro de Gastos
Endpoint de Creación:

POST /api/gastos

Descripción: Utilizado por el Proyecto-movil para insertar nuevos registros de gastos, incluyendo el manejo y almacenamiento de las imágenes del ticket y la comida.

🚀 Integración del Proyecto
Esta API enlaza los dos componentes del sistema:

Proyecto	Interacción con la API
Proyecto-movil	Consume el GET /api/tecnicos para autenticar y usa el POST /api/gastos para el envío de nuevos registros.
TecnicosTabla	Consume el GET /api/gastos para poblar la tabla y utiliza el DELETE /api/gastos/{id} para eliminar registros.
