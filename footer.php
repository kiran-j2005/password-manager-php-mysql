</main>
<footer class="py-4 mt-5" style="background-color: var(--dark);">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="mb-3 mb-md-0 text-center text-md-start">
                <i class="bi bi-shield-lock fs-5 me-2" style="color: var(--primary);"></i>
                <span class="text-white-50">PasswordVault &copy; <?= date('Y') ?> All Rights Reserved</span>
            </div>
            <div class="d-flex">
                <a href="#" class="text-white-50 me-3 hover-primary"><i class="bi bi-github"></i></a>
                <a href="#" class="text-white-50 me-3 hover-primary"><i class="bi bi-twitter"></i></a>
                <a href="#" class="text-white-50 hover-primary"><i class="bi bi-envelope"></i></a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Hover effect for social icons
    document.querySelectorAll('.hover-primary').forEach(icon => {
        icon.addEventListener('mouseenter', () => {
            icon.style.color = 'var(--primary)';
            icon.style.transition = 'color 0.3s ease';
        });
        icon.addEventListener('mouseleave', () => {
            icon.style.color = '';
        });
    });

    // Card animation
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-5px)';
            card.style.transition = 'all 0.3s ease';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
        });
    });
</script>

</body>
</html>