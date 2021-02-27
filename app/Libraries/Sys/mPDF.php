<?php
namespace App\Libraries\Sys;

class mPDF extends \Mpdf\Mpdf
{
	public function __construct(array $config = [])
	{
		parent::__construct($config);
				
		$mpdf->allow_charset_conversion = true;
	}
}