
--criar no desktop a pasta "teste" e colocar alguns arquivos .txt dentro
--definir no PATH do servidor de banco de dados o caminho de instalação do WinRAR para poder usar de forma simples o comando rar.exe

declare @arquivo varchar(100) = 'teste', @pasta varchar(100) = 'pasta-teste'
, @caminho_origem varchar(1000) = 'C:\Users\Administrator\Desktop\teste' --caminho fisico no servidor de banco de dados onde estará os arquivos
, @caminho_destino varchar(1000) = 'C:\Users\Administrator\Desktop\teste' --caminho fisico no servidor de banco de dados para onde vai o arquivo final
, @comando varchar(1000) = ''

select @comando = N'rar a -ap/'+@pasta+' -ep1 "' + @caminho_destino + '\'+@arquivo+'.rar" "'+@caminho_origem+'\*.txt"';
--caso queira mover os arquivos para dentro do ZIP/RAR e nao deixar nenhum arquivo para trás, ao invés de usar o comando "rar a " usar o comando "rar m[f]"

EXEC xp_cmdshell @comando;