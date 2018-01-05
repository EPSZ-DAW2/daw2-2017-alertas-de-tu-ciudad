<meta charset="utf-8">
# Scripts de mantenimiento de la Base de Datos
<hr/>
En esta carpeta se tienen los archivos &quot;.sql&quot; necesarios para la creación inicial de la estructura de la base de datos del proyecto, o para realizar actualizaciones parciales/incrementales de esa estructura, ..., según van surgiendo cambios de diseño que obliguen a hacer algún cambio.
<br/>
Opcionalmente se tendrán archivos &quot;.sql&quot; para la importación de datos de prueba, o de datos ya preparados para algunas tablas según necesidades del proyecto.
<hr/>
A la hora de crear un archivo con instrucciones SQL, se deben tener en cuenta ciertas normas:
<ol>
<li>Se debe generar un archivo &quot;.sql&quot; con las órdenes SQL que hacen el cambio o los cambios de estructura, o la carga de datos y ponerlo en esta carpeta del proyecto ([proyecto]/[rama]/sql/).</li>
<li>Como los cambios de estructura en la base de datos que no sean completos deben hacerse en el orden correcto para que no haya errores del propio servidor SQL y la estructura final quede bien, los archivos deben nombrarse siguiendo el patrón &quot;AAAA-MM-DDS_CLASE - INFO.sql&quot;, donde..
  <ul type="none">
  <li>- AAAA= Año (4 digitos) de la fecha de creación del archivo.</li>
  <li>- MM= Mes (2 digitos) de la fecha de creación del archivo.</li>
  <li>- DD= Día (2 digitos) de la fecha de creación del archivo.</li>
  <li>- S= Letra minuscula (1 caracter) indicando la secuencia o el orden de aplicación del fichero dentro de la misma fecha en la que se ha generado. La secuencia empezará en &quot;a&quot; y seguirá con el alfabeto hasta acabar con él (&quot;b&quot;, &quot;c&quot;, ..., &quot;z&quot;). Si hubiera más cambios en la misma fecha que las letras del alfabeto, se añadirá una nueva combinación de la forma &quot;za&quot;, &quot;zb&quot;, ... &quot;zz&quot;, siguiendo con &quot;zza&quot;, &quot;zzb&quot;, ... si hubiera más aún.</li>
  <li>*** Antes de crear el fichero, consultad en el repositorio cual es la última letra existente para la fecha que se va a utilizar por si puede existir ya, y sincronizar cuanto antes el cambio para que esté disponible a todos.</li>
  <li>- CLASE= Un indicador del tipo de cambio, para saber qué va a ocurrir con la base de datos al aplicar el archivo &quot;.sql&quot;. Puede ser uno de estos códigos:
    <ul type="disc" style="font-size:85%;">
    <li><strong>BD</strong>: para borrado y creación de la <strong>estructura completa</strong>, con o sin datos en la tablas. Con esto sabremos que al aplicar el archivo, se nos va a borrar toda la BD entera, sobre todo en los casos en los que ya tenemos datos de prueba propios que habría que conservar o se perderán.</li>
    
    <li><strong>INS</strong>: para cambios de <strong>estructura parcial</strong> que no van a provocar borrados accidentales de datos, o para indicar órdenes de <strong>inserción de datos</strong> a las tablas existentes. Serán aquellos cambios de estructura típicos para agregar campos nuevos, cambiar tipos de dato que no destruyen los datos contenidos o ampliar longitudes de campos que no hacen perder su contenido, o instrucciones de inserción de datos en las tablas.</li>
    
    <li><strong>DEL</strong>: para cambios de <strong>estructura parcial</strong> que van a provocar borrados de datos, o para indicar órdenes de <strong>eliminación de datos</strong>. Serán aquellos cambios de estructura típicos para eliminar campos innecesarios, cambiar tipos de dato que destruye el dato contenido, reducir longitudes de campos que hacen perder parte de su contenido, o instrucciones de eliminación de datos en las tablas.</li>
    
    <li><strong>UPD</strong>: para cambios de <strong>estructura parcial</strong> que no van a provocar borrados accidentales de datos, o para indicar órdenes de <strong>actualización de datos</strong> en las tablas existentes los cuales pueden destruir algunos datos por su modificación. Serán aquellos cambios de estructura típicos para agregar campos nuevos, cambiar tipos de dato o longitudes que no afecten al posible dato que contenga. También se utilizará para incluir órdenes SQL que actualizan datos o modifican los existentes.</li>
    </ul>
    <strong>***</strong> Lo más recomendable es hacer que los archivos &quot;.sql&quot; sean lo más sencillos posible, incluyendo SÓLO las órdenes necesarias para hacer los cambios mínimos, a excepción, claro está, de los cambios de BD completos.
  </li>
  <li>- INFO= Texto indicando el motivo del cambio que se va a realizar, NO VALE algo como &quot;cambios en la base de datos&quot;, &quot;actualizacion&quot;, o similar. Algo más coherente sería... &quot;nuevo campo C en tabla T&quot;, o &quot;renombrar tabla T&quot;, o &quot;adaptar datos de C en T y reducir su tamaño&quot;, ...</li>
  </ul> 
</li>
</ol>
