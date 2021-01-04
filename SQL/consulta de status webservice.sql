--declara��es de vari�veis
DECLARE @Tabela TABLE(responseXML XML);

--DECLARE @URL VARCHAR(8000) = 'https://www.w3schools.com/js/ajax_info.txt' --url de exemplo para GET, descomente a linha  20 tamb�m
--DECLARE @URL VARCHAR(8000) = 'https://www.w3schools.com/jquery/demo_test_post.asp' --url de exemplo para POST DEMO 1, descomente a linha  21 tamb�m
DECLARE @URL VARCHAR(8000) = 'http://cep.republicavirtual.com.br/web_cep.php' --url de exemplo para POST DEMO 2, descomente a linha  22 tamb�m

DECLARE @Response VARCHAR(8000)= '', @Obj INT, @Result INT, @HTTPStatus INT; 

--cria��o do objeto
EXEC @Result = sp_OACreate 'MSXML2.XMLHttp', @Obj OUT; 

--setando op��es
--EXEC @Result = sp_OAMethod @Obj, 'open', NULL, 'GET', @URL, false;
EXEC @Result = sp_OAMethod @Obj, 'open', NULL, 'POST', @URL, false;
EXEC @Result = sp_OAMethod @Obj, 'setRequestHeader', NULL, 'Authorization', 'Basic cmVzdHVzZXI6b2NAeGNAMzM0Mg==';
EXEC @Result = sp_OAMethod @obj, 'setRequestHeader', NULL, 'Content-Type', 'application/x-www-form-urlencoded'

--enviando a requisi��o
--EXEC @Result = sp_OAMethod @Obj, send, NULL, ''; --envio via GET, descomente a linha  4 tamb�m
--EXEC @Result = sp_OAMethod @Obj, send, NULL, 'name=Robson&city=Piraju';  --envio via POST DEMO 1, descomente a linha  5 tamb�m
EXEC @Result = sp_OAMethod @Obj, send, NULL, 'cep=18800000&formato=xml';  --envio via POST DEMO 2, descomente a linha  6 tamb�m

--capturando informa��es do retorno
EXEC @Result = sp_OAGetProperty @Obj, 'status', @HTTPStatus OUT;
EXEC @Result = sp_OAGetProperty @Obj, 'responseText', @Response OUT; 

--verifica��o de status de sucesso
IF(@HTTPStatus IN(200, 201, 209))
BEGIN
    --exibindo informa��es do retorno
    select status = @HTTPStatus, url=@URL, result = @Result, resposta=@Response
    INSERT INTO @Tabela(responseXML)
        SELECT @Response; 

    --resposta em xml
    SELECT [@Tabela].responseXML FROM @Tabela;

    --exemplo para ler xml do POST DEMO 2
    select [resultado]=x.resposta.value('(./resultado)[1]', 'VARCHAR(100)'), [uf]=x.resposta.value('(./uf)[1]', 'VARCHAR(100)'), [cidade]=x.resposta.value('(./cidade)[1]', 'VARCHAR(100)')
       from (SELECT CAST(replace(convert(varchar(max),responseXML),'<?xml version="1.0" encoding="utf-8"?>','') AS XML) FROM @Tabela) AS A(x)
           CROSS APPLY x.nodes('webservicecep') AS x(resposta)

END;
ELSE
BEGIN
    --status e msg de erro 
    SELECT status = @HTTPStatus,
            msg = 'Erro na comunica��o',
            url = @URL,
            result = @Result,
            resposta = @Response;
END;