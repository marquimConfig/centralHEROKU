<?php


namespace App\Api\Source;

use App\Api\Connect\ConnectMegaLink;
use App\Api\Connect\ConnectElite;
use PDOException;

define('MYSQL_HOST', '10.0.3.236');
define('MYSQL_USER', 'root');
define('MYSQL_PASSWORD', 'mega@link');
define('MYSQL_DB_NAME', 'sac_megalink');


class Cliente
{

    public $codCli;
    public $login;
    public $senha;
    public $resetar;

    //Secript para dar cargar no banco de login e senha. 
    // public function getAllClientes()
    // {
    //     try {
    //         $stmt = ConnectElite::getInstanceISP();
    //         $sql = "SELECT codcli, nome_cli, cpf, cnpj FROM clientes";
    //         $sql = $stmt->query($sql);
    //         $listClientes = $sql->fetchAll();

    //         foreach ($listClientes as $cliente) {
    //             $cpf = $cliente->cpf;
    //             $cpfNumeros = preg_replace('/[^0-9]/', '', $cpf);
    //             $cnpj = $cliente->cnpj;
    //             if (!empty(trim($cpf))) {
    //                 if (strlen($cpfNumeros) == 11) {
    //                     $usuario = (new Cliente);
    //                     $usuario->codCli = $cliente->codcli;
    //                     $usuario->login = $cpfNumeros;
    //                     $newsenha = $cpfNumeros[0] . $cpfNumeros[1] . $cpfNumeros[2] . $cpfNumeros[3] . $cpfNumeros[4] . $cpfNumeros[10];
    //                     $usuario->senha = $newsenha;
    //                     $usuario->resetar = 0;
    //                     $usuario->InserirLoginSenhaCliente($usuario);
    //                 }
    //             } else {
    //                 $pieces = explode("/", $cnpj);
    //                 $cnpjPrimeiraParteNumeros = preg_replace('/[^0-9]/', '',  $pieces[0]);

    //                 if (strlen($cnpjPrimeiraParteNumeros) == 8) {
    //                     $usuario = (new Cliente);
    //                     $usuario->codCli = $cliente->codcli;
    //                     $usuario->login = $cnpjPrimeiraParteNumeros;
    //                     //senha cnpj => 5primeiros digitos + utimo digito
    //                     $newsenha = $cnpjPrimeiraParteNumeros[0] . $cnpjPrimeiraParteNumeros[1] . $cnpjPrimeiraParteNumeros[2] . $cnpjPrimeiraParteNumeros[3] . $cnpjPrimeiraParteNumeros[4] . $cnpjPrimeiraParteNumeros[7];
    //                     $usuario->senha = $newsenha;
    //                     $usuario->resetar = 0;
    //                     $usuario->InserirLoginSenhaCliente($usuario);
    //                 }
    //             }
    //         }
    //     } catch (PDOException $exception) {
    //         die($exception);
    //     }
    // }

    public function getAllClientes()
    {
        try {
            $stmt = ConnectElite::getInstanceISP();
            $sql = "SELECT codcli, nome_cli, cpf, cnpj FROM clientes";
            $sql = $stmt->query($sql);
            $listClientes = $sql->fetchAll();

            foreach ($listClientes as $cliente) {
                $nome_cli = $cliente->nome_cli;
                $cpf = $cliente->cpf;
                $cpfNumeros = preg_replace('/[^0-9]/', '', $cpf);
                $cnpj = $cliente->cnpj;
                if (!empty(trim($cpf))) {
                    if (strlen($cpfNumeros) == 11) {
                        $usuario = (new Cliente);
                        $usuario->codCli = $cliente->codcli;
                        $usuario->login = $cpfNumeros;
                        
                        //senha cnpj => 5primeiros digitos + ultimo digito
                        $newsenha = $cpfNumeros[0] . $cpfNumeros[1] . $cpfNumeros[2] .
                        $cpfNumeros[3] . $cpfNumeros[4] . $cpfNumeros[10];
                        
                        $usuario->senha = $newsenha;
                        $usuario->resetar = 0;
                        $usuario->nome_cli = $nome_cli;
                        $usuario->InserirLoginSenhaCliente($usuario);
                    }
                } else {

                    $cnpjPrimeiraParteNumeros = preg_replace('/[^0-9]/', '',  $cnpj);

                    if (strlen($cnpjPrimeiraParteNumeros) == 14) {
                        $usuario = (new Cliente);
                        $usuario->codCli = $cliente->codcli;
                        $usuario->login = $cnpjPrimeiraParteNumeros;

                        //senha cnpj => 8primeiros digitos + **
                        $newsenha = $cnpjPrimeiraParteNumeros[0].$cnpjPrimeiraParteNumeros[1]
                        .$cnpjPrimeiraParteNumeros[2] . $cnpjPrimeiraParteNumeros[3]
                        .$cnpjPrimeiraParteNumeros[4].$cnpjPrimeiraParteNumeros[5]
                        .$cnpjPrimeiraParteNumeros[6] . $cnpjPrimeiraParteNumeros[7]."**";

                        $usuario->senha = $newsenha;
                        $usuario->resetar = 0;
                        $usuario->nome_cli = $nome_cli;
                        $usuario->InserirLoginSenhaCliente($usuario);
                    }
                }
            }
        } catch (PDOException $exception) {
            die($exception);
        }
    }

