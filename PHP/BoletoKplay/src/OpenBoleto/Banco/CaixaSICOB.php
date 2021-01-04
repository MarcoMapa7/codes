<?php


namespace OpenBoleto\Banco;

use OpenBoleto\BoletoAbstract;
use OpenBoleto\Exception;
use OpenBoleto\Agente;

/**
 * Classe boleto Caixa Economica Federal - Modelo SICOB.
 * Estende a classe Caixa
 *
 * @package    OpenBoleto
 * @author     Lúcio Abrantes <http://github.com/lucioabrantes>
 * @license    MIT License
 * @version    1.0
 */
class CaixaSICOB extends Caixa
{

    /**
     * Define o número da conta
     *
     * Overrided porque o cedente da Caixa TEM QUE TER 11 posições, senão não é válido
     *
     * @param int $conta
     * @return BoletoAbstract
     */
    public function setConta($conta)
    {
        $this->conta = self::zeroFill($conta, 11);
        return $this;
    }

    /**
     * Gera o Nosso Número
     *
     * @throws Exception
     * @return string
     */
    protected function gerarNossoNumero()
    {
        $conta = $this->getConta();
        $sequencial = $this->getSequencial();

        // Inicia o número de acordo com o tipo de cobrança, provavelmente só será usado Sem Registro, mas
        // se futuramente o projeto permitir a geração de lotes para inclusão, o tipo registrado pode ser útil
        // 9 => registrada, 8 => sem registro.
        $carteira = $this->getCarteira();
        if ($carteira == 'SR'){
            $numero = '80';
        } else {
            $numero = '9';
        }

        // As 8 próximas posições no nosso número são a critério do beneficiário, utilizando o sequencial
        // Depois, calcula-se o código verificador por módulo 11
        $modulo = self::modulo11($numero.self::zeroFill($sequencial, 8));
        $numero .= self::zeroFill($sequencial, 8) . '-' . $modulo['digito'];

        return $numero;
    }

    /**
     * Método para gerar o código da posição de 20 a 44
     * 
     * @return string
     * @throws \OpenBoleto\Exception
     */
    public function getCampoLivre()
    {
        $campoLivre = substr($this->gerarNossoNumero(), 0, 10);
        $campoLivre .= $this->getAgencia();
        $campoLivre .= $this->getConta();

        return $campoLivre;
    }
}
