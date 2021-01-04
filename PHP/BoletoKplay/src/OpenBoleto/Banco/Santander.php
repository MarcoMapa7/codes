<?php


namespace OpenBoleto\Banco;

use OpenBoleto\BoletoAbstract;
use OpenBoleto\Exception;

/**
 * Classe boleto Santander
 *
 * @package    OpenBoleto
 * @author     Daniel Garajau <http://github.com/kriansa>
 * @copyright  Copyright (c) 2013 Estrada Virtual (http://www.estradavirtual.com.br)
 * @license    MIT License
 * @version    1.0
 */
class Santander extends BoletoAbstract
{
    /**
     * Código do banco
     * @var string
     */
    protected $codigoBanco = '033';

    /**
     * Localização do logotipo do banco, referente ao diretório de imagens
     * @var string
     */
    protected $logoBanco = 'santander.jpg';

    /**
     * Linha de local de pagamento
     * @var string
     */
    protected $localPagamento = 'Pagar preferencialmente no Banco Santander';

    /**
     * Define as carteiras disponíveis para este banco
     * @var array
     */
    protected $carteiras = array('101', '102', '201');

    /**
     * Define os nomes das carteiras para exibição no boleto
     * @var array
     */
    protected $carteirasNomes = array('101' => 'Cobrança Simples ECR', '102' => 'Cobrança Simples CSR');

    /**
     * Define o valor do IOS - Seguradoras (Se 7% informar 7. Limitado a 9%) - Demais clientes usar 0 (zero)
     * @var int
     */
    protected $ios;

    /**
     * Define o valor do IOS
     *
     * @param int $ios
     */
    public function setIos($ios)
    {
        $this->ios = $ios;
    }

    /**
     * Retorna o atual valor do IOS
     *
     * @return int
     */
    public function getIos()
    {
        return $this->ios;
    }

    /**
     * Gera o Nosso Número.
     *
     * @return string
     */
    protected function gerarNossoNumero()
    {
        return self::zeroFill($this->getSequencial(), 13);
    }

    /**
     * Método para gerar o código da posição de 20 a 44
     *
     * @return string
     * @throws \OpenBoleto\Exception
     */
    public function getCampoLivre()
    {
        return '9' . self::zeroFill($this->getConta(), 7) .
            $this->getNossoNumero() .
            self::zeroFill($this->getIos(), 1) .
            self::zeroFill($this->getCarteira(), 3);
    }

    /**
     * Define variáveis da view específicas do boleto do Santander
     *
     * @return array
     */
    public function getViewVars()
    {
        return array(
            'esconde_uso_banco' => true,
        );
    }
}
