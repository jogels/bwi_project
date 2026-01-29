<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Atonergi</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
  <link rel="stylesheet" href="{{asset('assets/node_modules/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/node_modules/perfect-scrollbar/dist/css/perfect-scrollbar.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <link rel="shortcut icon" href="{{asset('assets/atonergi-mini.png')}}" />
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background: #fafafa;
      margin: 0;
      padding: 0;
    }
    .error-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .error-card {
      background: white;
      border-radius: 8px;
      padding: 48px;
      box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
      text-align: center;
      max-width: 500px;
      width: 100%;
    }
    .error-title {
      font-size: 120px;
      font-weight: 700;
      color: #1976d2;
      margin: 0;
      line-height: 1;
    }
    .error-subtitle {
      font-size: 24px;
      color: #424242;
      margin: 16px 0;
      font-weight: 500;
    }
    .error-text {
      color: #757575;
      font-size: 16px;
      margin-bottom: 32px;
    }
    .error-button {
      background: #1976d2;
      color: white;
      padding: 12px 24px;
      border-radius: 4px;
      text-decoration: none;
      text-transform: uppercase;
      font-weight: 500;
      letter-spacing: 0.5px;
      transition: background 0.3s ease;
      border: none;
      cursor: pointer;
    }
    .error-button:hover {
      background: #1565c0;
    }
  </style>
</head>

<body>
  <div class="error-container">
    <div class="error-card">
      <h1 class="error-title">404</h1>
      <h2 class="error-subtitle">Page Not Found</h2>
      <p class="error-text">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
      <a class="error-button" href="{{ url()->previous() }}">
        <span class="mdi mdi-arrow-left"></span> Go Back
      </a>
    </div>
  </div>

  <script src="{{asset('assets/node_modules/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('assets/node_modules/popper.js/dist/umd/popper.min.js')}}"></script>
  <script src="{{asset('assets/node_modules/bootstrap/dist/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/node_modules/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/off-canvas.js')}}"></script>
  <script src="{{asset('assets/js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('assets/js/misc.js')}}"></script>
  <script src="{{asset('assets/js/settings.js')}}"></script>
  <script src="{{asset('assets/js/todolist.js')}}"></script>
</body>
</html>
