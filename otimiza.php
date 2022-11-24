<?php 
  function getCSVResult() {
    $handle = fopen("reading_list.csv", "r");
    $header = fgetcsv($handle, 1000, ",");
    $row = fgetcsv($handle, 1000, ",");

    while ($row = fgetcsv($handle, 1000, ",")) {
      if($row[5] == "1.0"){
        $result[] = array_combine($header, $row);
      }
    }
    fclose($handle);
    if(!empty($result))
      return $result;    
  }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Otimiza Livros</title>
  <meta name="viewport" content="width=device-width">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
  <script src="assets/js/main.js"></script>
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/navbar.css" rel="stylesheet">
</head>
<body>
  <header class="container mt-md-5 mt-sm-0">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="./index.php">ESTANTE</a>
            </li>
          </ul>
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="./otimiza.php">OTIMIZAR LIVROS</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <main class="container content-container">
    <?php $results = getCSVResult();?>
     <div class="row">
      <h2 class="titulo">Lista de livros para ler</h2>
      <section class="col-8">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">LIVROS</th>
              <th scope="col">PÁGINAS</th>
              <th scope="col">PESO</th>
            </tr>
          </thead>
          <?php if(!empty($results)){?>
            <tbody>
              <?php foreach ($results as $result) {?>           
                <tr>
                  <td><?php echo($result['book_name']) ?></td>
                  <td><?php echo($result['pages']) ?></td>
                  <td><?php echo($result['weight']) ?></td>
                </tr>
              <?php }?>
            </tbody>
          <?php }?>  
        </table>
      </section>

      <section class="col-4">
        <form action="rodar.php" method="post" >
          <div class="form-group pb-3">
            <label class="pb-1" for="freehour">Horas livre por semana</label>
            <input type="number" for="freehour" name="freehour"class="form-control" id="exampleInputbook">
          </div>
          <div class="form-group pb-3">
            <label class="pb-1" for="paginasperhour">Páginas lidas por hora</label>
            <input type="number" for="paginasperhour" name="paginasperhour" class="form-control" id="exampleInputpages">
          </div>

          <div class="form-group pb-3">
            <label class="pb-1" for="months">Período de leitura em meses</label>
            <input type="number" for="months" name="months" class="form-control" id="exampleInputpages">
          </div>
          <button type="submit" class="btn btn-primary">Rodar</button>
        </form>
      </section>
    </div>
  </main>
</body>
</html>