<?php

/*
* Site parser with email messaging
*/

error_reporting("1"); // All errors and warnings need to be hided - to prevent CRON errors messaging

class QParser 
{
	public $url;
	public $proxy;
	public $proc_func;
	public $curl_headers;
	public $mail_opts;
	public $curl;

	function __construct($args)
	{			
		if(method_exists($this, "before_init") && !$this->before_init())
		{			
			die();
		}

		$this->url = $args['url'];
		$this->proxy = $args['proxy'];

		if( isset($args['proc_func']) && $args['proc_func'] != '')
		{
			$this->proc_func = $args['proc_func'];	
		}
		
		$this->curl_options = $args['curl_options'];
		$this->mail_opts = $args['mail_opts'];

		// Without it magic won't happen
		require_once getcwd() . '/simple_html_dom.php';

		$this->parse();
	}

	function parse()
	{
		$this->curl = curl_init();
		$this->add_curl_options();

		// Set default CURL options
		curl_setopt($this->curl, CURLOPT_URL, $this->url);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.125 Safari/537.36");

		// For debug occasions
		if($this->debug == true)
		{
			curl_setopt($this->curl, CURLOPT_VERBOSE, TRUE);
			curl_setopt($this->curl, CURLOPT_HEADER, TRUE);
		}

		if($this->proxy != '')
		{
			curl_setopt($this->curl, CURLOPT_PROXY, $this->proxy);
		}

		$html = curl_exec($this->curl);

		curl_close($this->curl);

		if($this->debug == true)
		{
			curl_setopt($ch, CURLOPT_STDERR,  fopen('php://output', 'w'));
			pre(curl_error($this->curl));
			pre($html);
		}

		if(method_exists($this, "proc_func"))
		{			
			$content = $this->proc_func($html);

			if($content != "")
			$this->send($content);
		}
	}

	function send($content)
	{	
		// Default mail headers
		$headers = "Content-Type:text/html;charset=UTF-8\r\n"; 

		if(is_array($this->mail_opts['headers']) && count($this->mail_opts['headers']) > 0)
		{
			$headers .= implode("\r\n", $this->mail_opts['headers']);	
		}
		
		$subject = ($this->mail_opts['subject'] != "" ? $this->mail_opts['subject'] : "Mail from parser");

		mail($this->mail_opts['to'], $subject, $content, $headers);
	}

	function add_curl_options()
	{
		foreach($this->curl_options as $key=>$val)
		{
			curl_setopt($this->curl, $key, $val);
		}
	}
}

/*
* Olx parser based on QParser
*/

class OlxParser extends QParser
{
	function proc_func($html)
	{		
		//$html = file_get_contents("site");
		$flats_raw = str_get_html($html);
		//file_put_contents("site", $html);

		$content_main = "";

		foreach($flats_raw->find('#offers_table table.fixed') as $flat)
		{
			$img = $flat->find("img")[0];
			$title = $flat->find(".x-large a.detailsLink")[0];
			$price = $flat->find("p.price")[0];
			$date = $flat->find("p.color-9")[2];
			
			$content = "";
			$content .= "<h4><a href='" . $title->href . "'>" . $title->plaintext . "</h2>";
			$content .= "<br>" . trim($img->outertext);
			$content .= "<br>Цена: " . trim($price->plaintext);
			$content .= "<br>Дата: " . trim($date->plaintext);

			$hash = md5($content);

			if(!in_array($hash, $flats_data))
			{
				$flats_data[] = $hash;

				$content_main .= $content . "<br><br><br>";
			}
		}

		file_put_contents(getcwd() . "/flats.json", json_encode($this->flats_data));

		return $content_main;
	}

	function before_init()
	{	
		if((int)date('H') < 7) return false;

		if(!file_exists(getcwd() . '/flats.json'))
		{
			file_put_contents(getcwd() . '/flats.json', "");
		}

		$this->flats_data = json_decode(file_get_contents(getcwd() . '/flats.json'));
		return true;
	}
}


function pre($str){
	echo "<pre>";
	print_r($str);
	echo "</pre>";
}
?>