<!--#include file="classUpload/clsUpload.asp"-->
<!--#include file="classJson/JSON_2.0.4.asp"-->

<%

	'------------------------------------------------------------------------
	'Gera uma string aleatória com 'n' dígitos
	'Usado para criar um nome aleatório para o arquivo
	function fnGeraChave(n)
		dim s

		randomize
		s = ""
		while len(s) < n
			s = chr (int((57 - 48 + 1) * Rnd + 48)) + s
		wend
		fnGeraChave = s
	end function
	'------------------------------------------------------------------------

	Response.Charset="ISO-8859-1"

	dim objUp			'Instância da classe upload (definida no arquivo clsUpload.asp)
	dim objJson			'Instância da classe JSON (definida no arquivo JSON_2.0.4.asp)
	dim diretorio		'Diretório destino
	dim nomeOriginal	'Nome original do arquivo
	dim nomeArquivo		'Nome temporário do arquivo 
						'(Alterado para evitar que arquivos com mesmo nome se sobrescrevam)

	'Instancia a classe clsUpload
	set objUp = New clsUpload

	'Instancia a classe JSON (para enviar a resposta)
	Set objJson = jsObject()

	'Campos passados pelo Uploadify:
	'	- Filename	Nome original do arquivo enviado
	'	- folder	Este campo é definido pelo parâmetro 'folder' do uploadify - não estamos usando
	'	- Filedata	Os bytes (stream) que compõem o arquivo
	'	- Upload	Só achei o valor 'Submit Query' neste campo

	if objUp.fields("Filedata").length <> 0 and objUp.fields("Filedata").length & "" <> "" then

		nomeOriginal = objUp.fields("Filename").value
		nomeArquivo = fnGeraChave(20) & "_" & nomeOriginal

		'O diretório destino é definido aqui, como pasta filha 'uploads' da pasta atual
		diretorio = request.serverVariables("PATH_TRANSLATED")
		diretorio = left (diretorio,instrRev(diretorio,"\")) & "uploads\"

		'Salva o arquivo (Lembre-se de dar direito de escrita para o usuário IUSR!)
		objUp.fields("Filedata").saveAs(diretorio & nomeArquivo)


		'Envia os dados do arquivo via JSON (pode ser que você precise deles no outro lado)
		objJson("result") = "OK"
		objJson("nomeArquivo") = nomeArquivo
		objJson("tamArquivo") = objUp.fields("Filedata").length 
		objJson("nomeOriginal") = nomeOriginal

	else
		'Ocorreu um erro no envio
		objJson("result") = "ERRO"
	end if

	'Envia o JSON para o cliente
	objJson.flush

	'Destroi as instâncias
	Set objUp = Nothing
	Set objJson = Nothing

%>



