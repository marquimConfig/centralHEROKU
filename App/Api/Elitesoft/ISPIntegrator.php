<?php


namespace App\Api\Elitesoft;


class ISPIntegrator
{

    private $user;
    private $password;
    private $url;
    private $metodo;
    private $subMetodo;
    private $query;
    private $curl;
    private $debug;
    private $params = array();

    ########################################################################
    ##                          FUNCOES DA API                            ##
    ########################################################################

    public function identificarDocumento($documento) {
        $this->debug = debug_backtrace();
        if ($this->getArgs(func_get_args())) {
            $this->setMetodo("view.execute");
            $doc = $this->mask_cpf_cnpj($documento);
            if ($doc) {
                $this->params['_consulta'] = "011G0NP05B";
                $this->params['formato_padrao'] = "X";
                $this->params[(strlen($documento) == 11 ? 'cpf' : 'cnpj')] = $doc;
                return $this->setParamsXML();
            }
            return false;
        } else {
            return false;
        }
    }

    public function identificarTelefone($telefone) {
        $this->debug = debug_backtrace();
        if ($this->getArgs(func_get_args())) {
            $this->setMetodo("view.execute");
            $telefone = $this->mask_phone_tel($telefone);
            if ($telefone) {
                $this->params['_consulta'] = "011G0NP05B";
                $this->params['formato_padrao'] = "X";
                $this->params[$telefone['type']] = $telefone['telefone'];
                return $this->setParamsXML();
            }
            return false;
        } else {
            return false;
        }
    }

    /**
     * PLano do cliente
     * @param $codcli
     * @return array|false
     */
    public function listaDetalhesServico($codcli) {
        $this->debug = debug_backtrace();
        if ($this->getArgs(func_get_args())) {
            $this->setMetodo("list");
            $this->setSubMetodo("services.details");
            $this->params['codcli'] = $codcli;
            return $this->setParamsJSON();
        } else {
            return false;
        }
    }

    /**
     * Faturas que ja estão com remessa tranmitida.
     * @param $codcli
     * @param string $from
     * @param string $to
     * @return array|false
     */
    public function faturasCliente($codcli, $from = '01-04-2021', $to = '') {
        $this->debug = debug_backtrace();
        if ($this->getArgs(func_get_args())) {
            $this->setMetodo("faturas.cliente");
            $this->params['codcli'] = $codcli;
            $this->params['from'] = $from;
            $this->params['to'] = date('d/m/Y', strtotime('+60 days', time()));
            return $this->setParamsXML();
        } else {
            return false;
        }
    }

    /**
     * Metodo responsavel por Realizar baixa da fatura do cliente(A condição vallor a ser Pago deve ser enviado como INT e com pontos)
     * @param $codFat
     * @return array|false
     */
    public function baixarFatura()
    {
        $this->debug = debug_backtrace();
        if ($this->getArgs(func_get_args())) {
            $this->setMetodo("execute");
            $this->setSubMetodo("fatura.bxfatura");
            $this->params["request"] = ["sendRequest" => "integrator.server",
                "method" => "$this->metodo",
                "submethod" => "$this->subMetodo",
                "params" => [
                    "_user" => "$this->user",
                    "_passwd" => "$this->password",
                    "json_fatura" => array([
                        "codusu" => "E0",
                        "codfat" => "E01P1048YS",
                        "codarq" => "",
                        'codcrec' => "",
                        'data_bai' => "2021-05-12",
                        'data_ven' => "2021-07-20",
                        'data_conci' => "2020-05-11",
                        'data_lan' => "2021-05-10",
                        'valor_pg' => "149.90",
                        "valor_mt" => "0",
                        "valor_jr" => "0",
                        "nro_doc" => "51NO100002",
                        "hist_mov" => "Mensalidade-07-2021",
                        "codban" => "AD1J0K26J8",
                        "codtmov" => "01XP10A6JW",
                        "codadqcar" => "",
                        "tp_car" => "",
                        "id_transacao" => '01010',
                        "obs_transacao" => 'Mercado_pago',
                        "agrupado" => "N"])

                ]
            ];
            return $this->setParamsJSON('encode');
        } else {
            return false;
        }
    }

