<?php
/**
 * @author Deivid Fortuna <deividfortuna@gmail.com>
 * @version 1.0.0
 * 
 * Você pode reportar problemas nesse código no endereço: https://github.com/deividfortuna/fipe/issues
 * 
 */
class Fipe
{
	private $uri = "https://fipe-parallelum.rhcloud.com/api/v1/";
	private $tipo;
	const CARRO = 1;
	const CAMINHAO = 3;
	const MOTO = 2;

	public function __construct($tipo){
		switch ($tipo){
			case Fipe::CARRO: $this->tipo = "carros";
			break;
			case Fipe::CAMINHAO: $this->tipo = "caminhoes";
			break;
			case Fipe::MOTO: $this->tipo = "motos";
			break;
			default:
				throw new \Exception("Select a valid type on construct");
		}
	}

	private static function request($uri){
		var_dump($uri);
		try {
			$ch = curl_init($uri);
			$options = array(
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_FOLLOWLOCATION => 1
			);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt_array($ch, $options);
			$html = curl_exec($ch);
			curl_close($ch);
			return json_decode($html);
		} catch(\Exception $e) {
			return false;
		}
	}

	public function getMarcas(){
		$uri = $this->uri . $this->tipo . "/marcas";
		return Fipe::request($uri);
	}

	public function getModelos($idMarca){
		$uri = $this->uri . $this->tipo . "/marcas/" . $idMarca . "/modelos";
		return Fipe::request($uri);
	}

	public function getAnos($idMarca, $idModelo){
		$uri = $this->uri . $this->tipo . "/marcas/" . $idMarca . "/modelos/" . $idModelo . "/anos";
		return Fipe::request($uri);
	}

	public function getVeiculo($idMarca, $idModelo, $idAno){
		$uri = $this->uri . $this->tipo . "/marcas/" . $idMarca . "/modelos/" . $idModelo . "/anos/" . $idAno;
		return Fipe::request($uri);
	}
}
