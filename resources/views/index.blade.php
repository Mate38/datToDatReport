<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
</head>
<body>

  <div class="container">

    @if(session()->has('message'))
      <div class="callout callout-danger">
        {{ session()->get('message') }}
      </div>
    @endif

    <h2>Arquivos de entrada</h2>
    <p>...</p>            
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th>Nome do arquivo</th>
        </tr>
      </thead>
      <tbody>
          @foreach($files as $file)
            <tr>
              <td>{{ $file }}</td>
            </tr> 
          @endforeach
      </tbody>
    </table>
  </div>
  <div class="container">
    <form action="" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="file" accept=".dat">
        <input type="submit">
    </form>
    <p>
      Formato suportado: .dat <br>
      Tamanho máximo: 10mb
    </p>

    <a class="btn btn-primary" href="report" target="_blank" role="button">Processar e gerar relatório</a>
  </div>

</body>
</html>