    /**
     * Retorna informações detalhadas de uma fatura
     * @param $codFat
     * @return array|false
     */
    public function getDetalheFatura($codFat){
        $this->debug =debug_backtrace();
        if ($this->getArgs(func_get_args())){
            $this->setMetodo("list");
            $this->setSubMetodo("fatura.detalhe");
            $this->params['codfat'] = $codFat;
            return $this->setParamsJSON();
        } else {
            return false;
        }
    }

    /**
     * Metodo para trazer detalhes da fatura em especifico.
     * @param $codFat
     * @return array|false
     */
    public function getDesconto($codFat)
    {
        $this->debug = debug_backtrace();
        if ($this->getArgs(func_get_args())) {
            $this->setMetodo("list");
            $this->setSubMetodo("faturas.getDesconto");
            $this->params["codfat"] = $codFat;
            return $this->setParamsJSON();
        } else {
            return false;
        }
    }

    /**
     * Link pronto para Download do PDF da Fatura.
     * @param $codFat
     * @return array|false
     */
    public function verBoleto($codFat) {
        $this->debug = debug_backtrace();
        if ($this->getArgs(func_get_args())) {
            $this->setMetodo("list");
            $this->setSubMetodo("datasource.verBoleto");
            $this->params['codfat'] = $codFat;
            return $this->setParamsJSON();
        } else {
            return false;
        }
    }

    /**
     * Retorna Codigo de barras da fatura
     * @param string $codFat
     * @return array|false
     */
    public function linhaDigitavel($codFat) {
        $this->debug = debug_backtrace();
        if ($this->getArgs(func_get_args())) {
            $this->setMetodo("list");
            $this->setSubMetodo("datasource.linhaDigitavel");
            $this->params['codfat'] = $codFat;
            return $this->setParamsJSON();
        } else {
            return false;
        }
    }

    public function listaServico($codcli): string
    {
        $this->debug = debug_backtrace();
        if ($this->getArgs(func_get_args())) {
            $this->setMetodo("list");
            $this->setSubMetodo("services.details");
            $this->params['codcli'] = $codcli;
            return $this->setParamsJSON();
        } else {
            return false;
        }
    }

    public function planInfo2($codcli) {
        $this->debug = debug_backtrace();
        if ($this->getArgs(func_get_args())) {
            $this->setMetodo("list");
            $this->setSubMetodo("plan.getInfo2");
            $this->params['codcli'] = $codcli;
            return $this->setParamsJSON();
        } else {
            return false;
        }
    }

    public function habilitacaoProvisoria($codsercli) {
        $this->debug = debug_backtrace();
        if ($this->getArgs(func_get_args())) {
            $this->setMetodo("list");
            $this->setSubMetodo("habilitacaoProvisoria.execute");
            $this->params['codsercli'] = $codsercli;
            return $this->setParamsJSON();
        } else {
            return false;
        }
    }

    public function verificaIncidente($codcli) {
        $this->debug = debug_backtrace();
        if ($this->getArgs(func_get_args())) {
            $this->setMetodo("view.execute");
            $this->params['_consulta'] = "02A50HOX3E";
            $this->params['formato_padrao'] = "X";
            $this->params['codcli'] = $codcli;
            return $this->setParamsXML();
        } else {
            return false;
        }
    }

