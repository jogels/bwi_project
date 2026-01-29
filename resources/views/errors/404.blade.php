<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BWI | 404</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      margin: 0;
      padding: 0;
      background: #fafafa;
      display: flex;
      min-height: 100vh;
      align-items: center;
      justify-content: center;
    }
    
    .error-card {
      background: white;
      border-radius: 8px;
      padding: 48px;
      text-align: center;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      max-width: 400px;
      width: 90%;
    }

    .error-icon {
      font-size: 64px;
      color: #f44336;
      margin-bottom: 24px;
    }

    h1 {
      font-size: 24px;
      color: rgba(0,0,0,0.87);
      margin: 0 0 16px;
      font-weight: 500;
    }

    p {
      color: rgba(0,0,0,0.6);
      margin: 0 0 32px;
      line-height: 1.5;
    }

    .buttons {
      display: flex;
      gap: 16px;
      justify-content: center;
    }

    .btn {
      padding: 8px 24px;
      border-radius: 4px;
      font-weight: 500;
      text-transform: uppercase;
      text-decoration: none;
      letter-spacing: 0.5px;
      transition: background 0.2s;
    }

    .btn-primary {
      background: #2196f3;
      color: white;
    }

    .btn-primary:hover {
      background: #1976d2;
    }

    .btn-secondary {
      background: #e3f2fd;
      color: #2196f3;
    }

    .btn-secondary:hover {
      background: #bbdefb;
    }
  </style>
</head>
<body>
  <div class="error-card">
    <span class="material-icons error-icon">error_outline</span>
    <h1>Page Not Found</h1>
    <p>The page you are looking for might have been removed or is temporarily unavailable.</p>
    <div class="buttons">
      <a href="javascript:history.go(-1)" class="btn btn-secondary">Go Back</a>
      <a href="{{ url('/') }}" class="btn btn-primary">Home</a>
    </div>
  </div>
</body>
</html>
