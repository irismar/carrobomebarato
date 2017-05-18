<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
       

        <link href="http://fonts.googleapis.com/css?family=Open+Sans:600" type="text/css" rel="stylesheet" />
        <link href="map/estilo.css?<?=time();?>" type="text/css" rel="stylesheet" />

        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript" src="jquery.min.js?<?=time();?>"></script>
        <? if(isset($_GET["card"])){ ?>
        <script type="text/javascript" src="map/mapa2.js?<?=time();?>"></script>
        <? }else{ ?>
        <script type="text/javascript" src="map/mapa.js?<?=time();?>"></script>
        <? } ?>
        
        <script type="text/javascript" src="jquery-ui.custom.min.js?<?=time();?>"></script>

    </head>
    
    <body>

        <div class="container">
    
    
    
    <div class="col-md-12">
    
 
    <div class="col-md-12">
      <div class="jumbotron ">
        <h3  class="text-center">
            <img src="/img/logoadicionar.png" class="img-responsive" ></img>
            
           
        <h3 class="text-center">
           <? if(isset($_GET["card"])){ ?>
            <br> Digite Seu novo Endereço no campo abaixo seu atual endereço<a href="">  <?=trim($_GET["card"]) ?></a>
           <? }else{ ?> 
               Digite no campo abaixo seu endereço assim seus clientes poderão usar gps para traçar rotas até sua loja
                   <? } ?>
        </h3>
            para maior detalhe movar o ponto vermelho sobre o mapa
        </div>   </div> <div class="desktop">    </div>                   </div>
          <div class="col-md-8">   <form method="post"  action="mapa_cadastro.html">  <fieldset>
                       
                        <input  type="text" id="txtEndereco" name="txtEndereco"  placeholder="Digite Aqui Seu Endereço " >
						</div><div class="col-md-3">
                       <input type="submit" id="btnEndereco" name="btnEndereco" value="Enviar" />
                  </div></div>
                  
                 <div class="container">

                    <div id="mapa"></div>
                    
                	
                    
                    <input type="hidden" id="txtLatitude" name="txtLatitude" />
                    <input type="hidden" id="txtLongitude" name="txtLongitude" />
					   <input type="hidden" id="cidade" name="cidade" />
                    <input type="hidden" id="rua" name="rua" />
					   <input type="hidden" id="estado" name="estado" />
                    <input type="hidden" id="cep" name="cep" />
					 
                </fieldset>
            </form>

          
        </div> </div>
    
    </body>
</html>
