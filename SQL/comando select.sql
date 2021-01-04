--comando select completo
--SELECT TOP(5) campos FROM nome_tabela WHERE condição GROUP BY campos HAVING formula comparativa ORDER campos  

select * from fat_destinatario where destinatario = '00000001' 

select top 10 * from fat_destinatario 

select top 10 * from fat_destinatario order by nome 

select top 10 destinatario, nome, total=count(0) from fat_destinatario where nome is not null group by destinatario, nome

select top 10 cep, total=count(0) from fat_destinatario where cep is not null and nome is not null group by cep having count(0) > 10 order by cep