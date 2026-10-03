<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — IXORA</title>
    <style>
        :root{--bg:#f7f4ef;--ink:#163528;--accent:#c85a32}
        *{box-sizing:border-box}
        body{margin:0;font-family:system-ui,sans-serif;background:var(--bg);color:var(--ink)}
        .shell{display:grid;grid-template-columns:220px 1fr;min-height:100vh}
        aside{background:#163528;color:#e8d3a4;padding:1.25rem}
        aside a{display:block;color:#e8d3a4;text-decoration:none;padding:.4rem 0;font-size:.92rem}
        aside a:hover{color:#fff}
        main{padding:1.5rem}
        .flash{background:#e8f5e9;padding:.75rem 1rem;border-radius:8px;margin-bottom:1rem}
        table{width:100%;border-collapse:collapse;background:#fff}
        th,td{padding:.65rem .75rem;border-bottom:1px solid #eee;text-align:left;font-size:.92rem}
        .btn{display:inline-block;background:var(--accent);color:#fff;padding:.45rem .8rem;border-radius:6px;text-decoration:none;border:0;cursor:pointer}
        h1{margin-top:0}
        @media(max-width:800px){.shell{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div class="shell">
    <aside>
        <strong style="letter-spacing:.12em">IXORA</strong>
        <nav style="margin-top:1.25rem">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.pages.index') }}">Pages</a>
            <a href="{{ route('admin.media.index') }}">Media</a>
            <a href="{{ route('admin.bookings.index') }}">Bookings</a>
            <a href="{{ route('admin.enquiries.index') }}">Enquiries</a>
            <a href="{{ route('admin.reviews.index') }}">Reviews</a>
            <a href="{{ route('admin.settings.index') }}">Settings</a>
            <a href="{{ route('admin.redirects.index') }}">Redirects</a>
            <a href="{{ route('admin.users.index') }}">Users</a>
            <a href="{{ route('admin.activity-logs.index') }}">Activity</a>
            <form method="post" action="{{ route('admin.logout') }}" style="margin-top:1rem">@csrf<button class="btn" type="submit">Logout</button></form>
        </nav>
    </aside>
    <main>
        @if(session('success'))<div class="flash">{{ session('success') }}</div>@endif
        @yield('content')
    </main>
</div>
</body>
</html>
