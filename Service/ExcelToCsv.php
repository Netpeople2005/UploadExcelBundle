<?php

namespace K2\UploadExcelBundle\Service;

use Symfony\Component\Process\ProcessBuilder;

/**
 * Description of ExcelToCsv
 *
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class ExcelToCsv
{

    protected $javaBin;
    protected $csvOutput;
    protected $jar = 'ExcelToCSVExtractor.jar';

    function __construct($javaBin, $csvOutput)
    {
        $this->javaBin = $javaBin;
        $this->csvOutput = $csvOutput;
    }

    public function convert($inputFilename)
    {
        $out = $this->csvOutput . '/' . uniqid('file_') . '.csv';

        $process = ProcessBuilder::create()
                ->setPrefix($this->javaBin)
                ->add('-jar')
                ->add($this->jar)
                ->add($inputFilename)
                ->add($out)
                ->setWorkingDirectory(dirname(__DIR__) . '/Resources/jar/')
                ->getProcess();

        $process->run(function($type, $out) {
            if ('err' === $type) {
                throw new \Exception($out);
            }
        });

        var_dump($this->csvToArray($out));
    }

    protected function csvToArray($csv)
    {
        $return = array();

        $rows = file($csv);

        foreach ($rows as $index => $data) {
            $return[] = str_getcsv($data, '|');
        }

        return $return;
    }

}
