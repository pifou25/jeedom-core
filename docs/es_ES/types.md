# Tipos de equipo

**Herramientas → Tipos de equipos**

Los sensores y actuadores en Jeedom son administrados por complementos, que crean equipos con comandos _Información_ (sensor) o _Valores_ (solenoide). Esto luego permite activar acciones basadas en el cambio de ciertos sensores, como encender una luz en la detección de movimiento. Pero Jeedom Core y complementos como _Móvil_, _Puente de casa_, _Hogar inteligente de Google_, _Hogar inteligente de Alexa_ etc., no sé qué es este equipo : Un enchufe, una luz, una persiana, etc.

Para superar este problema, especialmente con asistentes de voz (_Enciende la luz de la habitación_), Core presentó el **Tipos genéricos**, utilizado por estos complementos.

Esto permite identificar un equipo mediante _La luz de la habitación_ por ejemplo.

La mayoría de las veces, los tipos genéricos se establecen automáticamente al configurar su módulo (inclusión en Z-wave, por ejemplo). Pero puede haber ocasiones en las que necesite reconfigurarlos. La configuración de estos tipos genéricos se puede hacer directamente en ciertos complementos, o mediante comando en _Configuración avanzada_ del mismo.

Esta página permite configurar estos Tipos Genéricos de una forma más directa y sencilla, e incluso ofrece asignación automática una vez que los dispositivos han sido correctamente asignados.

![Tipos de equipo](./images/coreGenerics.gif)

## Tipo de equipo

Esta página ofrece almacenamiento por tipo de equipo : Enchufe, luz, obturador, termostato, cámara, etc. Inicialmente, la mayor parte de su equipo se clasificará en **Equipo sin tipo**. Para asignarles un tipo, puede moverlos a otro tipo o hacer clic con el botón derecho en el equipo para moverlo directamente. El tipo de equipo no es realmente útil en sí mismo, siendo los más importantes los tipos de orden. Por tanto, puede tener un Equipo sin un Tipo, o un Tipo que no se corresponda necesariamente con sus comandos. Por supuesto, puede mezclar tipos de controles dentro del mismo equipo. Por ahora, es más un almacenamiento, una organización lógica, que quizás sirva en futuras versiones.

> **Consejo**
>
> - Cuando mueves equipo en el juego **Equipo sin tipo**, Jeedom sugiere que elimines los tipos genéricos de sus órdenes.
> - Puede mover varios equipos a la vez marcando las casillas de verificación a la izquierda de ellos.

## Tipo de comando

Una vez que un elemento de equipo se coloca en la posición correcta _Tipo_, Pulsando sobre él accedes a la lista de sus pedidos, coloreados de diferente color si es un _Información_ (Azul) o un _Valores_ (Orange).

Al hacer clic con el botón derecho en un pedido, puede asignarle un Tipo genérico correspondiente a las especificaciones de este pedido (Tipo de información / acción, Numérico, Subtipo binario, etc).

> **Consejo**
>
> - El menú contextual de comandos muestra el tipo de equipo en negrita, pero aún permite asignar cualquier tipo genérico de cualquier tipo de equipo.

En cada dispositivo, tienes dos botones :

- **Tipos de auto** : Esta función abre una ventana que le ofrece los tipos genéricos adecuados según el tipo de equipo, los detalles del pedido y su nombre. Luego puede ajustar las propuestas y desmarcar la aplicación para ciertos comandos antes de aceptar o no. Esta función es compatible con la selección mediante casillas de verificación.

- **Tipos de reinicio** : Esta función elimina los tipos genéricos de todos los comandos del equipo.

> **Atención**
>
> No se realizan cambios antes de guardar, con el botón en la parte superior derecha de la página.

## Tipos y escenarios genéricos

