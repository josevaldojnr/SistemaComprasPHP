<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisitions</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Existing Requisitions</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Sector</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requisitions as $requisition)
                <tr>
                    <td>{{ $requisition->id }}</td>
                    <td>{{ $requisition->sector->name }}</td>
                    <td>{{ $requisition->created_at }}</td>
                    <td>
                        <a href="{{ route('requisitions.show', $requisition->id) }}">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>