    /**
     * Envia email das faturas solicitadas.
     *
     * $faturaMes => Coleta todas as faturas do m�s para ser enviadas.
     *
     * @param string|int $documento
     * @param boolean $faturasMes
     * @return boolean
     */
    public function enviarBoletoFatura($cliente) {
        $this->debug = debug_backtrace();
        $pathFileMail = __DIR__ . "/email.html";

        if (!$this->mail) {
            $this->log->error('Antes de enviar o email e necessario configurar o SimpleMail e SMTP!');
            return false;
        }

        $dados = $cliente->params->param[1]->value->DOMElement->result->row;

        $fatura = $this->faturasCliente($dados->codcli);
        $invoices = $fatura->params->param[1]->value->DOMElement->result->row;

        if (!$invoices) {
            $this->log->info("Nao foi possivel encontrar nenhuma fatura em aberto do solicitante!");
            return false;
        }

        foreach ($invoices as $value) {
            $invoice = $this->verBoleto($value->codfat);
            $line = $this->linhaDigitavel($value->codfat)['data']['results'][0]['codigo_barras'];
            $linkInvoice = $this->url . $invoice['data']['results'][0]['linkBoleto'];
            $link .= "<b>Fatura Num.:</b> {$value->codfat} - <b>Codigo do boleto:</b>[ $line ] <a href='{$linkInvoice}' target='_blank'>Visualizar Boleto</a> <br/>";
            sleep(1);
        }

        $data = array('$titulo' => "Envio de Fatura", '$data_ven' => $invoices->data_ven, '$nome' => $dados->nome_cli, '$link' => $link);
        $this->log->info("Faturas inseridas do E-mail!");

        if (file_exists($pathFileMail)) {
            $this->mail->pathBodyMail($pathFileMail, $data);
        } else {
            $this->mail->bodyMessage("<h4>Ola, <b>{$dados->nome_cli}</b></h4><p>Conforme solicitado estamos lhe enviando a segunda via de sua fatura.</p><p>{$link}</p>");
        }

        $this->log->info("Encaminhando boleto por E-mail!");

        if ($this->mail->mailing($dados->e_mail)) {
            $this->log->success("O Boleto foi enviado com sucesso!");
            return true;
        } else {
            $this->log->error("Nao foi possivel enviar o boleto para o email do solicitante!");
            $this->log->error("Error SimpleMail: " . $this->mail->getErrorSend());
            return false;
        }
    }

    function listaServicoHabilitado($codcli, $infoAll = false) {
        $retorno = $this->listaDetalhesServico($codcli);
        $groupService = array();

        if ($retorno['data']['results'][0]['planos']) {
            $descri_est = explode(' ', $retorno['descri_est'])[1];
            if ($descri_est == 'Habilitado') {
                if (!in_array($retorno['codgser'], $groupService)) {
                    $groupService[] = $infoAll ? $retorno : $retorno['codgser'];
                }
            }
        } else {
            foreach ($retorno['data']['results']['planos'] as $plano) {
                $descri_est = explode(' ', $plano['descri_est'])[1];
                if ($descri_est == 'Habilitado') {
                    if (!in_array($plano['codgser'], $groupService)) {
                        $groupService[] = $infoAll ? $plano : $plano['codgser'];
                    }
                }
            }
        }
        return $groupService;
    }

    ########################################################################
    ##                      FUNCOES DEFAULT DA CLASSE                     ##
    ########################################################################

    /**
     * Coleta as informacoes iniciais para o inicio da integracao com a API.
     *
     * @param string $user
     * @param string $password
     * @param boolean $url
     */
    public function __construct($user, $password, $url) {
        $this->user = $user;
        $this->password = $password;
        $this->url = "http://{$url}/";
    }

    /**
     * Parametriza o metodo utilizado para a consulta.
     *
     * @param type $metodo
     */
    private function setMetodo($metodo) {
        $this->metodo = $metodo;
    }

    /**
     * Parametriza do submetodo utilizado para a consulta.
     *
     * @param type $submetodo
     */
    private function setSubMetodo($submetodo) {
        $this->subMetodo = $submetodo;
    }

