<!DOCTYPE html>
<html>
<head>
    <title>Admin Tool</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="card mt-3 mb-3">
        <div class="card-header text-center">
            <h4>User Management</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.upload') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Upload Excel File</label>
                    <input type="file" name="file" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>

            <form action="{{ route('admin.export') }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label for="columns" class="form-label">Select Columns to Export</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="columns[]" value="id" id="id">
                        <label class="form-check-label" for="id">ID</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="columns[]" value="fullname" id="fullname">
                        <label class="form-check-label" for="fullname">Full Name</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="columns[]" value="phone_number" id="phone_number">
                        <label class="form-check-label" for="phone_number">Phone Number</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="columns[]" value="email" id="email">
                        <label class="form-check-label" for="email">Email</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Export Selected Columns</button>
            </form>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