    public function InserirLoginSenhaCliente($registro)
    {
        try {
            $PDO = new \PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB_NAME, MYSQL_USER, MYSQL_PASSWORD);
            $sql = "INSERT INTO clientes_login (codcli, login, senha, resetar, nome) VALUES (:codcli, :login, :senha, :resetar, :nome)";
            $stmt = $PDO->prepare( $sql );
            $stmt->bindParam( ':codcli', $registro->codCli);
            $stmt->bindParam( ':login', $registro->login);
            $stmt->bindParam( ':senha', $registro->senha);
            $stmt->bindParam( ':resetar', $registro->resetar );
            $stmt->bindParam( ':nome', $registro->nome_cli );

            $result = $stmt->execute();
            echo($result);

        } catch (PDOException $e) {
            echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
        }
    }

    // public function Logar($login, $senha){
    //     try {
    //        $stmt = ConnectMegaLink::getInstanceISP();
    //        $sql = "SELECT * from clientes_login where login = '{$login}' AND senha ='{$senha}'";
    //        $sql = $stmt->query($sql);
    //        return $sql->fetchAll();
    //     }catch (PDOException $exception){
    //         die($exception);
    //     }
    // }

    // public function LogarCpFCnpj($login){
    //     try {
    //       $stmt = ConnectElite::getInstanceISP();
    //       $sql = "SELECT * from clientes where cpf = '{$login}' ";
    //       $sql = $stmt->query($sql);
    //       return $sql->fetchAll();
    //     }catch (PDOException $exception){
    //         die($exception);
    //     }
    // }
    
    /**
     * formatCnpjCpf função criada para receber os apenas numeros de cpf ou cnpj e formata-los
     */
    public function formatCnpjCpf($value){
        $CPF_LENGTH = 11;
        $cnpj_cpf = preg_replace("/\D/", '', $value);
        if (strlen($cnpj_cpf) === $CPF_LENGTH) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        }
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
    }

    /**
     * CpfOrCnpj função criada para verificar se é CPF ou CNPJ
     */
    public function CpfOrCnpj($value)
    {
        if (!is_null($value) && ($value != "")) {
            $CPF_LENGTH = 14;
            $CNPJ_LENGTH = 18;
            if (strlen($value) == $CPF_LENGTH) {
                return 'cpf';
            } else if (strlen($value) == $CNPJ_LENGTH) {
                return 'cnpj';
            }
        }
    }

    /**
     * Função de login
     */
    public function LogarCpFCnpj($login){
        try {
            $cpf_cnpj = $this->CpfOrCnpj($login);
            $stmt = ConnectElite::getInstanceISP();
            $sql = "SELECT * from clientes where {$cpf_cnpj} = '{$login}' ";
            $sql = $stmt->query($sql);
            return $sql->fetchAll();
        }catch (PDOException $exception){
            die($exception);
        }
    }

    public function GetSenhaAtualPorCodCli($codCli){
        try {
           $stmt = ConnectMegaLink::getInstanceISP();
           $sql = "SELECT * from clientes_login where codCli = $codCli";
           $sql = $stmt->query($sql);
           return $sql->fetchAll();
        }catch (PDOException $exception){
            die($exception);
        }
    }

    public function AlterarSenhaClient($codCli, $novaSenha){
        try {
           $stmt = ConnectMegaLink::getInstanceISP();
           $sql = "UPDATE clientes_login SET senha = $novaSenha WHERE (codCli = $codCli);";
           $stmt = $stmt->prepare( $sql);
           $result = $stmt->execute();
           return ($result);
        }catch (PDOException $exception){
            die($exception);
        }
    }

    public function getDadosCliente($codcli){
            try {
               $stmt = ConnectElite::getInstanceISP();
               $sql = "SELECT * FROM clientes where codcli = '{$codcli}'";
               $sql = $stmt->query($sql);
               return $sql->fetchAll();
            }catch (PDOException $exception){
                die($exception);
            }  
    }

    public function getNotasFiscais($codcli){
        try {
           $stmt = ConnectElite::getInstanceISP();
           $sql = "SELECT * FROM nota_fiscal where codcli = '{$codcli}' order by data_lan desc";
           $sql = $stmt->query($sql);
           return $sql->fetchAll();
        }catch (PDOException $exception){
            die($exception);
        }  
}
}
