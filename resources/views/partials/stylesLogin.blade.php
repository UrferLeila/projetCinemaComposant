<link href=https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    body {
        background: #0a2636;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Login Card */
    .login-card {
        background: #1f1f1f;
        border-radius: 20px;
        padding: 30px;
        border: 1px solid #205281;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Titles */
    .login-card h2 {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .login-subtitle {
        color: #a3a3a3;
        font-size: 14px;
        margin-bottom: 25px;
    }

    /* Inputs */
    .form-control {
        background: #0a2636 !important;
        border: 1px solid #205281 !important;
        border-radius: 10px;
        color: white !important;
        padding: 12px 14px;
        transition: all 0.3s ease;
        height: 50;

    }

    .form-control::placeholder {
        color: #a3a3a3 !important;
    }

    .form-control:focus {
        outline: none;
        border-color: #3586d1 !important;
        box-shadow: 0 0 8px rgba(52, 152, 219, 0.3) !important;
        background: #0a2636;
    }

    /* Labels */
    .form-label,
    .form-check-label {
        color: white !important;
        font-size: 14px;
    }

    /* Checkbox */
    .form-check-input {
        background-color: #0a2636;
        border: 1px solid #205281;
    }

    .form-check-input:checked {
        background-color: rgb(207, 42, 42);
        border-color: rgb(207, 42, 42);
    }

    /* Login Button */
    .btn-login {
        width: 150;
        padding: 12px;
        border-radius: 12px;
        border: none;
        font-size: 16px;
        font-weight: bold;
        background-color: rgb(207, 42, 42);
        color: white;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(207, 42, 42, 0.5);
    }

    /* Links */
    .login-link {
        color: #3586d1;
        font-size: 14px;
        text-decoration: underline;
        cursor: pointer;
    }

    .login-link:hover {
        color: #5fa8ff;
    }
</style>