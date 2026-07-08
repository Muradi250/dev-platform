<!DOCTYPE html>
<html>
<head>
    <title>Account Status</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            height: 100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .box {
            background:white;
            padding:40px;
            width:450px;
            text-align:center;
            border-radius:15px;
            box-shadow:0 5px 20px #ddd;
        }

        .icon {
            font-size:50px;
        }

        a {
            display:inline-block;
            margin-top:20px;
            text-decoration:none;
        }
    </style>

</head>

<body>

<div class="box">

@switch($status)

    @case('pending')

        <div class="icon">⏳</div>

        <h2>Account Pending</h2>

        <p>
            Your account is waiting for approval by the administrator.
            Please wait until your account is activated.
        </p>

        @break


    @case('suspended')

        <div class="icon">⚠️</div>

        <h2>Account Suspended</h2>

        <p>
            Your account has been suspended.
            Please contact administrator.
        </p>

        @break


    @case('banned')

        <div class="icon">🚫</div>

        <h2>Account Banned</h2>

        <p>
            Your account has been banned.
            Please contact support.
        </p>

        @break


    @case('active')

        <div class="icon">✅</div>

        <h2>Account Active</h2>

        <p>
            Your account is active.
        </p>

        @break


    @default

        <div class="icon">❌</div>

        <h2>Unknown Account Status</h2>

        <p>
            Your account status is not recognized.
            Please contact administrator.
        </p>

@endswitch


<hr>

<p>
    <strong>Support Email:</strong>
    <br>
    {{ $supportEmail }}
</p>


<a href="{{ route('login') }}">
    Return to Login
</a>


</div>

</body>
</html>