En v4.2, el Core ha integrado los tipos genéricos en los escenarios. De esta forma se puede desencadenar un escenario si se enciende una lámpara en una habitación, si se detecta movimiento en la casa, apagar todas las luces o cerrar todas las persianas con una sola acción, etc. Además, si agrega un equipo, solo debe indicar los tipos correctos en sus pedidos, no será necesario editar dichos escenarios.

#### Desencadenar

Puede activar un escenario desde sensores. Por ejemplo, si tiene detectores de movimiento en la casa, puede crear un escenario de alarma con cada detector activado : ''#[Salón][Move Salon][Presence]# == 1`, `#[Cuisine][Move Cuisine][Presence]# == 1`, etc.. En tal escenario, necesitará todos sus detectores de movimiento, y si agrega uno, tendrá que agregarlo a los disparadores. Lógica.

Los tipos genéricos le permiten usar un solo disparador : ''#genericType(PRESENCE)# == 1`. Aquí, no se indica ningún objeto, por lo que el más mínimo movimiento en toda la casa desencadenará el escenario. Si agrega un nuevo detector en la casa, no es necesario editar los escenarios).

Aquí, un disparador al encender una luz en la sala de estar : ''#genericType(LUZ_ESTADO,#[Salón]#)# > 0`

#### Expression

Si, en un escenario, desea saber si hay una luz encendida en la sala de estar, puede hacer :

SI `#[Salón][Lumiere Canapé][Estado]# == 1 O #[Salón][Lumiere Salon][Estado]# == 1 O #[Salón][Lumiere Angle][Estado]# == 1`

O mas simplemente : IF `genericType (LIGHT_STATE,#[Salón]#) > 0` o si una o más luces están encendidas en la sala de estar.

Si mañana añades luz en tu salón, no es necesario que retoques tus escenarios !

#### Action

Si desea encender todas las luces en la sala de estar, puede crear una acción de luz:

` ` #[Salón][Lumiere Canapé][Nosotros]# #[Salón][Lumiere Salon][Nosotros]# #[Salón][Lumiere Angle][Nosotros]#
` `

O más simplemente, cree una acción `genericType` con` LIGHT_ON` en` Salon`. Si mañana añades luz en tu salón, no es necesario que retoques tus escenarios !

## Lista de tipos de núcleos genéricos

> **Consejo**
>
> - Puede encontrar esta lista directamente en Jeedom, en esta misma página, con el botón **Listado** arriba a la derecha.

| **Otro (id: Other)** |                                       |             |                   |
| :------------------- | :------------------------------------ | :---------: | :---------------: |
| TEMPORIZADOR         | Temporizador de estado                | Información |      numeric      |
| TIMER_ESTADO         | Estado del temporizador (pausar o no) | Información | binario, numérico |
| ESTABLECER_TIMER     | Temporizador                          |   Valores   |      slider       |
| TIMER_PAUSE          | Pausar temporizador                   |   Valores   |       other       |
| TIMER_RESUME         | Reanudar el temporizador              |   Valores   |       other       |

| **Batería (id: Battery)** |                  |             |         |
| :------------------------ | :--------------- | :---------: | :-----: |
| BATERÍA                   | Batería          | Información | numeric |
| BATERIA CARGANDO          | Bateria cargando | Información | binary  |

| **Cámara (id: Camera)** |                                            |             |        |
| :---------------------- | :----------------------------------------- | :---------: | :----: |
| CÁMARA_URL              | URL de la cámara                           | Información | string |
| CAMERA_RECORD_ESTADO    | Estado de grabación de la cámara           | Información | binary |
| CÁMARA_ARRIBA           | Movimiento de la cámara hacia arriba       |   Valores   | other  |
| CÁMARA HACIA ABAJO      | Movimiento de la cámara hacia abajo        |   Valores   | other  |
| CÁMARA_IZQUIERDA        | Movimiento de la cámara hacia la izquierda |   Valores   | other  |
| CÁMARA_DERECHA          | Movimiento de la cámara hacia la derecha   |   Valores   | other  |
| CÁMARA_ZOOM             | Acercar la cámara hacia adelante           |   Valores   | other  |
| CÁMARA_DEZOOM           | Zoom de la cámara hacia atrás              |   Valores   | other  |
| CÁMARA_DETENER          | Detener la cámara                          |   Valores   | other  |
| CÁMARA_PRESET           | Preajuste de la cámara                     |   Valores   | other  |
| CAMERA_RECORD           | Grabación de cámara                        |   Valores   |
| CÁMARA_TOMAR            | Cámara de instantáneas                     |   Valores   |

