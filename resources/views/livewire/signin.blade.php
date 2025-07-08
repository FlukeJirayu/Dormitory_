<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ - Visitor Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .signin-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .app-icon {
            width: 80px;
            height: 80px;
            background: #4285f4;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 8px 20px rgba(66, 133, 244, 0.3);
        }

        .app-icon i {
            font-size: 40px;
            color: white;
        }

        .signin-title {
            text-align: center;
            color: #333;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .signin-subtitle {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 16px;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .form-control:focus {
            border-color: #4285f4;
            box-shadow: 0 0 0 0.2rem rgba(66, 133, 244, 0.25);
        }

        .btn-signin {
            background: #4285f4;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px 0;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .btn-signin:hover {
            background: #3367d6;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(66, 133, 244, 0.4);
        }

        .btn-signin:active {
            transform: translateY(0);
        }

        .copyright {
            text-align: center;
            color: #999;
            font-size: 12px;
            margin-top: 20px;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid #f5c6cb;
        }

        .field-error {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }

        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .loading .btn-signin {
            background: #6c757d;
        }

        .loading .spinner {
            display: inline-block;
            margin-right: 8px;
        }

        @media (max-width: 576px) {
            .signin-container {
                margin: 20px;
                padding: 30px 20px;
            }
        }
    </style>
    @livewireStyles
</head>
<body>
    <div class="signin-container">
        <div class="app-icon">
            <i class="fas fa-id-card"></i>
        </div>
        
        <h2 class="signin-title">เข้าสู่ระบบ</h2>
        <p class="signin-subtitle">ระบบจัดการหอพัก</p>

        <form wire:submit.prevent="signin">
            @if($error)
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ $error }}
                </div>
            @endif

            <div class="mb-3">
                <input 
                    type="text" 
                    class="form-control @error('username') is-invalid @enderror" 
                    placeholder="ชื่อผู้ใช้"
                    wire:model="username"
                    autocomplete="username"
                >
                @if($errorUsername)
                    <div class="field-error">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        {{ $errorUsername }}
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <input 
                    type="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    placeholder="รหัสผ่าน"
                    wire:model="password"
                    autocomplete="current-password"
                >
                @if($errorPassword)
                    <div class="field-error">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        {{ $errorPassword }}
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-signin" wire:loading.attr="disabled">
                <div wire:loading class="spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <span wire:loading.remove>เข้าสู่ระบบ</span>
                <span wire:loading>กำลังเข้าสู่ระบบ...</span>
            </button>
        </form>

        <div class="copyright">
            © 2025 Visitor Management System
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>