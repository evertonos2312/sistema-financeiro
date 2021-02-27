<?php namespace Config;

class Version extends \CodeIgniter\Config\BaseConfig
{
	/*
	@var string
	 Sets App Version
	 Dummy var for now, gonna use this in the future
	 */
	public $app_version = '1.3';
	
	/*
	@var string
	 Sets cache version for JS/CSS/IMG files
	 */
	public $version = '20210219_v1';
	
	/*
	@var bool
	 MD5 with $last_version
	 if sets false its gonna be like ?v=20200912_v1
	 */
	public $enc_md5 = true;
	
	
	/*
	@var bool
	Compress HTML to output
	*/
	public $compress_output = false;
	
	public function __construct()
	{
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	}
}