| **Calefacción (id: Heating)** |                                                      |             |        |
| :---------------------------- | :--------------------------------------------------- | :---------: | :----: |
| CALEFACCIÓN_ESTADO            | Estado de calentamiento del hilo piloto              | Información | binary |
| CALEFACCIÓN_ENCENDIDO         | Botón de encendido del calentamiento del hilo piloto |   Valores   | other  |
| CALEFACCIÓN_APAGADO           | Botón de apagado del calentamiento del hilo piloto   |   Valores   | other  |
| HEATING_OTHER                 | Botón de hilo piloto de calentamiento                |   Valores   | other  |

| **Electricidad (id: Electricity)** |                       |             |         |
| :--------------------------------- | :-------------------- | :---------: | :-----: |
| Energía                            | Energia electrica     | Información | numeric |
| CONSUMO                            | El consumo de energía | Información | numeric |
| VOLTAJE                            | Tensión               | Información | numeric |
| REINICIAR                          | Reiniciar             |   Valores   |  other  |

| **Entorno (id: Environment)** |                   |             |         |
| :---------------------------- | :---------------- | :---------: | :-----: |
| LA TEMPERATURA                | LA TEMPERATURA    | Información | numeric |
| CALIDAD DEL AIRE              | Calidad del aire  | Información | numeric |
| BRILLO                        | Brillo            | Información | numeric |
| PRESENCIA                     | PRESENCIA         | Información | binary  |
| FUMAR                         | Deteccion de humo | Información | binary  |
| HUMEDAD                       | Humedad           | Información | numeric |
| Ultravioleta                  | Ultravioleta      | Información | numeric |
| CO2                           | CO2 (ppm)         | Información | numeric |
| CO                            | CO2 (ppm)         | Información | numeric |
| RUIDO                         | Sonido (dB)       | Información | numeric |
| PRESIÓN                       | Presión           | Información | numeric |
| GOTERA DE AGUA                | Fuga de agua      | Información |
| FILTRO_LIMPIAR_ESTADO         | Estado de filtro  | Información | binary  |

| **Genérico (id: Generic)** |             |             |                   |
| :------------------------- | :---------- | :---------: | :---------------: |
| PROFUNDIDAD                | Profundidad | Información |      numeric      |
| DISTANCIA                  | DISTANCIA   | Información |      numeric      |
| BOTÓN                      | Botón       | Información | binario, numérico |
| INFORMACIÓN_GENÉRICA       | Genérico    | Información |
| ACCIÓN_GENÉRICA            | Genérico    |   Valores   |       other       |

| **Luz (id: Light)** |                             |             |                   |
| :------------------ | :-------------------------- | :---------: | :---------------: |
| LUZ_ESTADO          | Estado de luz               | Información | binario, numérico |
| LUZ_BRILLO          | Brillo de luz               | Información |      numeric      |
| COLOR CLARO         | Color claro                 | Información |      string       |
| LUZ_ESTADO_BOOL     | Estado de luz (binario)     | Información |      binary       |
| LUZ_COLOR_TEMP      | Color de temperatura de luz | Información |      numeric      |
| LUZ_TOGGLE          | Alternar luz                |   Valores   |       other       |
| LUCES ENCENDIDAS    | Botón de luz encendido      |   Valores   |       other       |
| LUZ APAGADA         | Botón de luz apagado        |   Valores   |       other       |
| LUZ_SLIDER          | Luz deslizante              |   Valores   |      slider       |
| LUZ_SET_COLOR       | Color claro                 |   Valores   |       color       |
| MODO_LUZ            | Modo de luz                 |   Valores   |       other       |
| LUZ_SET_COLOR_TEMP  | Color de temperatura de luz |   Valores   |

