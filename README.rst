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

    * **getColumnNames:** debe devolver un array con los nombres de las columnas que leeremos del excel.
    * **getHeadersPosition (opcional):** debe devolver un array con 2 posiciones, la primera es el nombre de la columna donde se comenzarán a buscar los titulos reales de las columnas del excel y la segunda posicion es la fila donde se buscaran dichos titulos, por defecto si no se reescribe el método se devolverá array('A', 1), es decir, columna 'A' y fila 1 del excel.
    * **getRowClass:** debe devolver una cadena con el nombre de la clase que tendrá el contenido de cada fila del excel ó una instancia de dicha clase.

Ahora vamos a usar las clases creadas en nuestro controlador:

.. code-block:: php
    
    <?php

    use MyBundle\MyConfig;

    ...
    //una acción de algun controlador
    public function uploadAction()
    {
        $config = new MyConfig();

        $config->setFilename("path/to/excel/filename.xls"); //establecemos la ruta y el nombre del excel a leer

        //pasamos la config al método createForm del servicio excel_reader
        //el cual nos devolverá un objeto de tipo Form mediante el cual el usuario hará
        //un match de los campos reales del excel con los campos que especificamos en la clase MyConfig
        $form = $this->get("excel_reader")->createForm($config);

        if($this->getRequest()->isMethod("POST")){ //si el usuario envia el form
            //llamamos al metodo exetute del servicio excel_reader, el cual leerá las filas del excel
            //y por cada fila creará un objeto de tipo Persona y le pasará la data a dicho objeto.
            $result = $this->get("excel_reader")->execute($this->getRequest());
            //toda la data del excel está ahora disponible en el objeto $result, el cual es 
            //una instancia de UploadExcelBundle\Result y podemos acceder a ella mediante los métodos
            //$result->getData(), $result->getValids(), $result->getInvalids(), dichos métodos devuelve un
            //array con las instancias de la clase Persona.
            
            //luego podemos recorrer los array y almacenarlos en la BD por ejemplo.

            foreach($result->getValids() as $numFila => $persona){
                var_dump($persona);
            }
        }

        return $this->render("MyBundle:Controlador:upload.html.twig", array(
            'form' => $form->createView(),
        ));
    }

Nuestra vista quedará de la siguiente manera:

.. code-block:: phtml

    {{ form_widget(form) }} //tendremos una lista de selects con los titulos reales de las columnas del excel
    //cada select tendrá a su izquierda un label con el nombre de la columna que especificamos en la clase Config.
    {{ form_javascript(form) }} //esta función nos permite validar que no seleccionemos la misma columna varias veces, mediante jquery (debemos haberlo agregado con anterioridad)
    {{ form_stylesheet(form) }} //le damos un diseño basico a nuestro formulario
    
Validando Columnas del Excel
------------

Realmente es muy facil validar las columnas de las filas del excel, para ello solo debemos agregar validaciones a los atributos de nuestra clase Persona:

.. code-block:: php

    <?php

    namespace MyBundle;

    use UploadExcelBundle\ExcelRow;
    use Symfony\Component\Validator\Constraints as Assert;

    class Persona extends ExcelRow //nuestra clase debe extender de ExcelRow ó implementar ExcelRowInterface
    {
        /**
         *  @Assert\NotBlank()
         *
         */
        protected $nombres;

        /**
         *  @Assert\NotBlank()
         *  @Assert\Numeric()
         */
        protected $edad;

        /**
         *  @Assert\NotBlank()
         *  @Assert\Email()
         */
        protected $email;

        public function setNombres($nombres){ $this->nombres = $nombres; }
        public function setEdad($edad){ $this->edad = $edad; }
        public function setEmail($email){ $this->email = $email; }
        public function getNombres(){ return $this->nombres; }
        public function getEdad(){ $this->edad; }
        public function getEmail(){ $this->email; }
    }

Como ven es muy facil agregar validaciones para las columnas del excel, cuando el servicio reader_excel nos devuelva el objeto result con la data, si hay data invalida podremos obtenerla mediente el método $result->getInvalids() el cual nos devolverá un array con las filas que contienen data invalida, ademas nuestra clase Persona tiene un método getErrors mediante el cual podemos obtener los errores entontrados.
