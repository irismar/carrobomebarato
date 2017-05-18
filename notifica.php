!DOCTYPE html>
 <html>
 <head>
    <title></title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>     
        <script type="text/javascript">
        function atualizarTarefas() {
           // aqui voce passa o id do usuario
           var url="get.php?id=<?='22'; ?>";
            jQuery("#tarefas").load(url);
        }
        setInterval("atualizarTarefas()", 1000);
        </script>   
 </head>
 <body onLoad="atualizarTarefas()">
INFORMACAO EH EXIBIDA AQUI: <div id="tarefas"></div> 
 </body>
 </html>