<!-- ================= FOOTER ================= -->
<footer class="text-white pt-5 pb-4 mt-5"
    style="background: linear-gradient(135deg, #0b1320 0%, #0f1b2d 55%, #111827 100%);">
    <div class="container">

        <div class="row gy-4">

            <!-- BRAND -->
            <div class="col-lg-4 col-md-6 footer-col">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <img src="{{ asset('gambar/logo_foodty-footer.png') }}" height="48" alt="FoodTY">
                    <h5 class="mb-0 fw-bold">FoodTY</h5>
                </div>

                <p class="small" style="opacity:.85;">
                    FoodTY adalah platform digital penyaluran bantuan pangan
                    yang menghubungkan donatur dan penerima secara transparan,
                    terstruktur, dan tepat sasaran.
                </p>

                <!-- SOSIAL MEDIA -->
                <div class="d-flex gap-3 mt-3">
                    <a href="https://wa.me/6283121562697" target="_blank" class="text-white fs-5 social-anim"
                        aria-label="WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="https://instagram.com/arsyattar_" target="_blank" class="text-white fs-5 social-anim"
                        aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://www.tiktok.com/@tokageee_" target="_blank" class="text-white fs-5 social-anim"
                        aria-label="TikTok">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>
                </div>
            </div>

            <!-- NAVIGASI -->
            <div class="col-lg-2 col-md-6 footer-col">
                <h6 class="fw-bold mb-3">Navigasi</h6>
                <ul class="list-unstyled small" style="opacity:.9;">
                    <li class="mb-2">
                        <a href="/" class="text-white text-decoration-none footer-link">
                            <i class="fa-solid fa-house"></i>
                            <span>Beranda</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/login" class="text-white text-decoration-none footer-link">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            <span>Masuk</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none footer-link" data-bs-toggle="modal"
                            data-bs-target="#tentangKamiModal">
                            <i class="fa-solid fa-circle-info"></i>
                            <span>Tentang Kami</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- BANTUAN -->
            <div class="col-lg-3 col-md-6 footer-col">
                <h6 class="fw-bold mb-3">Bantuan</h6>
                <ul class="list-unstyled small" style="opacity:.9;">
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none footer-link">
                            <i class="fa-solid fa-hand-holding-heart"></i>
                            <span>Cara Berdonasi</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none footer-link">
                            <i class="fa-solid fa-route"></i>
                            <span>Alur Penyaluran</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none footer-link">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Kebijakan Privasi</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none footer-link">
                            <i class="fa-solid fa-file-contract"></i>
                            <span>Syarat & Ketentuan</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- HUBUNGI KAMI -->
            <div class="col-lg-3 col-md-6 footer-col">
                <h6 class="fw-bold mb-3">Hubungi Kami</h6>

                <p class="small mb-2" style="opacity:.9;">
                    <a href="#" class="text-white text-decoration-none footer-link">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Mojomokerto, Yogyakarta, Indonesia</span>
                    </a>
                </p>

                <p class="small mb-2" style="opacity:.9;">
                    <a href="tel:+6283121562697" class="text-white text-decoration-none footer-link">
                        <i class="fa-solid fa-phone"></i>
                        <span>+62 831-2156-2697</span>
                    </a>
                </p>

                <p class="small mb-0" style="opacity:.9;">
                    <a href="mailto:info@foodty.id" class="text-white text-decoration-none footer-link">
                        <i class="fa-solid fa-envelope"></i>
                        <span>info@foodty.id</span>
                    </a>
                </p>
            </div>

        </div>

        <hr class="border-light my-4" style="opacity:.15;">

        <div class="text-center small" style="opacity:.75;">
            © 2025 FoodTY. All rights reserved.
        </div>

    </div>
</footer>

<!-- ================= FOOTER HOVER STYLE ================= -->
<style>
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
    }

    .footer-link:hover i {
        transform: rotate(-8deg) translateY(-1px);
        color: #ffc107;
    }

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

    .footer-col {
        transition: transform .25s ease, box-shadow .25s ease;
        border-radius: 16px;
        padding: 14px;
    }

    .footer-col:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(0, 0, 0, .18);
    }
</style>
<!-- Scroll Reveal JS (FIX) -->
<script>
    (function() {
        function initReveal() {
            const els = document.querySelectorAll(".reveal");
            if (!els.length) return;

            if (!("IntersectionObserver" in window)) {
                els.forEach(el => el.classList.add("show"));
                return;
            }

            const io = new IntersectionObserver((entries) => {
                entries.forEach((e) => {
                    if (e.isIntersecting) {
                        e.target.classList.add("show");
                        io.unobserve(e.target);
                    }
                });
            }, {
                threshold: 0.12
            });

            els.forEach(el => io.observe(el));
        }

        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", initReveal);
        } else {
            initReveal();
        }
    })();
</script>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
