<?php

/* ReCSS System Class */
	class ReCSS {
		
		/* Construct Function */
		function __construct(){
			$this->status = '';
			$this->response = '';
			return $this;
		}
			
		/* Add Status */
		public function addStatus($class,$message){
			$this->statusArray = array();
			$this->statusArray[] = array($class => $message);
			foreach($this->statusArray as $key => $val){
				foreach($val as $class => $message){
					$this->status .= "<div class=\"$class\"><strong class=\"$class\">$class:</strong> $message</div>\n";
				}
			}
			return $this;
		}
	}
	
/* Text Parser Class */
	class Parse extends ReCSS {
		
		/* Create CSS Object */
		public function createCSSObject(){
			$css = $this->response;
			preg_match_all('/[^{]*{[^}]*}/',$css,$css);
			$css = $css[0];
			foreach($css as $key => $val){
				$val = str_replace('}','',$val);
				$css[$key] = explode('{',$val);
				$css[$key][0] = explode(',',$css[$key][0]);
				foreach($css[$key][0] as $bloo => $shmoo){
					$css[$key][0][$bloo] = preg_replace('/ +/',' ',$css[$key][0][$bloo]);
					$css[$key][0][$bloo] = preg_replace('/[\n\t\r]*/','',$css[$key][0][$bloo]);
				}
				$css[$key][1] = explode(';',$css[$key][1]);
				foreach($css[$key][1] as $bloo => $shmoo){
					$css[$key][1][$bloo] = preg_replace('/ +/',' ',$css[$key][1][$bloo]);
					$css[$key][1][$bloo] = preg_replace('/[\n\t\r]*/','',$css[$key][1][$bloo]);
					if(!preg_match('/[^\n\t\r ]+/',$shmoo)){
						unset($css[$key][1][$bloo]);
					}
				}
			}
			return $this;
		}
		
		/* Strips Comments */
		public function stripComments(){
			/* http://stackoverflow.com/questions/643113/regex-to-strip-comments-and-multi-line-comments-and-empty-lines */
			$this->response = preg_replace('!/\*.*?\*/!s','', $this->response);
			$this->response = preg_replace('/\n\s*\n/',"\n", $this->response);
			return $this;
		}
		
		/* Minify */
		public function minify(){
			$this->response = preg_replace('/[\n\r \t]/',' ', $this->response);
			$this->response = preg_replace('/ +/',' ', $this->response);
			$this->response = preg_replace('/ ?([,:;{}]) ?/','$1',$this->response);
			return $this;
		}
		
		/* Text Parser Function */
		public function parseText($text){
			$this->response = $text;
			$this->createCSSObject();
			$this->addStatus('warning', 'TEXT PARSER INCOMPLETE');
			return $this;
		}
	
		/* Url Parser Function */
		public function parseURL($url){
			$this->addStatus('warning', 'URL PARSER INCOMPLETE');
			return $this;
		}
	
		/* File Parser Function */
		public function parseFile($file){
			$this->addStatus('warning', 'FIlE PARSER INCOMPLETE');
			return $this;
		}
	}