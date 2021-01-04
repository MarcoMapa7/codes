<!--#include file="JSON_2.0.4.asp"-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Exemplo 1 - ASP gera JSON</title>
    </head>

    <body>		
		<h1>Exemplo 1 - ASP gera JSON</h1>
		<%
			'Declara váriavel
			Dim notebook
			'Seta Objeto
			Set notebook = jsObject()

			'Define valores
			notebook("marca") = "Acer"
			notebook("modelo") = "5130"
			notebook("monitor") = "15"

			'Mostra JSon
			notebook.Flush
			
			Set notebook = Nothing
		%>
    </body>
</html>	