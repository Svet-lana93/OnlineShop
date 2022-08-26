<!Doctype html>
<html>
    <head>
        <title>{{ $title }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <style>
            a.disabled {
                pointer-events: none;
                cursor: default;
                opacity: .6;
            }
            .color-red {
                color: red;
            }
        </style>
    </head>
    <body>
        <main class="d-flex flex-nowrap">
            <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px; height: 100vh;">
                <span class="fs-4">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</span>
                <a href="{{ route('admins.edit', ['id' => auth()->id()]) }}">Update profile</a>
                <a href="{{ route('logout') }}">Logout</a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="{{ route('orders.statistics') }}" class="nav-link text-white">Statistics</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('orders.list') }}" class="nav-link text-white">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('products.list') }}" class="nav-link text-white">Products</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.list') }}" class="nav-link text-white">Users</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admins.list')}}" class="nav-link text-white">Admins</a>
                    </li>
                </ul>
            </div>
            <div class="container p-2">
                <h2 class="text-center">{{ $title }}</h2>
                {{ $slot }}
            </div>
        </main>
    </body>
</html>
