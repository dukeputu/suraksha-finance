<!DOCTYPE html>
<html>
<head>
    <title>Member Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f1f2f7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            margin-top: 12vh;
        }

        .card {
            border: none;
            border-radius: 1rem;
        }

        .card-header {
            border-radius: 1rem 1rem 0 0;
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .btn-block {
            border-radius: 0.5rem;
        }

        @media (max-width: 576px) {
            .card-header h4 {
                font-size: 1.3rem;
            }

            .form-group label {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<div class="container login-container">
    <div class="card shadow-lg">
        <center><img class="my-3" width="100" src="{{ url('userApp/assets/goldoffLogo.webp')}}" alt=""></center>
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">Member Login</h4>
        </div>
        <div class="card-body">
            {{-- Show session errors --}}
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('member.login') }}">
                @csrf
                <div class="form-group">
                    <label for="member_id">Member ID</label>
                    <input type="text" name="member_id" class="form-control" placeholder="Enter Member ID" value="{{ old('member_id') }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">🔐 Login</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
