document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('click', function(e){
        // Ripple effect
        const ripple = document.createElement('span');
        ripple.classList.add('ripple');
        ripple.style.left = `${e.offsetX}px`;
        ripple.style.top = `${e.offsetY}px`;
        this.appendChild(ripple);
        setTimeout(() => ripple.remove(), 600);

        // Open URL
        const url = this.getAttribute('data-url');
        if(url) {
            window.open(url, "_blank"); // Opens in new tab
        }
    });
});
