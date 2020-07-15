<?php
    require_once 'classePessoa.php';

    $p = new Pessoa("crudpdo","localhost","root","");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Cadastro Pessoa</title>
</head>
<body>
    <?php 
        if(isset($_POST['nome'])){

            if(isset($_GET['id_up']) && !empty($_GET['id_up'])){
                $id_upd = addslashes($_GET['id_up']);
                $nome = addslashes($_POST['nome']);
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);
    
                if(!empty($nome) && !empty($telefone) && !empty($email)){
                    

                    if(!$p->atualizarDados($id_upd, $nome, $telefone, $email)){
                        echo "Email já cadastrado!";
                    } else {
                        header("location: index.php");
                    }
                }
                else {
                ?>  
                    <div class="aviso">
                        <img src="img/aviso.png" alt="aviso">
                        <h4>Preencha todos os campos</h4>
                    </div> 
                <?php
                }
            }else {
                $nome = addslashes($_POST['nome']);
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);
    
                if(!empty($nome) && !empty($telefone) && !empty($email)){
                    if(!$p->cadastrarPessoa($nome, $telefone, $email)){
                    ?>  
                        <div class="aviso">
                            <img src="img/aviso.png" alt="aviso">
                            <h4>Email já cadastrado! <span title="Fechar" id="fechar">X</span></h4>
                        </div> 
                    <?php
                    }
                }
                else {
                ?>
                    <div class="aviso">
                    <img src="img/aviso.png" alt="aviso">
                    <h4>Preencha todos os campos! <span title="Fechar" id="fechar">X</span></h4>
                </div> 
                <?php
                }
            }

        }
    ?>
    <?php
        if(isset($_GET['id_up'])){
            $id_update = addslashes($_GET['id_up']);
            $res = $p->buscarDadosPessoa($id_update);
        }
    ?>
    <section id="esquerda">
        <form method="POST">
            <h2>CADASTRAR PESSOA</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?php if(isset($res)) { echo  $res['nome'];} ?>">

            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" value="<?php if(isset($res)) { echo  $res['telefone'];} ?>">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php if(isset($res)) { echo  $res['email'];} ?>">

            <input type="submit" value="<?php if(isset($res)) { echo "Atualizar";} else { echo "Cadastrar" ;} ?> ">
            <input type="submit" href="index.php" value="Cancelar">
        </form>
    </section>
    <section id="direita">
    <table>
        <tr id="titulo">
            <td>NOME</td>
            <td>TELEFONE</td>
            <td>EMAIL</td>
            <td>Ações</td>
        </tr>
        <?php $dados = $p->buscarDados(); 
            if(count($dados) > 0) {
                for($i=0; $i < count($dados); $i++){
                    echo "<tr>";
                        foreach($dados[$i] as $key => $value) {
                            if($key != "id") {
                                echo "<td> $value </td>";
                            }
                        }
                    ?>
                        <td>
                            <a href="index.php?id_up=<?php echo $dados[$i]['id']; ?>">Editar</a>
                            <a href="index.php?id=<?php echo $dados[$i]['id']; ?>">Excluir</a>
                        </td> 
                    <?php
                    echo "</tr>";
                }

            }else {
            ?>  
            <div class="aviso" id="nopeople">
                <h4>Ainda não há pessoas Cadastrada!</h4>
            </div> 
            <?php  
            }
        ?>
        </table>
    </section>
</body>
<Script src="js/style.js"></Script>
</html>

<?php
    if(isset($_GET['id'])){
        $id_pessoa = addslashes($_GET['id']);
        $p->excluirPessoa($id_pessoa);
        header("location: index.php");
    }
?>
