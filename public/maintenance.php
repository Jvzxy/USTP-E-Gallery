<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance - USTP E-Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { 
            background-color: #f8f9fa; 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            color: #333;
        }
        .maintenance-icon {
            font-size: 5rem;
            color: #1A1851;
            margin-bottom: 20px;
        }
        h1 { font-weight: 900; color: #1A1851; }
        .back-btn {
            background-color: #1A1851;
            color: white;
            font-weight: bold;
            padding: 10px 30px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.2s;
            display: inline-block;
            margin-top: 30px;
        }
        .back-btn:hover {
            background-color: #2a2775;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container px-4">
        <i class="bi bi-tools maintenance-icon"></i>
        <h1>We'll be right back!</h1>
        <p class="lead text-muted mt-3 max-w-50 mx-auto">
            The USTP E-Gallery is currently undergoing scheduled maintenance to improve your experience. 
            Please check back again shortly.
        </p>
        
        <a href="login.php" class="back-btn shadow-sm">Go back to login</a>
    </div>
</body>
</html>