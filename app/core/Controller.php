<?php

class Controller{

	protected function model($model){
		$filePath = "../app/models/".$model.".php";
		if (file_exists($filePath)){
			require_once $filePath;
		}
		return new $model;
	}
	
	protected function view($view, $data = []){
		$filePath = "../app/views/".$view.".php";
		if (file_exists($filePath)){
			require_once $filePath;
		}
	}
}