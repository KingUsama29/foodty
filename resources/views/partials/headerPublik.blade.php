<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodTY</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- STYLE: Bootstrap dulu, CSS cuma pelengkap -->
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            overflow-x: hidden;
        }

        /* ANTI OVERFLOW SAMPING */

        /* Navbar underline micro interaction */
        .nav-underline {
            position: relative;
        }

        .nav-underline::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: -6px;
            width: 0;
            height: 2px;
            background: rgba(255, 193, 7, 1);
            transition: all .25s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .nav-underline:hover::after {
            width: 70%;
        }

        /* Button hover */
        .btn-anim {
            transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
        }

        .btn-anim:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, .12);
            filter: brightness(1.02);
        }

        .btn-anim:active {
            transform: translateY(0);
        }

        /* Card hover */
        .card-anim {
            transition: transform .25s ease, box-shadow .25s ease;
            overflow: hidden;
            border: 0;
            border-radius: 16px;
        }

        .card-anim:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, .14);
        }

        .card-anim img {
            transition: transform .4s ease;
        }

        .card-anim:hover img {
            transform: scale(1.06);
        }

        /* Feature hover */
        .feature-anim {
            transition: transform .25s ease, filter .25s ease;
        }

        .feature-anim:hover {
            transform: translateY(-6px) scale(1.03);
            filter: drop-shadow(0 10px 18px rgba(0, 0, 0, .12));
        }

        /* Scroll reveal */
        .reveal {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity .7s cubic-bezier(.2, .8, .2, 1), transform .7s cubic-bezier(.2, .8, .2, 1);
        }

        .reveal.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Hero overlay */
        .hero-wrap {
            position: relative;
            isolation: isolate;
            overflow: hidden;
        }

        /* overflow hidden biar blob ga bikin geser */
        .hero-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg,
                    rgba(255, 255, 255, .95) 0%,
                    rgba(255, 255, 255, .82) 42%,
                    rgba(255, 255, 255, .25) 72%,
                    rgba(255, 255, 255, 0) 100%);
            z-index: -1;
        }

        /* Background blob halus (dibikin aman biar ga overflow) */
        .bg-blob {
            position: absolute;
            width: 340px;
            height: 340px;
            border-radius: 999px;
            filter: blur(50px);
            opacity: .22;
            animation: floaty 10s ease-in-out infinite;
            pointer-events: none;
            z-index: -2;
        }

        .blob-1 {
            top: 90px;
            left: -140px;
            background: #ffc107;
        }

        .blob-2 {
            top: 360px;
            right: -160px;
            background: #0d6efd;
            animation-duration: 13s;
            opacity: .16;
        }

        @keyframes floaty {
            0% {
                transform: translate3d(0, 0, 0) scale(1);
            }

            50% {
                transform: translate3d(18px, -16px, 0) scale(1.05);
            }

            100% {
                transform: translate3d(0, 0, 0) scale(1);
            }
        }

        /* Footer social hover */
        .social-anim {
            transition: transform .2s ease, opacity .2s ease;
        }

        .social-anim:hover {
            transform: translateY(-3px) scale(1.05);
            opacity: .9;
        }

        /* Teks */
        .hero-title {
            letter-spacing: -0.5px;
        }

        /* Gambar program biar tinggi konsisten */
        .program-img {
            height: 220px;
            object-fit: cover;
        }

        /* ===== Footer hover animations ===== */
        .footer-link {
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            padding: .15rem 0;
            transition: transform .2s ease, opacity .2s ease, color .2s ease;
            opacity: .9;
        }

        .footer-link i {
            transition: transform .25s ease, color .2s ease;
        }

        .footer-link:hover {
            transform: translateX(6px);
            opacity: 1;
            color: #ffc107 !important;
            /* kuning bootstrap */
        }

        .footer-link:hover i {
            transform: rotate(-8deg) translateY(-1px);
            color: #ffc107;
        }

        /* underline halus saat hover */
        .footer-link span {
            position: relative;
        }

        .footer-link span::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 0;
            height: 2px;
            background: #ffc107;
            transition: width .25s ease;
            border-radius: 2px;
        }

        .footer-link:hover span::after {
            width: 100%;
        }

        /* efek hover untuk kartu kolom footer */
        .footer-col {
            transition: transform .25s ease, box-shadow .25s ease;
            border-radius: 16px;
            padding: 14px;
        }

        .footer-col:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, .18);
        }

        /* hover untuk ikon sosmed juga sudah ada: .social-anim */
    </style>
</head>

<body>

    <!-- ================= NAVBAR ================= -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('gambar/logo_foodty.png') }}" alt="FoodTY" height="70" class="me-2">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <div class="ms-auto d-flex gap-2">
                    <button type="button" class="btn btn-outline-warning btn-anim nav-underline" data-bs-toggle="modal"
                        data-bs-target="#tentangKamiModal">
                        Tentang Kami
                    </button>

                    <a href="/login" class="btn btn-warning text-white btn-anim">
                        Masuk
                    </a>
                </div>
            </div>
        </div>
    </nav>
