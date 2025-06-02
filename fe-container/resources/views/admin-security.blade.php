<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Security Setup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h3 class="card-title mb-4 text-center">Admin Security Setup</h3> 
<div>
    <p>{{ session('success') }}. Please set up security settings for your admin account.</p>
    <p> <strong>Username:</strong> {{ session('username') }} | <strong>Email:</strong> {{ session('email') }}<br> </p>
</div>
                <form method="POST" action="/AdminSecuritySetup">

                    <input type="hidden" name="admin_id" value="{{ session('admin_id') }}">
                    <input type="hidden" name="username" value="{{ session('username') }}">
                    <input type="hidden" name="email" value="{{ session('email') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" name="dob" id="dob" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="security_question" class="form-label">Security Question</label>
                        <input type="text" name="security_question" id="security_question" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="security_answer" class="form-label">Security Answer</label>
                        <input type="text" name="security_answer" id="security_answer" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Set Security</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (optional, for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>


