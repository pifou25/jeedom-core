# Editor de masas

**Configuración → Sistema → Configuración | OS / DB**

Esta herramienta le permite editar una gran cantidad de equipos, comandos, objetos o escenarios. Es completamente genérico y utiliza automáticamente el esquema y la estructura de la base de datos de Jeedom. Por lo tanto, admite complementos y la configuración de sus equipos.

> **Atención**
>
> Si esta herramienta es bastante fácil de usar, está destinada a usuarios avanzados. De hecho, es muy simple cambiar cualquier parámetro en docenas de dispositivos o cientos de comandos y, por lo tanto, hacer que ciertas funciones no funcionen, ver incluso el Core.

## Utilisation

La parte _Filtrado_ le permite seleccionar lo que desea editar, luego agregar filtros de selección de acuerdo con sus parámetros. Un botón de prueba permite, sin ninguna modificación, mostrarle los elementos seleccionados por los filtros ingresados.

La parte _Edición_ le permite cambiar los parámetros de estos elementos.

- **Columna** : Configuración.
- **Valor** : El valor del parámetro.
- **Valor json** : La propiedad del parámetro / valor si es de tipo json (clave-> valor).

### Exemples:

#### Cambiar el nombre de un grupo de escenarios

- En el juego _Filtrado_, Seleccione **Guión**.
- Haga clic en el botón **+** para agregar un filtro.
- En este filtro, seleccione la columna _grupo_, y resalte el nombre del grupo para cambiar el nombre.
- Haga clic en el botón _Prueba_ para mostrar los escenarios de este grupo.
- En el juego _Edición_, seleccionar columna _grupo_, luego pon el nombre que quieras en el valor.
- Haga clic en **Ejecutar** arriba a la derecha.

#### Hacer invisible todo el equipamiento de un objeto / habitación:

- En el juego _Filtrado_, Seleccione **Equipo**.
- Haga clic en el botón **+** para agregar un filtro.
- En este filtro, seleccione la columna _id_objeto_, y en valor la identificación del objeto en cuestión (visible desde Herramientas / Objetos, Descripción general).
- Haga clic en el botón _Prueba_ para mostrar los escenarios de este grupo.
- En el juego _Edición_, seleccionar columna _es visible_, luego ingrese el valor 0.
- Haga clic en **Ejecutar** arriba a la derecha.
