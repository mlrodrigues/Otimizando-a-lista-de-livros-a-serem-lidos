<?php

  //Caminho e nome do arquivo (se colocar só o nome do arquivo, ele deve estar na mesma pasta do PHP)
  $file = "livros.csv";

  //Abrir arquivos pra pegar posicao
  $handle = fopen("livros.csv", "r");
  $header = fgetcsv($handle, 1000, ",");
  $row = fgetcsv($handle, 1000, ",");

  while ($row = fgetcsv($handle, 1000, ",")) {
    $nota[] = array_combine($header, $row);
  }

  if(!empty($nota)){
    $tamanho = sizeof($nota)+1;
    $posicao = $tamanho + 1;
  }
  else{
    $posicao = 1;
  }

  fclose($handle);  

  //Carregar o arquivo existente
  $current = file_get_contents($file);
  if($_POST['weight'] == "Alto"){
    $weight = '3';
  }
  else if($_POST['weight'] == "Media"){
    $weight = '2';
  }
  else{
    $weight = '1';
  }

  //Criar (usando informações fornecidas pelo formulário HTML) e adicionar nova linha ao conteúdo já existente
  $current .= $posicao . "," . $_POST['book_name']. "," . $_POST['author']. "," . $_POST['pages']. "," . $weight . "\n";
  
  //Adicionar conteúdo todo ao arquivo
  file_put_contents($file, $current);

  header('location: index.php');
?>