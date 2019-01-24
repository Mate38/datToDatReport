@foreach($files as $file)
  <p>{{ $file->getFilename() }}</p>
@endforeach