| **Modo (id: Mode)** |                |             |        |
| :------------------ | :------------- | :---------: | :----: |
| MODO_ESTADO         | Modo de estado | Información | string |
| MODE_SET_STATE      | Modo de cambio |   Valores   | other  |

| **Multimedia (id: Multimedia)** |              |             |                         |
| :------------------------------ | :----------- | :---------: | :---------------------: |
| Volumen                         | Volumen      | Información |         numeric         |
| MEDIO_ESTADO                    | Estado       | Información |         string          |
| MEDIA_ALBUM                     | Álbum        | Información |         string          |
| ARTISTA_MEDIA                   | Artista      | Información |         string          |
| MEDIO_TITLE                     | Título       | Información |         string          |
| MEDIA_POWER                     | Energía      | Información |         string          |
| CANAL                           | Cadena       | Información |    numérico, cadena     |
| MEDIO_ESTADO                    | Estado       | Información |         binary          |
| SET_VOLUMEN                     | Volumen      |   Valores   |         slider          |
| SET_CHANNEL                     | Cadena       |   Valores   | otro control deslizante |
| MEDIOS_PAUSA                    | Pausa        |   Valores   |          other          |
| MEDIOS_RESUME                   | Lectura      |   Valores   |          other          |
| MEDIA_STOP                      | Deténgase    |   Valores   |          other          |
| MEDIOS_SIGUIENTE                | Próximo      |   Valores   |          other          |
| MEDIOS_ANTERIORES               | Anterior     |   Valores   |          other          |
| MEDIA_ON                        | Nosotros     |   Valores   |          other          |
| MEDIOS_DESACTIVADOS             | Apagado      |   Valores   |          other          |
| MEDIOS_MUTE                     | Silencio     |   Valores   |          other          |
| MEDIA_UNMUTE                    | Sin silencio |   Valores   |          other          |

| **Clima (id: Weather)**  |                                         |             |         |
| :----------------------- | :-------------------------------------- | :---------: | :-----: |
| TIEMPO_TEMPERATURA       | Temperatura del tiempo                  | Información | numeric |
| TIEMPO_TEMPERATURA_MAX_2 | Condición meteorológica d + 1 máx d + 2 | Información | numeric |
| VELOCIDAD DEL VIENTO     | Velocidad del viento)                   | Información | numeric |
| LLUVIA_TOTAL             | Lluvia (acumulación)                    | Información | numeric |
| LLUVIA_ACTUAL            | Lluvia (mm / h)                         | Información | numeric |
| CLIMA_CONDICIÓN_ID_4     | Condición meteorológica (id) d + 4      | Información | numeric |
| CLIMA_CONDICIÓN_4        | Condición meteorológica d + 4           | Información | string  |
| TIEMPO_TEMPERATURA_MAX_4 | Clima Temperatura máxima d + 4          | Información | numeric |
| TIEMPO_TEMPERATURA_MIN_4 | Tiempo Temperatura min d + 4            | Información | numeric |
| CLIMA_CONDICIÓN_ID_3     | Condición meteorológica (id) d + 3      | Información | numeric |
| CLIMA_CONDICIÓN_3        | Condición meteorológica d + 3           | Información | string  |
| TIEMPO_TEMPERATURA_MAX_3 | Clima Temperatura máxima d + 3          | Información | numeric |
| TIEMPO_TEMPERATURA_MIN_3 | Tiempo Temperatura min d + 3            | Información | numeric |
| CLIMA_CONDICIÓN_ID_2     | Condición meteorológica (id) d + 2      | Información | numeric |
| CLIMA_CONDICIÓN_2        | Condición meteorológica d + 2           | Información | string  |
| TIEMPO_TEMPERATURA_MIN_2 | Tiempo Temperatura min d + 2            | Información | numeric |
| CLIMA_HUMEDAD            | Humedad del tiempo                      | Información | numeric |
| CLIMA_CONDICIÓN_ID_1     | Condición meteorológica (id) d + 1      | Información | numeric |
| CLIMA_CONDICIÓN_1        | Condición meteorológica d + 1           | Información | string  |
| CLIMA_TEMPERATURA_MAX_1  | Clima Temperatura máxima d + 1          | Información | numeric |
| TIEMPO_TEMPERATURA_MIN_1 | Clima Temperatura min d + 1             | Información | numeric |
| TIEMPO_CONDICIÓN_ID      | Condición climática (id)                | Información | numeric |
| CONDICIÓN CLIMÁTICA      | Condición climática                     | Información | string  |
| TIEMPO_TEMPERATURA_MAX   | Clima Temperatura máxima                | Información | numeric |
| TIEMPO_TEMPERATURA_MIN   | Clima Temperatura min                   | Información | numeric |
| CLIMA_AMANECER           | Tiempo al atardecer                     | Información | numeric |
| TIEMPO_PUESTA DEL SOL    | Tiempo del amanecer                     | Información | numeric |
| CLIMA_VIENTO_DIRECCIÓN   | Dirección del viento tiempo             | Información | numeric |
| TIEMPO_VIENTO_VELOCIDAD  | Tiempo de velocidad del viento          | Información | numeric |
| CLIMA_PRESIÓN            | Presión meteorológica                   | Información | numeric |
| DIRECCIÓN DEL VIENTO     | Dirección del viento)                   | Información | numeric |

