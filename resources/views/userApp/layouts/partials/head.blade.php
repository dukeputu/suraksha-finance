

<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">
    <title>@yield('title', 'MLM App')</title>
    <link rel="stylesheet" href="{{ asset('userApp/assets/css/style.css')}}">


<style>
.appBottomMenu {
    display: none;
}

.form-group.basic .form-control,
        .form-group.basic .custom-select {
            padding: 0 15px 0 15px;
            border-radius: 10px;
            /* background: #f1f1f1; */

        }
</style>

</head>

<body>

    <!-- loader -->
    <div id="loader">
        <img src="{{ url('userApp/assets/goldCoin.webp')}}" alt="icon" class="loading-icon">
    </div>
    <!-- * loader -->
