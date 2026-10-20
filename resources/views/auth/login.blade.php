
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#285C45">

    <title>Login — E-Library SMKN 5 Surakarta</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500;1,600&display=swap" rel="stylesheet">

    <style>
        :root {
            --green: #285C45;
            --green-dark: #1D4031;
            --green-light: #72B995;
            --pink: #F4C5D8;
            --pink-dark: #C77998;
            --text: #293D31;
            --muted: #87948B;
            --border: #E6EDE7;
            --cream: #FFF9FC;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            min-height: 100%;
        }

        body {
            min-height: 100vh;
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            color: var(--text);
            font-family: 'DM Sans', Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            background:
                radial-gradient(ellipse at 8% 12%,
                    rgba(114, 185, 149, .48), transparent 38%),
                radial-gradient(ellipse at 92% 82%,
                    rgba(244, 197, 216, .57), transparent 38%),
                radial-gradient(ellipse at 85% 8%,
                    rgba(255, 255, 255, .98), transparent 34%),
                #F4F6F0;
        }

        button,
        input {
            font: inherit;
        }

        button {
            -webkit-tap-highlight-color: transparent;
        }

        .ambient {
            position: fixed;
            z-index: -1;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            filter: blur(75px);
            pointer-events: none;
            opacity: .65;
        }

        .ambient-green {
            top: -100px;
            left: -100px;
            background: rgba(114, 185, 149, .6);
        }

        .ambient-pink {
            right: -100px;
            bottom: -100px;
            background: rgba(244, 197, 216, .7);
        }

        /* LAYOUT UTAMA */

        .login-shell {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            max-width: 1160px;
            min-height: 680px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .85);
            border-radius: 27px;
            background: rgba(255, 255, 255, .86);
            box-shadow: 0 28px 90px rgba(36, 73, 49, .13);
            backdrop-filter: blur(18px);
        }

        /* PANEL KIRI */

        .library-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0;
            padding: 38px 42px 30px;
            overflow: hidden;
            color: #FFFFFF;
            background:
                radial-gradient(ellipse at 12% 12%,
                    rgba(114, 185, 149, .23), transparent 43%),
                linear-gradient(145deg,
                    #316C50 0%, #285C45 49%, #1D4031 100%);
        }

        .library-panel::before,
        .library-panel::after {
            position: absolute;
            z-index: 0;
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 50%;
            content: "";
            pointer-events: none;
        }

        .library-panel::before {
            top: -180px;
            right: -155px;
            width: 450px;
            height: 450px;
        }

        .library-panel::after {
            right: -125px;
            bottom: -230px;
            width: 480px;
            height: 480px;
        }

        .brand,
        .panel-main,
        .panel-bottom {
            position: relative;
            z-index: 1;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-mark {
            display: grid;
            flex: 0 0 43px;
            width: 43px;
            height: 43px;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 13px;
            background: rgba(255, 255, 255, .1);
        }

        .brand-mark svg {
            display: block;
            width: 25px;
            height: 25px;
        }

        .brand-name {
            font-size: 17px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .brand-caption {
            margin-top: 4px;
            color: rgba(255, 255, 255, .67);
            font-size: 9px;
            font-weight: 500;
            letter-spacing: 1px;
        }

        .panel-main {
            margin: 30px 0;
        }

        .edition {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 20px;
            color: #D9EDE0;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
        }

        .edition::before {
            width: 25px;
            height: 1px;
            background: var(--pink);
            content: "";
        }

        .panel-title {
            max-width: 440px;
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(38px, 4.2vw, 55px);
            font-weight: 500;
            letter-spacing: -1.8px;
            line-height: 1.16;
        }

        .panel-title em {
            color: var(--pink);
            font-weight: 500;
        }

        .panel-description {
            max-width: 350px;
            margin-top: 18px;
            color: rgba(255, 255, 255, .75);
            font-size: 12px;
            line-height: 2;
        }

        /* ILUSTRASI BUKU */

        .book-art {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 200px;
            margin-top: 12px;
        }

        .art-circle {
            position: absolute;
            width: 190px;
            height: 190px;
            border: 1px solid rgba(255, 255, 255, .17);
            border-radius: 50%;
        }

        .art-circle::after {
            position: absolute;
            inset: 16px;
            border: 1px solid rgba(255, 255, 255, .11);
            border-radius: 50%;
            content: "";
        }

        .book-stack {
            position: relative;
            z-index: 1;
            width: 180px;
            height: 150px;
            transform: rotate(-7deg);
        }

        .book {
            position: absolute;
            width: 142px;
            height: 32px;
            border-radius: 4px 8px 8px 4px;
            box-shadow: 0 9px 17px rgba(12, 36, 23, .2);
        }

        .book::before {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 12px;
            width: 2px;
            background: rgba(255, 255, 255, .38);
            content: "";
        }

        .book::after {
            position: absolute;
            right: 13px;
            bottom: 8px;
            left: 25px;
            height: 1px;
            background: rgba(255, 255, 255, .45);
            box-shadow: 0 4px 0 rgba(255, 255, 255, .25);
            content: "";
        }

        .book-one {
            bottom: 13px;
            left: 12px;
            background: #F4C5D8;
            transform: rotate(5deg);
        }

        .book-two {
            bottom: 46px;
            left: 23px;
            background: #D6E7C9;
            transform: rotate(-3deg);
        }

        .book-three {
            bottom: 79px;
            left: 34px;
            background: #E8D5B5;
            transform: rotate(2deg);
        }

        .book-four {
            bottom: 112px;
            left: 45px;
            background: #8CBDA0;
            transform: rotate(-4deg);
        }

        .art-star {
            position: absolute;
            color: var(--pink);
            font-family: Georgia, serif;
        }

        .star-one {
            top: 20px;
            left: 20%;
            font-size: 23px;
        }

        .star-two {
            right: 19%;
            bottom: 25px;
            font-size: 17px;
        }

        .art-note {
            position: absolute;
            right: 2%;
            bottom: 8px;
            color: rgba(255, 255, 255, .65);
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 11px;
            font-style: italic;
        }

        .panel-bottom {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 15px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, .16);
        }

        .quote {
            max-width: 290px;
            color: rgba(255, 255, 255, .82);
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 14px;
            font-style: italic;
            line-height: 1.7;
        }

        .quote-mark {
            display: block;
            margin-bottom: 3px;
            color: var(--pink);
            font-size: 25px;
            line-height: 1;
        }

        .panel-index {
            color: rgba(255, 255, 255, .43);
            font-size: 9px;
            letter-spacing: 1px;
            white-space: nowrap;
        }

        /* PANEL LOGIN */

        .form-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
            padding: 48px clamp(28px, 5vw, 65px);
            background: rgba(255, 255, 255, .94);
        }

        .form-inner {
            width: 100%;
            max-width: 370px;
            margin: 0 auto;
        }

        .mobile-brand {
            display: none;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
            color: var(--green);
        }

        .mobile-brand .brand-mark {
            border-color: #DDEBE0;
            background: #EAF3EB;
        }

        .mobile-brand .brand-caption {
            color: #89968D;
        }

        .form-overline {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            color: #779681;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.8px;
        }

        .form-overline span {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--pink-dark);
            box-shadow: 0 0 0 4px rgba(244, 197, 216, .25);
        }

        .form-title {
            color: var(--green);
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(32px, 3.4vw, 42px);
            font-weight: 600;
            letter-spacing: -1px;
            line-height: 1.22;
        }

        .form-subtitle {
            margin-top: 12px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.9;
        }

        .login-form {
            margin-top: 28px;
        }

        .field {
            margin-bottom: 19px;
        }

        .field-label {
            display: block;
            margin-bottom: 9px;
            color: #374A3D;
            font-size: 11px;
            font-weight: 700;
        }

        .field-wrap {
            position: relative;
        }

        .field-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            width: 18px;
            height: 18px;
            color: #91A196;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .field-input {
            display: block;
            width: 100%;
            height: 50px;
            padding: 0 46px;
            border: 1px solid var(--border);
            border-radius: 12px;
            outline: none;
            background: #FBFCFA;
            color: #304437;
            font-size: 12px;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }

        .field-input::placeholder {
            color: #A8B2AA;
        }

        .field-input:hover {
            border-color: #C9DCCE;
        }

        .field-input:focus {
            border-color: var(--green-light);
            background: #FFFFFF;
            box-shadow: 0 0 0 4px rgba(114, 185, 149, .14);
        }

        .field-input.is-invalid {
            border-color: #D98DA9;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 11px;
            display: grid;
            width: 30px;
            height: 30px;
            place-items: center;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: #91A196;
            cursor: pointer;
            transform: translateY(-50%);
        }

        .password-toggle:hover {
            background: #EAF3EB;
            color: var(--green);
        }

        .password-toggle svg {
            width: 17px;
            height: 17px;
        }

        .field-error {
            margin-top: 7px;
            color: #B85F7E;
            font-size: 10px;
            line-height: 1.6;
        }

        /* NOTIFIKASI */

        .general-message {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-top: 18px;
            padding: 12px 13px;
            border: 1px solid #F2D7E1;
            border-radius: 10px;
            background: #FFF4F7;
            color: #A34D6C;
            font-size: 11px;
            line-height: 1.7;
            overflow-wrap: anywhere;
        }

        .general-message.success {
            border-color: #D6EBDD;
            background: #F0F8F2;
            color: #285C45;
        }

        .message-mark {
            display: grid;
            width: 19px;
            height: 19px;
            flex: 0 0 19px;
            place-items: center;
            border-radius: 50%;
            background: #F5DCE5;
            font-size: 11px;
            font-weight: 800;
        }

        .success .message-mark {
            background: #DCEFE1;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin: 0 0 23px;
        }

        .remember-option {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #7E8B81;
            font-size: 10px;
            cursor: pointer;
        }

        .remember-option input {
            width: 14px;
            height: 14px;
            accent-color: var(--green);
            cursor: pointer;
        }

        .secure-note {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #94A097;
            font-size: 9px;
            white-space: nowrap;
        }

        .secure-note svg {
            width: 13px;
            height: 13px;
        }

        /* TOMBOL LOGIN */

        .submit-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            min-height: 51px;
            border: 0;
            border-radius: 12px;
            background: var(--green);
            color: #FFFFFF;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .45px;
            cursor: pointer;
            box-shadow: 0 8px 18px rgba(40, 92, 69, .15);
            transition: background .2s, transform .2s, box-shadow .2s;
        }

        .submit-btn:hover {
            background: #367A5C;
            box-shadow: 0 11px 23px rgba(40, 92, 69, .2);
            transform: translateY(-1px);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn:disabled {
            cursor: wait;
            opacity: .78;
        }

        .submit-arrow {
            display: grid;
            width: 25px;
            height: 25px;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 8px;
            font-size: 16px;
            line-height: 1;
        }

        /* INFORMASI SEKOLAH */

        .form-divider {
            display: flex;
            align-items: center;
            gap: 13px;
            margin: 24px 0 18px;
            color: #A4ADA6;
            font-size: 9px;
            letter-spacing: 1px;
            text-align: center;
        }

        .form-divider::before,
        .form-divider::after {
            flex: 1;
            height: 1px;
            background: #EDF0ED;
            content: "";
        }

        .school-note {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            padding: 13px;
            border: 1px solid #E9F0E9;
            border-radius: 12px;
            background: #F8FBF8;
        }

        .school-note-icon {
            display: grid;
            width: 31px;
            height: 31px;
            flex: 0 0 31px;
            place-items: center;
            border-radius: 9px;
            background: #E6F2E8;
            color: var(--green);
        }

        .school-note-icon svg {
            width: 16px;
            height: 16px;
        }

        .school-note strong {
            display: block;
            color: #3E5545;
            font-size: 10px;
        }

        .school-note p {
            margin-top: 4px;
            color: #8B968E;
            font-size: 9px;
            line-height: 1.7;
        }

        .form-footer {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #F0F2EF;
            color: #A0AAA2;
            font-size: 9px;
            line-height: 1.8;
            text-align: center;
        }

        .form-footer strong {
            color: #657B6B;
            font-weight: 800;
        }

        .footer-heart {
            color: #D98EAC;
        }

        /* RESPONSIVE TABLET */

        @media (max-width: 900px) {
            body {
                padding: 15px;
            }

            .login-shell {
                min-height: 650px;
            }

            .library-panel {
                padding: 30px 25px 25px;
            }

            .panel-title {
                font-size: 41px;
            }

            .form-panel {
                padding: 35px 27px;
            }

            .book-art {
                min-height: 170px;
            }

            .art-circle {
                width: 160px;
                height: 160px;
            }

            .book-stack {
                transform: scale(.85) rotate(-7deg);
            }
        }

        /* RESPONSIVE HP */

        @media (max-width: 650px) {
            body {
                display: block;
                padding: 0;
                background:
                    radial-gradient(ellipse at 0% 0%,
                        rgba(114, 185, 149, .35), transparent 43%),
                    radial-gradient(ellipse at 100% 100%,
                        rgba(244, 197, 216, .43), transparent 40%),
                    #F8F8F3;
                background-attachment: fixed;
            }

            .login-shell {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                overflow: hidden;
                border: 0;
                border-radius: 0;
                background: transparent;
                box-shadow: none;
                backdrop-filter: none;
            }

            .library-panel {
                min-height: auto;
                padding: 23px 24px 22px;
                border-radius: 0 0 23px 23px;
            }

            .brand-mark {
                width: 39px;
                height: 39px;
                flex-basis: 39px;
            }

            .brand-name {
                font-size: 15px;
            }

            .brand-caption {
                font-size: 8px;
            }

            .panel-main {
                margin: 27px 0 9px;
            }

            .edition {
                margin-bottom: 12px;
                font-size: 9px;
            }

            .panel-title {
                max-width: 370px;
                font-size: clamp(34px, 9vw, 44px);
            }

            .panel-description {
                max-width: 340px;
                margin-top: 11px;
                font-size: 11px;
                line-height: 1.8;
            }

            .book-art {
                display: none;
            }

            .panel-bottom {
                margin-top: 19px;
                padding-top: 14px;
            }

            .quote {
                font-size: 12px;
            }

            .panel-index {
                font-size: 8px;
            }

            .form-panel {
                flex: 1;
                justify-content: flex-start;
                padding: 30px 24px 23px;
                background: rgba(255, 255, 255, .84);
            }

            .form-inner {
                max-width: 430px;
            }

            .form-overline {
                margin-bottom: 11px;
            }

            .form-title {
                font-size: 35px;
            }

            .form-subtitle {
                margin-top: 9px;
                font-size: 11px;
            }

            .login-form {
                margin-top: 25px;
            }

            .field {
                margin-bottom: 17px;
            }

            .field-input {
                height: 49px;
            }

            .form-options {
                margin-bottom: 21px;
            }

            .form-divider {
                margin: 21px 0 16px;
            }

            .form-footer {
                margin-top: 23px;
            }
        }

        @media (max-width: 360px) {
            .library-panel {
                padding: 21px 18px;
            }

            .form-panel {
                padding: 27px 18px 20px;
            }

            .panel-title {
                font-size: 32px;
            }

            .form-title {
                font-size: 31px;
            }

            .secure-note {
                font-size: 8px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>

    <div class="ambient ambient-green" aria-hidden="true"></div>
    <div class="ambient ambient-pink" aria-hidden="true"></div>

    <main class="login-shell">

        <!-- PANEL IDENTITAS -->

        <section class="library-panel">

            <div class="brand">
                <div class="brand-mark">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M3.5 5.5C6.6 4.5 9.6 5 12 7V20C9.6 18 6.6 17.5 3.5 18.5V5.5Z"
                              stroke="#F4C5D8" stroke-width="1.6"
                              stroke-linejoin="round"/>
                        <path d="M20.5 5.5C17.4 4.5 14.4 5 12 7V20C14.4 18 17.4 17.5 20.5 18.5V5.5Z"
                              stroke="#FFFFFF" stroke-width="1.6"
                              stroke-linejoin="round"/>
                        <path d="M7 9L9.5 9.5M7 12L9.5 12.5M15 9.5L17.5 9M15 12.5L17.5 12"
                              stroke="#FFFFFF" stroke-width="1.2"
                              stroke-linecap="round"/>
                    </svg>
                </div>

                <div>
                    <div class="brand-name">E-Library</div>
                    <div class="brand-caption">SMK NEGERI 5 SURAKARTA</div>
                </div>
            </div>

            <div class="panel-main">

                <div class="edition">A little space to grow</div>

                <h1 class="panel-title">
                    Every book<br>
                    opens a <em>new world.</em>
                </h1>

                <p class="panel-description">
                    Temukan bacaan baru, perluas wawasan, dan jadikan
                    setiap halaman sebagai langkah kecil menuju hal
                    yang lebih besar.
                </p>

                <div class="book-art" aria-hidden="true">
                    <div class="art-circle"></div>

                    <span class="art-star star-one">✳</span>
                    <span class="art-star star-two">✦</span>

                    <div class="book-stack">
                        <div class="book book-one"></div>
                        <div class="book book-two"></div>
                        <div class="book book-three"></div>
                        <div class="book book-four"></div>
                    </div>

                    <div class="art-note">read · discover · repeat</div>
                </div>

            </div>

            <div class="panel-bottom">
                <div class="quote">
                    <span class="quote-mark">“</span>
                    A good book is a quiet friend.
                </div>

                <div class="panel-index">01 / LIBRARY</div>
            </div>

        </section>

        <!-- PANEL LOGIN -->

        <section class="form-panel">

            <div class="form-inner">

                <div class="mobile-brand">
                    <div class="brand-mark">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M3.5 5.5C6.6 4.5 9.6 5 12 7V20C9.6 18 6.6 17.5 3.5 18.5V5.5Z"
                                  stroke="#285C45" stroke-width="1.6"
                                  stroke-linejoin="round"/>
                            <path d="M20.5 5.5C17.4 4.5 14.4 5 12 7V20C14.4 18 17.4 17.5 20.5 18.5V5.5Z"
                                  stroke="#72B995" stroke-width="1.6"
                                  stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div>
                        <div class="brand-name">E-Library</div>
                        <div class="brand-caption">SMK NEGERI 5 SURAKARTA</div>
                    </div>
                </div>

                <div class="form-overline">
                    <span></span>
                    WELCOME BACK
                </div>

                <h2 class="form-title">
                    Senang melihatmu<br>
                    kembali.
                </h2>

                <p class="form-subtitle">
                    Masuk ke akunmu untuk melanjutkan perjalanan membaca.
                </p>

                <!-- PESAN BERHASIL -->

                @if (session('success'))
                    <div class="general-message success" role="status">
                        <span class="message-mark">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- PESAN ERROR DARI SESSION -->

                @if (session('error'))
                    <div class="general-message" role="alert">
                        <span class="message-mark">!</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- PESAN VALIDASI LARAVEL -->

                @if ($errors->any())
                    <div class="general-message" role="alert">
                        <span class="message-mark">!</span>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- FORM LOGIN -->

                <form
                    class="login-form"
                    id="loginForm"
                    method="POST"
                    action="{{ route('login.process') }}"
                >
                    @csrf

                    <!-- USERNAME / NIS / EMAIL -->

                    <div class="field">

                        <label for="login" class="field-label">
                            NIS / Username / Email
                        </label>

                        <div class="field-wrap">

                            <svg class="field-icon"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 aria-hidden="true">
                                <circle cx="12" cy="8" r="3.5"
                                        stroke="currentColor"
                                        stroke-width="1.6"/>
                                <path d="M5 20C5 16.7 7.8 14.5 12 14.5C16.2 14.5 19 16.7 19 20"
                                      stroke="currentColor"
                                      stroke-width="1.6"
                                      stroke-linecap="round"/>
                            </svg>

                            <input
                                id="login"
                                name="login"
                                type="text"
                                class="field-input @error('login') is-invalid @enderror"
                                placeholder="Masukkan username atau email"
                                value="{{ old('login') }}"
                                autocomplete="username"
                                maxlength="255"
                                required
                                autofocus
                            >

                        </div>

                        @error('login')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>

                    <!-- PASSWORD -->

                    <div class="field">

                        <label for="password" class="field-label">
                            Password
                        </label>

                        <div class="field-wrap">

                            <svg class="field-icon"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 aria-hidden="true">
                                <rect x="5" y="10" width="14" height="10"
                                      rx="2.3"
                                      stroke="currentColor"
                                      stroke-width="1.6"/>
                                <path d="M8 10V7A4 4 0 0 1 16 7V10"
                                      stroke="currentColor"
                                      stroke-width="1.6"
                                      stroke-linecap="round"/>
                                <path d="M12 14V16"
                                      stroke="currentColor"
                                      stroke-width="1.6"
                                      stroke-linecap="round"/>
                            </svg>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="field-input @error('password') is-invalid @enderror"
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                id="togglePassword"
                                aria-label="Tampilkan password"
                                aria-pressed="false"
                            >
                                <svg id="eyeIcon"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     aria-hidden="true">
                                    <path d="M2.5 12S6 5.5 12 5.5S21.5 12 21.5 12S18 18.5 12 18.5S2.5 12 2.5 12Z"
                                          stroke="currentColor"
                                          stroke-width="1.6"/>
                                    <circle cx="12" cy="12" r="3"
                                            stroke="currentColor"
                                            stroke-width="1.6"/>
                                </svg>
                            </button>

                        </div>

                        @error('password')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>

                    <!-- OPSI LOGIN -->

                    <div class="form-options">

                        <label class="remember-option">
                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                value="1"
                            >
                            <span>Ingat saya</span>
                        </label>

                        <span class="secure-note">
                            <svg viewBox="0 0 24 24"
                                 fill="none"
                                 aria-hidden="true">
                                <rect x="5" y="10" width="14" height="10"
                                      rx="2"
                                      stroke="currentColor"
                                      stroke-width="1.5"/>
                                <path d="M8 10V7A4 4 0 0 1 16 7V10"
                                      stroke="currentColor"
                                      stroke-width="1.5"
                                      stroke-linecap="round"/>
                            </svg>
                            Login aman
                        </span>

                    </div>

                    <!-- TOMBOL MASUK -->

                    <button
                        type="submit"
                        class="submit-btn"
                        id="submitBtn"
                    >
                        <span id="submitText">MASUK SEKARANG</span>
                        <span class="submit-arrow" aria-hidden="true">→</span>
                    </button>

                </form>

                <div class="form-divider">
                    YOUR READING SPACE
                </div>

                <!-- INFORMASI PERPUSTAKAAN -->

                <div class="school-note">

                    <div class="school-note-icon">
                        <svg viewBox="0 0 24 24"
                             fill="none"
                             aria-hidden="true">
                            <path d="M3 9L12 4L21 9L12 14L3 9Z"
                                  stroke="currentColor"
                                  stroke-width="1.5"
                                  stroke-linejoin="round"/>
                            <path d="M6 11V16C9.5 19 14.5 19 18 16V11M21 9V15"
                                  stroke="currentColor"
                                  stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div>
                        <strong>Perpustakaan Digital Sekolah</strong>
                        <p>
                            Akses katalog dan layanan peminjaman buku
                            menggunakan akun yang telah terdaftar.
                        </p>
                    </div>

                </div>

                <!-- FOOTER -->

                <footer class="form-footer">
                    <strong>SMK NEGERI 5 SURAKARTA</strong><br>
                    Read more, learn more.
                    <span class="footer-heart">♡</span>
                </footer>

            </div>

        </section>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');
            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');

            // Tampilkan atau sembunyikan password.

            if (passwordInput && togglePassword && eyeIcon) {

                togglePassword.addEventListener('click', function () {

                    const showPassword =
                        passwordInput.type === 'password';

                    passwordInput.type =
                        showPassword ? 'text' : 'password';

                    togglePassword.setAttribute(
                        'aria-pressed',
                        String(showPassword)
                    );

                    togglePassword.setAttribute(
                        'aria-label',
                        showPassword
                            ? 'Sembunyikan password'
                            : 'Tampilkan password'
                    );

                    if (showPassword) {

                        eyeIcon.innerHTML =
                            '<path d="M3 3L21 21M10.6 10.7A2 2 0 0 0 13.3 13.4M9.9 5.8A10.8 10.8 0 0 1 12 5.5C18 5.5 21.5 12 21.5 12S18 18.5 12 18.5C6 18.5 2.5 12 2.5 12S4 9 6.2 7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>';

                    } else {

                        eyeIcon.innerHTML =
                            '<path d="M2.5 12S6 5.5 12 5.5S21.5 12 21.5 12S18 18.5 12 18.5S2.5 12 2.5 12Z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/>';

                    }

                });

            }

            // Ubah label tombol ketika form dikirim.
            // Form tetap dikirim secara normal ke Laravel.

            if (loginForm && submitBtn && submitText) {

                loginForm.addEventListener('submit', function (event) {

                    if (loginForm.checkValidity()) {

                        submitBtn.disabled = true;
                        submitText.textContent = 'MEMPROSES...';

                    }

                });

            }

        });
    </script>

</body>
</html>
