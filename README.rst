UploadExcelBundle
==========

Bundle para facilitar la lectura de archivos excel subidos por el usuario, permite que el usuario nos indique cuales columnas del excel  representan las columnas que necesitamos para procesar el mismo, además las filas del mismo serán validadas al procesar la data segun las especificaciones asignadas al modelo que define una fila del excel.

Ejemplo de Uso
--------------

Creamos la clase que representará una fila del excel (puede ser una entidad, ó cualquier clase php):

.. code-block:: php

    <?php

    namespace MyBundle;

    use UploadExcelBundle\ExcelRow;

    class Persona extends ExcelRow //nuestra clase debe extender de ExcelRow ó implementar ExcelRowInterface
    {
        protected $nombres;
        protected $edad;
        protected $email;

        public function setNombres($nombres){ $this->nombres = $nombres; }
        public function setEdad($edad){ $this->edad = $edad; }
        public function setEmail($email){ $this->email = $email; }
        public function getNombres(){ return $this->nombres; }
        public function getEdad(){ $this->edad; }
        public function getEmail(){ $this->email; }
    }

Ya tenemos nuestra clase que representa una fila del excel creada, ahora procedemos a crear nuestra clase de configuración para la lectura del excel, que deberá extender de UploadExcelBundle\\Config\\Config ó implementar UploadExcelBundle\\Config\\ConfigInterface (Tambien podemos usar directamente la clase UploadExcelBundle\\Config\\Config y setear la configuración en el objeto que creemos).

.. code-block:: php

    <?php

    namespace MyBundle;

    use UploadExcelBundle\Config\Config;

    class MyConfig extends Config
    {
        public function getColumnNames()
        {
            return array();
        }
    }
