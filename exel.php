<?php
require_once('db/conexao.php');
$slq = "SELECT * FROM pedidos";
$stmt = mysqli_query($conn, $slq);
$data = [];
$i = 0;

while($row = mysqli_fetch_assoc($stmt)){
    $data[$i]['codPedidos'] = $row['codPedidos'];
    $data[$i]['titulo_produto'] = $row['titulo_produto'];
    $data[$i]['forma_dePagamento'] = $row['forma_dePagamento'];
    $i++;
}

class Export{

  public function excel($name, $fileName, $data){
      // nome do arquivo
      $fileName = $fileName . '.xls';
      // Abrindo tag tabela e criando título da tabela
      $html = '';
      $html .= '<table border="1">';
      $html .= '<tr>';
      $html .= '<th colspan="' . count($data) . '">' . $name . '</th>';
      $html .= '</tr>';
      // criando cabeçalho
      $html .= '<tr>';
      foreach ($data[0] as $k => $v){
          $html .= '<th>' . ucfirst($k) . '</th>';
      }
      $html .= '</tr>';
      // criando o conteúdo da tabela
      for($i=0; $i < count($data); $i++){
          $html .= '<tr>';
          foreach ($data[$i] as $k => $v){
              $html .= '<td>' . $v . '</td>';
          }
          $html .= '</tr>';
      }
      $html .= '</table>';

      // configurando header para download
      header("Content-Description: PHP Generated Data");
      header("Content-Type: application/x-msexcel");
      header("Content-Disposition: attachment; filename=\"{$fileName}\"");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Pragma: no-cache");
      // envio conteúdo
      echo $html;
      exit;
  }

  public function xml($data){

  }
}
$export = new Export();

if(isset($_GET['export']) && $_GET['export'] == 'excel'){
    $export->excel('Lista de Contatos', $_GET['fileName'], $data);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Exportando dados com PHP</title>
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
    </head>
    <body>

    <div class="container">
        <div class="row">
            <h1>Lista de contatos</h1>
        </div>
        <div class="row">
            <buttom class="dropdown-button btn right" data-activates="btn-export">Exportar</buttom>
            <ul id="btn-export" class="dropdown-content" style="margin-top: 40px;">
                <li><a href="?export=excel&&fileName=contatos">Excel</a></li>
            </ul>
        </div>
        <div class="row">
            <table class="bordered highlight">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $row): ?>
                        <tr>
                            <td><?php echo $row['codPedidos'];  ?></td>
                            <td><?php echo $row['titulo_produto'];  ?></td>
                            <td><?php echo $row['forma_dePagamento'];  ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
    </body>
</html>