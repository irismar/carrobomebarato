<?php
/**
 * @author Deivid Fortuna <deividfortuna@gmail.com>
 * @version 1.0.0
 * 
 * Você pode reportar problemas nesse código no endereço: https://github.com/deividfortuna/fipe/issues
 * 
 */
require_once "src/Fipe/Fipe.php";
require_once "src/Conexao.php";

// Tipo de veículos disponiveis (Fipe::CARRO | Fipe::MOTO | Fipe::CAMINHOES)

$Fipe = new Fipe(Fipe::CARRO);
$Conexao = Conexao::getInstance();

// Recupera todas as marcas
$marcas = $Fipe->getMarcas();
if($marcas){
	foreach($marcas as $marca){
		
		$sql = "INSERT INTO marcas (codigo, nome) VALUES (:codigo, :nome)";
		$query = $Conexao->prepare($sql);
		$query->bindValue(":codigo", $marca->codigo);
		$query->bindValue(":nome", $marca->nome);
		$query->execute();
		
		$modelos = $Fipe->getModelos($marca->codigo);
		if($modelos->modelos){
			foreach($modelos->modelos as $modelo){
				
				$sql = "INSERT INTO modelos (codigo, nome, codigo_marca) VALUES (:codigo, :nome, :marca)";
				$query = $Conexao->prepare($sql);
				$query->bindValue(":codigo", $modelo->codigo);
				$query->bindValue(":nome", $modelo->nome);
				$query->bindValue(":marca", $marca->codigo);
				$query->execute();
				
				$anos = $Fipe->getAnos($marca->codigo, $modelo->codigo);
				if($anos){
					foreach($anos as $ano){
						
						$sql = "INSERT INTO anos (codigo, nome, codigo_modelo) VALUES (:codigo, :nome, :modelo)";
						$query = $Conexao->prepare($sql);
						$query->bindValue(":codigo", $ano->codigo);
						$query->bindValue(":nome", $ano->nome);
						$query->bindValue(":modelo", $modelo->codigo);
						$query->execute();
						
						$veiculo = $Fipe->getVeiculo($marca->codigo, $modelo->codigo, $ano->codigo);
						if($veiculo) {
							
							$sql = "INSERT INTO veiculos 
									(codigo, marca, modelo, ano, valor, combustivel, tipo, sigla_combustivel, referencia, codigo_ano, codigo_modelo, codigo_marca) 
									VALUES 
									(:cod, :marca, :modelo, :ano, :valor, :combustivel, :tipo, :sigla, :referencia, :codano, :codmodelo, :codmarca)";
							$query = $Conexao->prepare($sql);
							
							$query->bindValue(":cod", $veiculo->CodigoFipe);
							$query->bindValue(":marca", $veiculo->Marca);
							$query->bindValue(":modelo", $veiculo->Modelo);
							$query->bindValue(":ano", $veiculo->AnoModelo);
							$query->bindValue(":valor", $veiculo->Valor);
							$query->bindValue(":combustivel", $veiculo->Combustivel);
							$query->bindValue(":tipo", $veiculo->TipoVeiculo);
							$query->bindValue(":sigla", $veiculo->SiglaCombustivel);
							$query->bindValue(":referencia", $veiculo->MesReferencia);
							$query->bindValue(":codano", $ano->codigo);
							$query->bindValue(":codmodelo", $modelo->codigo);
							$query->bindValue(":codmarca", $marca->codigo);
							$query->execute();
							
						} else throw new Exception("Não foi encontrado nenhum veículo com essas definições (" . $marca->codigo . ", " . $modelo->codigo . ", " . $ano->codigo . ")");
					}
				} else throw new Exception("Não foi encontrado nenhum ano para esse modelo (" . $modelo->codigo . ")");
			}
		} else throw new Exception("Não foi encontrado nenhum modelo para essa marca (" .  $marca->codigo  . ").");
	}
} else throw new Exception("Não foi encontrada nenhuma marca para esse tipo de veículo.");