| **Apertura (id: Opening)** |                                         |             |        |
| :------------------------- | :-------------------------------------- | :---------: | :----: |
| BLOQUEO_ESTADO             | Bloqueo de estado                       | Información | binary |
| BARRERA_ESTADO             | Estado del portal (apertura)            | Información | binary |
| GARAJE_ESTADO              | Estado del garaje (apertura)            | Información | binary |
| APERTURA                   | Puerta                                  | Información | binary |
| ABRIENDO_VENTANA           | Ventana                                 | Información | binary |
| BLOQUEAR_ABRIR             | Botón de bloqueo abierto                |   Valores   | other  |
| LOCK_CLOSE                 | Cerrar el botón de bloqueo              |   Valores   | other  |
| GB_OPEN                    | Botón de apertura de puerta o garaje    |   Valores   | other  |
| GB_CLOSE                   | Botón de cierre de puerta o garaje      |   Valores   | other  |
| GB_TOGGLE                  | Interruptor de botón de puerta o garaje |   Valores   | other  |

| **Zócalo (id: Outlet)** |                              |             |                   |
| :---------------------- | :--------------------------- | :---------: | :---------------: |
| ESTADO_ENERGÍA          | Toma de estado               | Información | numérico, binario |
| ENERGÍA_ON              | En el enchufe del botón      |   Valores   |       other       |
| ENERGÍA_APAGADA         | Botón de enchufe desactivado |   Valores   |       other       |
| DESLIZADOR DE ENERGÍA   | Toma deslizante              |   Valores   |

| **Robot (identificación: Robot)** |                      |             |        |
| :-------------------------------- | :------------------- | :---------: | :----: |
| MUELLE_ESTADO                     | Base estatal         | Información | binary |
| MUELLE                            | De regreso a la base |   Valores   | other  |

