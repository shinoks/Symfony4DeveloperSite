<?php
namespace App\Utils;

class TcpdfUtils extends \TCPDF
{

    /**
     * TcpdfUtils constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->encoding = 'utf-8';
        $this->setFont('freeserif');
    }

}
