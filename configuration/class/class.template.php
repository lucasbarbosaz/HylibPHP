<?php 
	class Template {

		private $params = Array();

		public function SetParam($param, $value){
			$this->params[$param] = $value;
		}

		public function AddTemplate($path, $archive){
			echo $this->GetTemplate($path, $archive);
		}

		public function FilterParams($string){
			foreach ($this->params as $param => $value){
				$string = str_ireplace('{' . $param . '}', $value, $string);
			}

			return $string;
		}

		public function GetTemplate($path, $archive) {
			extract($this->params);
			$file = DIR . SEPARATOR . '/files/cms/' . $path . '/' . $archive . '.php';

			if (!file_exists($file)) {
				echo "Não foi possível encontrar o arquivo de template " . $archive . ".php no diretório " . $file . "\n";
			} else {
				ob_start();
				include($file);
				$data = ob_get_contents();
				ob_end_clean();
				return $this->FilterParams($data);
			}
		}
	}
?>