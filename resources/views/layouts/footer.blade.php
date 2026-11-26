<!-- Shared footer used across the site -->
<footer class="site-footer">
    <div class="container footer-container py-5">

        <!-- About -->
        <div class="footer-about">
            <h3>HospiBridge</h3>
            <p>Your trusted healthcare partner, providing modern medical services with care and excellence.</p>
        </div>

        <!-- Quick Links -->
        <div class="footer-links">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('services') }}">Services</a></li>
                <li><a href="{{ url('/appointments') }}">Appointments</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div class="footer-contact">
            <h4>Contact Us</h4>
            <p><i class="fas fa-map-marker-alt"></i> Beirut, Lebanon</p>
            <p><i class="fas fa-phone"></i> +961 70 123 456</p>
            <p><i class="fas fa-envelope"></i> info@hospibridge.com</p>
            <div class="footer-social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
        </div>

    </div>

    <!-- Bottom -->
    <div class="footer-bottom text-center py-3">
        <p class="mb-0">© 2025 HospiBridge. All Rights Reserved.</p>
    </div>
</footer>
