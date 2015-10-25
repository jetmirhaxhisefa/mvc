<?php

class App{
	/* linku default dmth nese nuk osht setirat asni link per me thirr naj 
	 * faqe te caktume e thirr homin
	 */ 
	protected $controller = 'home';
	/* nese nuk u caktu parametra e metodes ne link nal per me thirr e thirr shabllon metoden index 
	 * ne linkun e caktum
	 * */	
	protected $method = 'index';
	/* array nese qiten parametra ne link per naj metod te caktume
	 * */
	protected $params = [];
	
	public function __construct(){
		/* parametrat te marrura prej linkut permes metodes parseUrl()
		 * */
		$url = $this->parseUrl();
		/* parametra e par e linkut ka mu kon emri i paget qe don mu thirr
		 * 
		 * nese osht i setirat ja jep qat vler global variables controller qe me perdor ma von
		 * 
		 * nese nuk eshte setirat ne link parametra e par perdoret shablloni i variables controller
		 * 
		 * ne fund nese eshte setirat ja dhojm vleren edhe e hekim qat element prej arrays qe mos me na pengu ma von
		 * kur ti marrim parametrat per metod
		 * */
		if(file_exists("../app/controllers/".$url[0].".php")){
			$this->controller = $url[0];
			unset($url[0]);
		}
		/* thirre ose bone required fajllin permes variables controller
		 * */
		require_once '../app/controllers/'.$this->controller.'.php';
		/* krijon parametrat e klases ose objektit e qiti fajll qe e kem lidh permes variables controller 
		 * */
		$this->controller = new $this->controller;
		/* nese eshte dhon ne link parametra e dyt dmth eshte metod
		 * 
		 *  niher e qekiratim a eshte dhon parametra e metodes nese po
		 *  e setiratim ne variablen global $method edhe e hekim prej arrayt $url, 
		 *  e nese sosht setirat e perdorim shabllonin e variables method qe osht metoda index
		 * */
		if (isset($url[1])){
			if(method_exists($this->controller, $url[1])){
				$this->method = $url[1];
				unset($url[1]);
			}
		}
		/*
		 * e qekirasim a ka hala parametra ne link, nese po krejt qato i qesim si parametra te metodes
		 * */
		
		if(count($url) != 0){
			$this->params = $url;
		}
		/*permes qisaj medote ja dhojm metodes te ne classe nje array me parametra 
		 * dmth sa parametra i ka array ja jep krejt qato metodes te caktume
		 * */
		call_user_func_array([$this->controller, $this->method], $this->params);		
		
		
	}
	
	
	/*
	 * E merr url i cili ska nevoj mu kon me prapastresat (extentions) 
	 * se e kem ndreq ne .htaccess
	 * Edhe parametrat e url i bon ne array
	 * P.SH (www.mydomain.com/public/index/test) 
	 * e bon Array ( [0] => public [1] => index [2] => test )
	 * */
	protected function parseUrl(){
		if(isset($_GET['url'])){
			return $url = explode('/', filter_var(rtrim($_GET['url'] , "/"),FILTER_SANITIZE_URL));
		}
	}
}