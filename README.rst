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

Ya tenemos nuestra clase que representa una fila del excel creada, ahora procedemos a crear nuestra clase de configuración para la lectura del excel, que deberá extender de UploadExcelBundle\\Config\\AbstractConfig ó implementar UploadExcelBundle\\Config\\ConfigInterface (Tambien podemos usar directamente la clase UploadExcelBundle\\Config\\Config y setear la configuración en el objeto que creemos).

.. code-block:: php

    <?php

    namespace MyBundle;

    use UploadExcelBundle\Config\AbstractConfig;

    class MyConfig extends AbstractConfig
    {
        public function getColumnNames()
        {
            //los nombres de las columnas deben coincidir con los nombres de los
            //atributos de la clase que representará las filas
            return array("nombres", "edad", "email");
        }

        public function getHeadersPosition()
        {
            //por defecto de no reescribir el método retorna array('A', 1)
            return array('B', 2);
        }

        public function getRowClass()
        {
            return "MyBundle\Persona"; //retornamos la clase que acabamos de crear
        }
    }

Nuestra clase debe implementar tres métodos:

    * getColumnNames: debe devolver un array con los nombres de las columnas que leeremos del excel.
    * getHeadersPosition (opcional): debe devolver un array con 2 posiciones, la primera es el nombre de la columna donde se comenzarán a buscar los titulos reales de las columnas del excel y la segunda posicion es la fila donde se buscaran dichos titulos, por defecto si no se reescribe el método se devolverá array('A', 1), es decir, columna 'A' y fila 1 del excel.
    * getRowClass: debe devolver una cadena con el nombre de la clase que tendrá el contenido de cada fila del excel ó una instancia de dicha clase.