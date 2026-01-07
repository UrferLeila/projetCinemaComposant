<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* ------------------------- */
    /* General Body */
    body {
        background: #0a2636;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: white;
        margin: 0;
        padding: 0;
    }

    /* ------------------------- */
    /* Card */
    .register-card {
        background: #1f1f1f;
        border-radius: 20px;
        padding: 30px;
        border: 1px solid #205281;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Titles */
    .register-card h2 {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 10px;
        text-align: center;
    }

    .register-subtitle {
        color: #a3a3a3;
        font-size: 14px;
        margin-bottom: 25px;
        text-align: center;
    }

    /* ------------------------- */
    /* Labels */
    .form-label,
    .form-check-label {
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
        color: white !important;
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 15px;
        /* consistent spacing between fields */
    }

    /* ------------------------- */
    /* Inputs */
    .form-control {
        width: 100%;
        padding: 10px 14px;
        /* control vertical spacing */
        font-size: 14px;
        line-height: 1.3;
        /* tighter text spacing */
        border-radius: 10px;
        border: 1px solid #205281;
        background: #0a2636;
        color: white;
        outline: none;
        transition: all 0.3s ease;
        caret-color: white;
        /* cursor color */
        height: 50;
        /* prevent Bootstrap default height */
    }

    /* Placeholder Text */
    .form-control::placeholder {
        color: #ffffff;
        opacity: 0.7;
        /* slightly lighter than input text */
    }

    /* Focused Inputs */
    .form-control:focus {
        border-color: #3586d1 !important;
        box-shadow: 0 0 8px rgba(52, 152, 219, 0.3);
        background: #0a2636;
        color: white !important;
        caret-color: white;
        /* cursor stays white */
    }

    /* ------------------------- */
    /* Buttons */
    .btn-register {
        width: 150px;
        padding: 12px;
        border-radius: 12px;
        border: none;
        font-size: 16px;
        font-weight: bold;
        background-color: rgb(207, 42, 42);
        color: white;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(207, 42, 42, 0.5);
    }

    /* ------------------------- */
    /* Links */
    .register-link {
        color: #3586d1;
        font-size: 14px;
        text-decoration: underline;
    }

    .register-link:hover {
        color: #5fa8ff;
    }

    /* ------------------------- */
    /* Error Messages */
    .text-danger {
        font-size: 13px;
        margin-top: 4px;
    }
</style>