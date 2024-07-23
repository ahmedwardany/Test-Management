<!DOCTYPE html>
<html>
<head>
    <title>Upload and Map Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Upload and Map Data</h1>
    <form action="{{ route('admin.import') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="file">Uploaded File:</label>
            <input type="hidden" name="file_path" value="{{ session('uploaded_file_path') }}">
            <input type="text" class="form-control" value="{{ basename(session('uploaded_file_path')) }}" disabled>
        </div>

        <div class="form-group mt-3">
            <label for="mapping">Map Columns:</label>
            @if(isset($headings))
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            @foreach ($headings[0][0] as $heading)
                                <th>{{ $heading }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($headings[0][0] as $index => $heading)
                                <td>
                                    <select name="mapping[{{ $index }}]" class="form-control">
                                        <option value="0">Ignore</option>
                                        <option value="1">Full Name</option>
                                        <option value="2">Phone Number</option>
                                        <option value="3">Email</option>
                                    </select>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
        <button type="submit" class="btn btn-primary mt-3">Import</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
