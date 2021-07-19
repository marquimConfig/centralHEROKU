<?php


namespace App\Api\Source;

use App\Api\Elitesoft\ISPIntegrator;
use App\Api\Connect\ConnectElite;
use mysql_xdevapi\Result;
use PDOException;

class Fatura
{
    /**
     * Acessos para a API do Integrator
     */
    const HTTP_ISPINTEGRATOR = 'https://srv-elite.megalink.net.br/';
    const URL_ISPINTEGRATOR = '191.242.216.10';
    const USER_ISPINTEGRATOR = '25AM0LAY9Y';
    const PASS_ISPINTEGRATOR = '25AM0LAZMK';

    /**
     * @var string
     */
    private $segundaVia;

    private $barCode;

    /**
     * Função traz do bando faturas pendentes do cliente
     * @param $codCLi
     * @return array
     */
    public function codFatura($codCLi)
    {
        $isp = new ISPIntegrator(self::USER_ISPINTEGRATOR, self::PASS_ISPINTEGRATOR, self::URL_ISPINTEGRATOR);
        $request = $isp->faturasCliente($codCLi);

        $teste = $request[0]->params->param[1]->value->DOMElement->result ;

        if($teste == NULL){
            return NULL;
        }

        foreach ($teste->row as $x => $value ){
        //var_dump($value);
        if ($value->Saldo != "0.00"){
        //print_r($value);
            $return[] = (object)[
                "codfat" => "{$value->codfat}",
                "hist_fat" => "{$value->histo_fat}",
                "data_ven" => "{$value->data_ven}",
                "valor_lan" => "{$value->valor}"
                ];
                $object = (object)$return;
             }
    
        }
        return $object;
    }


   /**
     * Função retorna os dados da fatura
     * @param $codFat
     * @return string
     */
    public function getFatura($codFat)
    {
        try {
            $stmt = ConnectElite::getInstanceISP();
            $sql = "SELECT codfat, histo_fat, data_ven, valor_lan FROM faturas where codFat = '{$codFat}'";
            $sql = $stmt->query($sql);
            return $sql->fetchAll();
        } catch (PDOException $exception) {
            die($exception);
        }
    }

    /**
     * Função retorna o link do boleto em PDF para Download
     * @param $codFat
     * @return string
     */
    public function segundaVia($codFat): string
    {
        $request = new ISPIntegrator(self::USER_ISPINTEGRATOR, self::PASS_ISPINTEGRATOR, self::URL_ISPINTEGRATOR);
        $result = $request->verBoleto($codFat);
        $this->barCode = $result['data']['results'][0]['linkBoleto'];
        return self::HTTP_ISPINTEGRATOR . $this->barCode;
    }
    /**
     * Função retorna Cadigo de barras para pagamento.
     * @param $cadFat
     * @return mixed
     */

    public function barCode($cadFat)
    {
        $request = new ISPIntegrator(self::USER_ISPINTEGRATOR, self::PASS_ISPINTEGRATOR, self::URL_ISPINTEGRATOR);
        $result = $request->linhaDigitavel($cadFat);
        $this->barCode = $result['data']['results'][0]['codigo_barras'];
        return $this->barCode;
    }

    /**
     *      ####################################################
     *      ##         Funções novas para tratativas PIX      ##
     *      ####################################################
     */

    /**
     * Função retorna valores de juros e multa de uma fatura
     * @param $invoiceCode
     * @return array|false
     */
    private function invoiveDetail($invoiceCode){
        $api = new ISPIntegrator(self::USER_ISPINTEGRATOR, self::PASS_ISPINTEGRATOR, self::URL_ISPINTEGRATOR);
        $data = $api->getDetalheFatura($invoiceCode);
        return $data;
    }

    /**
     * Função retorna Valor de desconto promocional ou não de uma fatura.
     * @param $invoiceCode
     * @return array|false
     */
    private function getPromotionalDiscount($invoiceCode){
        $api = new ISPIntegrator(self::USER_ISPINTEGRATOR, self::PASS_ISPINTEGRATOR, self::URL_ISPINTEGRATOR);
        $data = $api->getDesconto($invoiceCode);
        return  $data;
    }

    /**
     * Função Responsavel por retornar os valores a pagar de uma determinada fatura
     * @param $fatura
     * @return string[]
     */
    public function amountPayable($fatura){
        $discount = $this->getPromotionalDiscount($fatura);
        if (!empty($discount['data'])){
            return array(
                "Valor Total" => "{$discount['data']['results'][0]['valor_desc']}"
            );

        }else{
            $data = $this->invoiveDetail($fatura);

            // Caso o Array (results) seja maior que 1 se trata de uma fatura de serviço adicional
            if (count($data['data']['results']) > 1  ){

                //Varifica se a fatura tem dias vencidos
                if ($data['data']['results']["Quant_dias_venc"] > 0){
                    return array(
                        "Multa"=>"{$data['data']['results']['multa']}",
                        "Juros"=>"{$data['data']['results']['juros']}",
                        "Valor Total"=>"{$data['data']['results']['valor_final']}"
                    );
                    //Retorna valor final para faturas não vencidas
                } else {
                    return array(
                        "Valor Total"=>"{$data['data']['results']['valor_final']}"
                    );
                }
                // Varifica se a faura do serviço adicional esta vencida
            } elseif (empty($data['data']['results'][0] == 1) && $data['data']['results'][0]['Quant_dias_venc'] > 1){

                return array(
                    "Multa"=>"{$data['data']['results'][0]['multa']}",
                    "Juros"=>"{$data['data']['results'][0]['juros']}",
                    "Valor Total"=>"{$data['data']['results'][0]['valor_final']}"
                );
                //retorn a fatura com o valor final caso não esteja vencida
            } else {
                return array(
                    "Valor Total"=>"{$data['data']['results'][0]['valor_final']}"
                );
            }
        }
    }

}