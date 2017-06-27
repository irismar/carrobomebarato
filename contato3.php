 	<!DOCTYPE html>
 <html>
 <head>
    <title></title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"  async></script>     
        <script type="text/javascript">
        function atualizarTarefas() {
           // aqui voce passa o id do usuario
           var url="get.php?id=1";
            jQuery("#tarefas").load(url);
        }
        setInterval("atualizarTarefas()", 1000);
        </script>   
 </head>
 <body>
INFORMACAO EH EXIBIDA AQUI: <div id="tarefas"></div> 
 </body>
 </html>