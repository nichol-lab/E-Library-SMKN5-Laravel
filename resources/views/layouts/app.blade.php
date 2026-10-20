```php
@php
    $currentUser = \App\Models\User::find(session('user_id'));
    $role = $currentUser?->role ?? '';
    $userName = $currentUser?->name ?? 'Pengguna';
    $initial = strtoupper(substr($userName, 0, 1));
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard') - E-Library 5</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('book-icon.jpg') }}">

    <style>
        :root {
            --green: #285C45;
            --green-dark: #1B4231;
            --green-light: #EAF5EE;
            --sage: #72B995;
            --pink: #F4C5D8;
            --pink-light: #FFF0F5;
            --white: #FFFFFF;
            --cream: #FFF9FC;
            --text: #244D39;
            --muted: #809488;
            --border: #E3EEE7;
            --danger: #B94360;
            --danger-bg: #FFF0F5;
            --warning: #A86B13;
            --warning-bg: #FFF5DF;
            --shadow: 0 12px 35px rgba(40, 92, 69, .07);
            --shadow-hover: 0 18px 40px rgba(40, 92, 69, .12);
            --radius: 18px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: var(--text);
            background:
                radial-gradient(ellipse at 90% 0%, rgba(244, 197, 216, .18), transparent 34%),
                radial-gradient(ellipse at 5% 95%, rgba(114, 185, 149, .10), transparent 32%),
                var(--cream);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button, input, select, textarea {
            font: inherit;
        }

        button {
            border: 0;
        }

        ul {
            list-style: none;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1000;
            width: 258px;
            padding: 22px 15px 16px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            background: rgba(255, 255, 255, .94);
            border-right: 1px solid var(--border);
            box-shadow: 8px 0 35px rgba(40, 92, 69, .025);
            transition: transform .25s ease;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 2px 9px 25px;
            margin-bottom: 13px;
            border-bottom: 1px solid var(--border);
        }

        .brand-logo {
            width: 47px;
            height: 47px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 15px;
            background: white;
            box-shadow: 0 5px 15px rgba(40, 92, 69, .09);
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .brand-title {
            display: block;
            font-size: 15px;
            font-weight: 850;
            letter-spacing: -.4px;
            color: var(--green);
        }

        .brand-subtitle {
            display: block;
            margin-top: 3px;
            color: var(--muted);
            font-size: 9px;
        }

        .sidebar-section {
            margin-top: 12px;
        }

        .sidebar-label {
            padding: 8px 12px;
            color: #98A99E;
            font-size: 9px;
            font-weight: 850;
            letter-spacing: 1.3px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 44px;
            padding: 10px 12px;
            color: #64796C;
            font-size: 12px;
            font-weight: 650;
            border: 1px solid transparent;
            border-radius: 12px;
            transition: background .2s ease, color .2s ease, transform .2s ease;
        }

        .sidebar-link:hover {
            color: var(--green);
            background: var(--pink-light);
            transform: translateX(2px);
        }

        .sidebar-link.active {
            color: var(--green);
            font-weight: 800;
            background: linear-gradient(110deg, #EAF5EE, #F1F8F3);
            border-color: #E1EEE5;
        }

        .sidebar-link.active::before {
            position: absolute;
            left: -1px;
            top: 10px;
            bottom: 10px;
            width: 3px;
            content: "";
            background: var(--sage);
            border-radius: 0 5px 5px 0;
        }

        .sidebar-icon {
            display: grid;
            place-items: center;
            width: 23px;
            height: 23px;
            flex-shrink: 0;
            font-size: 16px;
        }

        /* SIDEBAR PROFILE */
        .sidebar-bottom {
            margin-top: auto;
            padding-top: 18px;
        }

        .mini-profile {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 11px;
            margin-bottom: 9px;
            border: 1px solid var(--border);
            border-radius: 15px;
            background: linear-gradient(125deg, #FFFFFF, #FFF8FB);
        }

        .avatar {
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            border-radius: 13px;
            color: var(--green);
            background: linear-gradient(135deg, var(--pink), #F9D9E6);
            font-size: 13px;
            font-weight: 850;
        }

        .mini-profile-info {
            min-width: 0;
        }

        .mini-profile-name {
            display: block;
            overflow: hidden;
            color: var(--green);
            font-size: 11.5px;
            font-weight: 800;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .mini-profile-role {
            display: block;
            margin-top: 2px;
            color: var(--muted);
            font-size: 10px;
            text-transform: capitalize;
        }

        .logout-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            min-height: 43px;
            padding: 10px;
            cursor: pointer;
            color: var(--danger);
            background: var(--pink-light);
            border: 1px solid #FBE4EC;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 800;
            transition: background .2s ease, transform .2s ease;
        }

        .logout-button:hover {
            background: #F9DCE7;
            transform: translateY(-1px);
        }

        /* MAIN AREA */
        .main {
            min-height: 100vh;
            margin-left: 258px;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 900;
            min-height: 82px;
            padding: 15px 34px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            background: rgba(255, 249, 252, .88);
            border-bottom: 1px solid rgba(227, 238, 231, .9);
            backdrop-filter: blur(18px);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 13px;
            min-width: 0;
        }

        .mobile-menu-button {
            display: none;
            width: 41px;
            height: 41px;
            flex-shrink: 0;
            place-items: center;
            cursor: pointer;
            color: var(--green);
            background: var(--green-light);
            border-radius: 12px;
            font-size: 19px;
        }

        .page-title {
            color: var(--green);
            font-size: 19px;
            font-weight: 850;
            letter-spacing: -.4px;
            line-height: 1.3;
        }

        .page-breadcrumb {
            margin-top: 4px;
            color: var(--muted);
            font-size: 10px;
        }

        .top-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .top-user-info {
            text-align: right;
        }

        .top-user-name {
            display: block;
            color: var(--green);
            font-size: 12px;
            font-weight: 800;
        }

        .top-user-role {
            display: block;
            margin-top: 2px;
            color: var(--muted);
            font-size: 10px;
            text-transform: capitalize;
        }

        /* PAGE CONTENT */
        .content {
            width: 100%;
            max-width: 1600px;
            padding: 32px 34px 50px;
        }

        /* GENERAL COMPONENTS */
        .welcome {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 27px;
        }

        .welcome-title {
            color: var(--green);
            font-size: clamp(22px, 2vw, 29px);
            font-weight: 900;
            line-height: 1.3;
            letter-spacing: -.8px;
        }

        .welcome-description {
            margin-top: 7px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 41px;
            padding: 10px 16px;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 12px;
            font-size: 11.5px;
            font-weight: 800;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            color: #FFFFFF;
            background: linear-gradient(135deg, var(--green), var(--green-dark));
            box-shadow: 0 7px 17px rgba(40, 92, 69, .17);
        }

        .btn-primary:hover {
            color: white;
            box-shadow: 0 10px 22px rgba(40, 92, 69, .22);
        }

        .btn-light {
            color: var(--green);
            background: var(--pink-light);
            border-color: #F5D9E4;
        }

        .btn-light:hover {
            background: var(--pink);
        }

        .btn-success {
            color: var(--green);
            background: var(--green-light);
        }

        .btn-warning {
            color: var(--warning);
            background: var(--warning-bg);
        }

        .btn-danger {
            color: var(--danger);
            background: var(--danger-bg);
        }

        /* STATISTICS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 22px;
        }

        .stat-card {
            min-width: 0;
            padding: 21px;
            background: rgba(255, 255, 255, .94);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 5px 18px rgba(40, 92, 69, .035);
            transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: #CFE4D6;
            box-shadow: var(--shadow-hover);
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
        }

        .stat-icon {
            display: grid;
            place-items: center;
            width: 41px;
            height: 41px;
            flex-shrink: 0;
            color: var(--green);
            background: var(--green-light);
            border-radius: 13px;
            font-size: 16px;
        }

        .stat-number {
            margin-top: 13px;
            color: var(--green-dark);
            font-size: 29px;
            font-weight: 900;
            letter-spacing: -.7px;
            line-height: 1;
        }

        /* CARDS */
        .card {
            min-width: 0;
            overflow: hidden;
            background: rgba(255, 255, 255, .96);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 6px 20px rgba(40, 92, 69, .035);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            min-height: 69px;
            padding: 17px 21px;
            border-bottom: 1px solid var(--border);
            flex-wrap: wrap;
        }

        .card-title {
            color: var(--green);
            font-size: 14px;
            font-weight: 850;
        }

        .card-subtitle {
            margin-top: 4px;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.6;
        }

        .card-body {
            padding: 21px;
        }

        .content-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(0, .9fr);
            gap: 20px;
            margin-bottom: 21px;
        }

        /* STATUS BADGES */
        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 26px;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
            text-transform: capitalize;
            white-space: nowrap;
        }

        .badge-pending {
            color: var(--warning);
            background: var(--warning-bg);
        }

        .badge-approved, .badge-paid {
            color: var(--green);
            background: var(--green-light);
        }

        .badge-borrowed {
            color: #9A5270;
            background: var(--pink-light);
        }

        .badge-returned {
            color: #64786D;
            background: #F2F5F3;
        }

        .badge-rejected, .badge-unpaid {
            color: var(--danger);
            background: var(--danger-bg);
        }

        /* TABLE */
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            min-width: 650px;
            border-collapse: collapse;
        }

        .data-table th {
            padding: 12px 10px;
            color: var(--muted);
            background: #FBFDFB;
            border-bottom: 1px solid var(--border);
            font-size: 9.5px;
            font-weight: 850;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .data-table td {
            padding: 14px 10px;
            color: #526B5C;
            border-bottom: 1px solid #F0F5F1;
            font-size: 11.5px;
            vertical-align: middle;
        }

        .data-table tr:last-child td {
            border-bottom: 0;
        }

        .data-table tbody tr:hover {
            background: #FFF9FC;
        }

        .table-title {
            color: var(--green);
            font-weight: 800;
        }

        .table-muted {
            margin-top: 2px;
            color: var(--muted);
            font-size: 10px;
        }

        /* TOOLBAR AND INPUTS */
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 17px;
        }

        .search-box {
            display: flex;
            gap: 8px;
            width: 100%;
            max-width: 470px;
        }

        .form-control {
            width: 100%;
            min-height: 42px;
            padding: 10px 13px;
            color: var(--green);
            background: #FFFFFF;
            border: 1px solid #DCE9E0;
            border-radius: 11px;
            outline: none;
            font-size: 12px;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .form-control::placeholder {
            color: #9AA99F;
        }

        .form-control:focus {
            border-color: var(--sage);
            box-shadow: 0 0 0 4px rgba(114, 185, 149, .14);
        }

        textarea.form-control {
            min-height: 110px;
            resize: vertical;
        }

        .form-card {
            max-width: 900px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group {
            min-width: 0;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            margin-bottom: 7px;
            color: #334F40;
            font-size: 11px;
            font-weight: 800;
        }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 9px;
            flex-wrap: wrap;
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid var(--border);
        }

        /* EMPTY STATE */
        .empty-state {
            padding: 48px 15px;
            color: var(--muted);
            text-align: center;
        }

        .empty-icon {
            display: grid;
            place-items: center;
            width: 54px;
            height: 54px;
            margin: 0 auto 13px;
            color: var(--green);
            background: linear-gradient(135deg, var(--green-light), var(--pink-light));
            border-radius: 17px;
            font-size: 21px;
        }

        .empty-state strong {
            display: block;
            margin-bottom: 5px;
            color: var(--green);
            font-size: 13px;
        }

        .empty-state span {
            font-size: 11px;
        }

        /* ALERTS */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 13px 15px;
            margin-bottom: 18px;
            border-radius: 12px;
            font-size: 12px;
            line-height: 1.6;
        }

        .alert-success {
            color: var(--green);
            background: var(--green-light);
            border: 1px solid #CDE5D5;
        }

        .alert-error {
            color: #A83250;
            background: var(--danger-bg);
            border: 1px solid var(--pink);
        }

        /* BOOK GRID */
        .book-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .book-card {
            overflow: hidden;
            min-width: 0;
            background: #FFFFFF;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            transition: transform .22s ease, box-shadow .22s ease;
        }

        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
        }

        .book-cover {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 175px;
            color: var(--green);
            background: linear-gradient(135deg, #EAF5EE, #FFF0F5);
            font-size: 40px;
        }

        .book-info {
            padding: 15px;
        }

        .book-title {
            color: var(--green);
            font-size: 13px;
            font-weight: 850;
            line-height: 1.5;
        }

        .book-author {
            margin-top: 5px;
            color: var(--muted);
            font-size: 10.5px;
        }

        .book-stock {
            margin-top: 11px;
            color: var(--green);
            font-size: 10px;
            font-weight: 800;
        }

        /* QUICK ACTIONS */
        .quick-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .quick-action {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px;
            border: 1px solid var(--border);
            border-radius: 13px;
            background: #FFFFFF;
            transition: background .2s ease, border-color .2s ease, transform .2s ease;
        }

        .quick-action:hover {
            background: var(--pink-light);
            border-color: var(--pink);
            transform: translateX(2px);
        }

        .quick-action-icon {
            display: grid;
            place-items: center;
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            color: var(--green);
            background: var(--green-light);
            border-radius: 12px;
            font-size: 15px;
        }

        .quick-action-text strong {
            display: block;
            color: var(--green);
            font-size: 11.5px;
        }

        .quick-action-text span {
            display: block;
            margin-top: 3px;
            color: var(--muted);
            font-size: 9.5px;
        }

        /* MOBILE SIDEBAR */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 950;
            background: rgba(23, 61, 45, .38);
            backdrop-filter: blur(2px);
        }

        /* RESPONSIVE */
        @media (max-width: 1250px) {
            .content {
                padding-right: 25px;
                padding-left: 25px;
            }

            .topbar {
                padding-right: 25px;
                padding-left: 25px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .book-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .sidebar {
                transform: translateX(-105%);
            }

            .sidebar.open {
                transform: translateX(0);
                box-shadow: 15px 0 40px rgba(23, 61, 45, .15);
            }

            .sidebar-overlay.active {
                display: block;
            }

            .main {
                margin-left: 0;
            }

            .mobile-menu-button {
                display: grid;
            }

            .topbar {
                min-height: 72px;
                padding: 12px 20px;
            }

            .content {
                padding: 24px 20px 40px;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .book-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            .topbar {
                padding: 12px 15px;
            }

            .content {
                padding: 21px 15px 35px;
            }

            .page-title {
                font-size: 16px;
            }

            .page-breadcrumb {
                max-width: 210px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .top-user-info {
                display: none;
            }

            .top-user .avatar {
                width: 36px;
                height: 36px;
            }

            .welcome {
                align-items: flex-start;
            }

            .welcome-title {
                font-size: 22px;
            }

            .welcome-description {
                font-size: 11px;
            }

            .stats-grid,
            .book-grid,
            .form-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-number {
                font-size: 25px;
            }

            .stat-icon {
                width: 35px;
                height: 35px;
            }

            .form-group.full {
                grid-column: 1 / -1;
            }

            .toolbar {
                align-items: stretch;
                flex-direction: column;
            }

            .search-box {
                max-width: none;
            }

            .card-header,
            .card-body {
                padding: 15px;
            }

            .card-header {
                align-items: flex-start;
            }

            .form-actions {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 380px) {
            .stats-grid,
            .book-grid {
                grid-template-columns: 1fr;
            }

            .brand-subtitle {
                white-space: normal;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
                animation-duration: .01ms !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    {{-- SIDEBAR --}}
    <aside id="sidebar" class="sidebar">
        <div class="brand">
            <div class="brand-logo">
                <img src="{{ asset('book-icon.jpg') }}" alt="Logo E-Library">
            </div>

            <div>
                <span class="brand-title">E-Library 5</span>
                <span class="brand-subtitle">SMK Negeri 5 Surakarta</span>
            </div>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Overview</div>
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="sidebar-icon">⌂</span>
                    <span>Dashboard</span>
                </a>
            </nav>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Library</div>
            <nav class="sidebar-nav">
                @if(in_array($role, ['admin', 'petugas']))
                    <a href="{{ route('books.index') }}"
                       class="sidebar-link {{ request()->routeIs('books.*') ? 'active' : '' }}">
                        <span class="sidebar-icon">▣</span>
                        <span>Data Buku</span>
                    </a>

                    <a href="{{ route('categories.index') }}"
                       class="sidebar-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <span class="sidebar-icon">▦</span>
                        <span>Kategori Buku</span>
                    </a>
                @endif

                @if($role === 'siswa')
                    <a href="{{ route('catalog') }}"
                       class="sidebar-link {{ request()->routeIs('catalog') ? 'active' : '' }}">
                        <span class="sidebar-icon">▣</span>
                        <span>Katalog Buku</span>
                    </a>
                @endif
            </nav>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Transaction</div>
            <nav class="sidebar-nav">
                @if(in_array($role, ['admin', 'petugas']))
                    <a href="{{ route('loans.index') }}"
                       class="sidebar-link {{ request()->routeIs('loans.index', 'loans.approve', 'loans.reject', 'loans.handover', 'loans.return') ? 'active' : '' }}">
                        <span class="sidebar-icon">▤</span>
                        <span>Kelola Peminjaman</span>
                    </a>
                @endif

                @if($role === 'siswa')
                    <a href="{{ route('loans.create') }}"
                       class="sidebar-link {{ request()->routeIs('loans.create') ? 'active' : '' }}">
                        <span class="sidebar-icon">＋</span>
                        <span>Ajukan Peminjaman</span>
                    </a>

                    <a href="{{ route('loans.mine') }}"
                       class="sidebar-link {{ request()->routeIs('loans.mine') ? 'active' : '' }}">
                        <span class="sidebar-icon">▤</span>
                        <span>Peminjaman Saya</span>
                    </a>
                @endif
            </nav>
        </div>

        @if($role === 'admin')
            <div class="sidebar-section">
                <div class="sidebar-label">Management</div>
                <nav class="sidebar-nav">
                    <a href="{{ route('users.index') }}"
                       class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <span class="sidebar-icon">♙</span>
                        <span>Data Pengguna</span>
                    </a>
                </nav>
            </div>
        @endif

        <div class="sidebar-section">
            <div class="sidebar-label">Account</div>
            <nav class="sidebar-nav">
                <a href="{{ route('profile.edit') }}"
                   class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <span class="sidebar-icon">◉</span>
                    <span>Profil Saya</span>
                </a>
            </nav>
        </div>

        <div class="sidebar-bottom">
            @if($currentUser)
                <div class="mini-profile">
                    <div class="avatar">{{ $initial }}</div>
                    <div class="mini-profile-info">
                        <span class="mini-profile-name">{{ $userName }}</span>
                        <span class="mini-profile-role">{{ $role }}</span>
                    </div>
                </div>
            @endif

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">
                    <span>⇥</span>
                    <span>Keluar dari akun</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- MOBILE OVERLAY --}}
    <div id="sidebarOverlay" class="sidebar-overlay"></div>

    {{-- MAIN --}}
    <main class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button
                    type="button"
                    id="mobileMenuButton"
                    class="mobile-menu-button"
                    aria-label="Buka menu navigasi"
                    aria-controls="sidebar"
                    aria-expanded="false">
                    ☰
                </button>

                <div>
                    <div class="page-title">@yield('header', 'Dashboard')</div>
                    <div class="page-breadcrumb">E-Library · SMK Negeri 5 Surakarta</div>
                </div>
            </div>

            @if($currentUser)
                <div class="top-user">
                    <div class="top-user-info">
                        <span class="top-user-name">{{ $userName }}</span>
                        <span class="top-user-role">{{ $role }}</span>
                    </div>
                    <div class="avatar">{{ $initial }}</div>
                </div>
            @endif
        </header>

        <section class="content">
            @if(session('success'))
                <div class="alert alert-success" role="status">
                    <span>✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error" role="alert">
                    <span>!</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error" role="alert">
                    <span>!</span>
                    <div>
                        <strong>Periksa data berikut:</strong>
                        <ul style="margin-top: 6px; padding-left: 17px; list-style: disc;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const button = document.getElementById('mobileMenuButton');
            const overlay = document.getElementById('sidebarOverlay');

            if (!sidebar || !button || !overlay) return;

            function closeSidebar() {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
                button.setAttribute('aria-expanded', 'false');
            }

            function toggleSidebar() {
                const isOpen = sidebar.classList.toggle('open');
                overlay.classList.toggle('active', isOpen);
                button.setAttribute('aria-expanded', String(isOpen));
            }

            button.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', closeSidebar);

            document.querySelectorAll('.sidebar-link').forEach(function (link) {
                link.addEventListener('click', function () {
                    if (window.innerWidth <= 900) closeSidebar();
                });
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth > 900) closeSidebar();
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') closeSidebar();
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
```