| **Seguridad (id: Security)** |                           |             |                   |
| :--------------------------- | :------------------------ | :---------: | :---------------: |
| SIREN_ESTADO                 | Estado de la sirena       | Información |      binary       |
| ALARMA_ESTADO                | Estado de alarma          | Información |  binario, cadena  |
| MODO_ALARMA                  | Modo de alarma            | Información |      string       |
| ALARMA_ENABLE_ESTADO         | Estado de alarma activado | Información |      binary       |
| INUNDACIÓN                   | Inundación                | Información |      binary       |
| SABOTAJE                     | SABOTAJE                  | Información |      binary       |
| CHOQUE                       | Choque                    | Información | binario, numérico |
| SIREN_OFF                    | Botón de sirena apagado   |   Valores   |       other       |
| SIREN_EN                     | Botón de sirena encendido |   Valores   |       other       |
| ALARMA_ARMADO                | Alarma armada             |   Valores   |       other       |
| ALARMA_LIBERADA              | Alarma lanzada            |   Valores   |       other       |
| ALARMA_ESTABLECER_MODO       | Modo de alarma            |   Valores   |       other       |

| **Termostato (id: Thermostat)** |                                                                          |             |         |
| :------------------------------ | :----------------------------------------------------------------------- | :---------: | :-----: |
| TERMOSTATO_ESTADO               | Estado del termostato (BINARIO) (solo para termostato de complemento)    | Información |
| TERMOSTATO_TEMPERATURA          | Termostato de temperatura ambiente                                       | Información | numeric |
| TERMOSTATO_CONSIGNA             | Termostato de consigna                                                   | Información | numeric |
| MODO_TERMOSTATO                 | Modo de termostato (solo para termostato de complemento)                 | Información | string  |
| TERMOSTATO_BLOQUEO              | Termostato de bloqueo (solo para termostato de complemento)              | Información | binary  |
| TERMOSTATO_TEMPERATURA_EXTERIOR | Termostato de temperatura exterior (solo para termostato de complemento) | Información | numeric |
| TERMOSTATO_ESTADO_NOMBRE        | Estado del termostato (HUMAN) (solo para termostato de complemento)      | Información | string  |
| TERMOSTATO_HUMEDAD              | Termostato de humedad ambiental                                          | Información | numeric |
| HUMEDAD_CONSIGNA                | Establecer humedad                                                       | Información | slider  |
| TERMOSTATO_SET_SETPOINT         | Termostato de consigna                                                   |   Valores   | slider  |
| TERMOSTATO_FIJAR_MODO           | Modo de termostato (solo para termostato de complemento)                 |   Valores   |  other  |
| TERMOSTATO_SET_LOCK             | Termostato de bloqueo (solo para termostato de complemento)              |   Valores   |  other  |
| TERMOSTATO_SET_UNLOCK           | Desbloquear el termostato (solo para el termostato enchufable))          |   Valores   |  other  |
| HUMEDAD_SET_SETPOINT            | Establecer humedad                                                       |   Valores   | slider  |

| **Ventilador (id: Fan)** |                                       |             |         |
| :----------------------- | :------------------------------------ | :---------: | :-----: |
| FAN_SPEED_STATE          | Estado de la velocidad del ventilador | Información | numeric |
| ROTACIÓN_ESTADO          | Rotación de estado                    | Información | numeric |
| VELOCIDAD DEL VENTILADOR | Velocidad del ventilador              |   Valores   | slider  |
| GIRAR                    | GIRAR                                 |   Valores   | slider  |

| **Panel (id: Shutter)** |                               |             |                   |
| :---------------------- | :---------------------------- | :---------: | :---------------: |
| FLAP_ESTADO             | Panel de estado               | Información | binario, numérico |
| FLAP_BSO_ESTADO         | Panel de estado de BSO        | Información | binario, numérico |
| FLAP_ARRIBA             | Botón de panel hacia arriba   |   Valores   |       other       |
| FLAP_ABAJO              | Botón de panel hacia abajo    |   Valores   |       other       |
| FLAP_DETENER            | Botón de parada del obturador |   Valores   |
| FLAP_SLIDER             | Panel de botones deslizantes  |   Valores   |      slider       |
| FLAP_BSO_ARRIBA         | Botón arriba del panel BSO    |   Valores   |       other       |
| FLAP_BSO_ABAJO          | Botón Abajo del panel BSO     |   Valores   |       other       |
