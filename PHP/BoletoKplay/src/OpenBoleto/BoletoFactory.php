<?php


namespace OpenBoleto;

/**
 * Classe Factory para criação de instâncias de Boletos
 *
 * @package    OpenBoleto
 * @author     Daniel Garajau <http://github.com/kriansa>
 * @copyright  Copyright (c) 2013 Estrada Virtual (http://www.estradavirtual.com.br)
 * @license    MIT License
 * @version    1.0
 */
class BoletoFactory
{
    /**
     * Mapa das classes dos Bancos e seus códigos
     *
     * @var array
     */
    protected static $classMap = array(
        1 => 'BancoDoBrasil',
        33 => 'Santander',
        70 => 'Brb',
        90 => 'Unicred',
        104 => 'Caixa',
        237 => 'Bradesco',
        341 => 'Itau',
    );

    /**
     * Retorna a instância de um Banco através do código
     *
     * @param int|string $codBanco Código do Banco
     * @param array $params Parâmetros iniciais para construção do objeto
     * @throws Exception Quando o banco não é suportado
     * @return BoletoAbstract
     */
    public static function loadByBankId($codBanco, array $params = array())
    {
        $codBanco = (int) $codBanco;

        if (! isset(static::$classMap[$codBanco])) {
            throw new Exception(sprintf('O banco de código "%s" não é surportado.', $codBanco));
        }

        return static::loadByBankName(static::$classMap[$codBanco], $params);
    }

    /**
     * Retorna a instância de um Banco através do nome
     *
     * @param string $nome Nome do Banco
     * @param array $params Parâmetros iniciais para construção do objeto
     * @throws Exception Quando a classe não é encontrada
     * @return BoletoAbstract
     */
    public static function loadByBankName($nome, array $params = array())
    {
        $class = __NAMESPACE__ . '\\Banco\\' . $nome;

        if (! class_exists($class)) {
            throw new Exception(sprintf('A classe "%s" não existe.', $class));
        }

        return new $class($params);
    }
}
