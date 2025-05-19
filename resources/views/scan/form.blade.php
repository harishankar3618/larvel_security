<!DOCTYPE html>
<html>
<head>
    <title>Scan Form</title>
</head>
<body>
    <h1>Scan a Target</h1>
    <form action="{{ route('scan.submit') }}" method="POST">
        @csrf
        <label for="target_url">Target URL:</label>
        <input type="text" name="target_url" id="target_url" required>
        <button type="submit">Scan</button>
    </form>
</body>
</html>