    /**
     * Escreve a query para ser passada para o curl
     *
     * @param string $query
     */
    private function setQuery($query) {
        return $this->query .= $query;
    }

    /**
     * retorna a string pronta da query do curl e limpa a variavel.
     *
     * @return string $query
     */
    private function getQuery() {
        $query = $this->query;
        unset($this->query);
        return $query;
    }

    /**
     * Constroi de forma dinamica a string para ser passada para a execucao do Curl
     *
     * @void
     */
    private function curl($type) {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_URL, $this->url . (strtoupper($type) == 'XML' ? 'server.php' : 'integrator.server.php'));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->getQuery());
        curl_setopt($this->curl, CURLOPT_ENCODING, "deflate,gzip,br");

        if (strtoupper($type) == 'XML') {
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Content-Type: text/xml; charset=utf-8; ApplicationV: Integrator/6'));
        } else {
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Cache-Control: no-cache', 'Content-Type: application/json', 'ApplicationV: Integrator/6'));
        }

    }

    /**
     * Recebe array de forma de indice e valor
     *
     * @example array("qtype" => 'test_api', "query" => '123', "oper" => '=')
     *
     * @obs sempre chamar a fun��o debug_backtrace() para ser dispon�vel em log
     *
     * @param type $params
     * @debug_track function debug_backtrace()
     */
    private function setParamsXML() {
        $this->params['_user'] = $this->user;
        $this->params['_passwd'] = $this->password;

        $this->setQuery("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?><methodCall><methodName>{$this->metodo}</methodName><params>");
        foreach ($this->params as $key => $value) {
            $this->setQuery("<param name=\"$key\"><value><string><![CDATA[$value]]></string></value></param>");
        }
        $this->setQuery("</params></methodCall>");

        unset($this->params);
        return $this->exec('XML');
    }

    private function setParamsJSON($json = null)
    {
        if ($json !== 'encode') {
            $x = 0;
            $this->setQuery("{");
            $this->setQuery(sprintf('"request": {"sendRequest": "integrator.server", "method": "%s", "submethod": "%s",', $this->metodo, $this->subMetodo));
            $this->setQuery(sprintf('"params": {"_user":"%s","_passwd":"%s",', $this->user, $this->password));
            foreach ($this->params as $key => $value) {
                $x++;
                $this->setQuery(sprintf('"%s":"%s"', $key, $value));
                if (count($this->params) != $x) {
                    $this->setQuery(", ");
                }
            }

            $this->setQuery("}}}");
            unset($this->params);
            return $this->exec('JSON');

        } else {
            //var_dump($this->params);
            $request = json_encode($this->params);
            //print_r($request);
            $this->setQuery($request);
            unset($this->params);
            return $this->exec('JSON');
        }
    }

    /**
     * Recebe as informa��es e realiza a execucao da API
     *
     * @void
     */
    private function exec($type) {
        $this->curl($type);
        $response = curl_exec($this->curl);
        if (curl_errno($this->curl)) {
            curl_close($this->curl);
            return false;
        }
        curl_close($this->curl);
        if (strtoupper($type) == 'XML') {
            return $this->response(simplexml_load_string($response));
        } else {
            return $this->response(json_decode($response, true));
        }
    }

    /**
     * Prepara dos dados para ser transmitidos para o metodo a ser retornado a
     * integracao.
     *
     * @return array
     */
    private function response($data) {
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    private function getArgs($args) {
        foreach ($args as $value) {
            if (!$value) {
                return false;
            }
        }
        return true;
    }

    private function mask_cpf_cnpj($string) {
        if (!empty($string)) {
            if (strlen($string) == 11) {
                $mask = "%s%s%s.%s%s%s.%s%s%s-%s%s";
            } elseif (strlen($string) == 14) {
                $mask = "%s%s.%s%s%s.%s%s%s/%s%s%s%s-%s%s";
            }
            return vsprintf($mask, str_split($string));
        } else {
            return false;
        }
    }
}