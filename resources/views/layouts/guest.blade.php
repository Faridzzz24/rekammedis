<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk — MedRecord Sistem Rekam Medis</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #f8f9fb;
            color: #1a1a2e;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 16px;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
            margin: 0 auto;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .auth-card {
            background: #ffffff;
            border: 1px solid #e8eaed;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 32px 28px;
        }

        .auth-title {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 6px;
        }

        .auth-subtitle {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 24px;
        }

        .input-group {
            position: relative;
            margin-bottom: 18px;
        }

        .input-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .input-field-wrapper {
            position: relative;
        }

        .input-field-wrapper i.icon-prefix {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 14px;
        }

        .input-control {
            width: 100%;
            padding: 10px 14px 10px 40px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            font-size: 14px;
            color: #1a1a2e;
            background: #ffffff;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .input-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }

        .btn-submit {
            width: 100%;
            padding: 11px 16px;
            background: linear-gradient(135deg, #4f46e5, #4338ca);
            color: #ffffff;
            border: none;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #4338ca, #3730a3);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .demo-accounts {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e8eaed;
        }

        .demo-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #9ca3af;
            font-weight: 600;
            margin-bottom: 10px;
            text-align: center;
        }

        .demo-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            justify-content: center;
        }

        .demo-chip {
            padding: 5px 10px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 11px;
            color: #4b5563;
            cursor: pointer;
            transition: all 0.15s;
            font-weight: 500;
        }

        .demo-chip:hover {
            background: #eef2ff;
            color: #4f46e5;
            border-color: #c7d2fe;
        }

        .auth-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #9ca3af;
        }

        @media (max-width: 480px) {
            body { padding: 12px; }
            .auth-card { padding: 24px 18px; border-radius: 14px; }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <a href="/">
                <x-application-logo />
            </a>
        </div>

        <div class="auth-card">
            {{ $slot }}
        </div>

        <div class="auth-footer">
            &copy; {{ date('Y') }} MedRecord — Transfer Rekam Medis Digital
        </div>
    </div>
</body>
</html>
