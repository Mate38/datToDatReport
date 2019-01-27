@extends('layout.template')

@section('title', 'Gerador de relatórios')

@section('css')
@endsection

@section('content')
	<div class="row">
	
		<div class="container col-md-4">
			<h3>Arquivos de entrada</h3>
			<p>...</p>            
			<table class="table table-hover">
				<thead class="thead-light">
					<tr>
						<th>Nome do arquivo</th>
						<th>Excluir arquivo</th>
					</tr>
				</thead>
				<tbody>
					@foreach($files_in as $file_in)
						<tr>
							<td>{{ $file_in }}</td>
							<td>
								<a class="btn-sm btn-danger" href="delete/{{$file_in}}" role="button">Excluir</a>
							</td>
						</tr> 
					@endforeach
				</tbody>
			</table>

			<div>
				<form action="" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="file" name="files[]" accept=".dat" multiple>
					<input type="submit">
				</form>
				<small>
					Formato suportado: .dat <br>
					Tamanho máximo: 20mb
				</small>
        <div>
          <a class="btn btn-primary" href="data" role="button">Processar dados</a>
				  <a class="btn btn-danger" href="clean" role="button">Esvaziar pasta</a>
        </div>
			</div>

		</div>

		<div class="container col-md-4">
			<h3>Dados processados</h3>
			<p>...</p>            
			<table class="table table-hover">
				<thead class="thead-light">
					<tr>
						<th>Nome do arquivo</th>
						<th>Relatório</th>
					</tr>
				</thead>
				<tbody>
					@foreach($files_out as $file_out)
						<tr>
							<td>{{ $file_out }}</td>
							<td>
							<a class="btn-sm btn-info" href="report/{{$file_out}}" target="_blank" role="button">Gerar</a>
							</td>
						</tr> 
					@endforeach
				</tbody>
			</table>
		</div>

	</div>
@endsection

@section('js')
@endsection