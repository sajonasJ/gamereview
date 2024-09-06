document.addEventListener('DOMContentLoaded', function () {

    // Ensure toggle button exists before attaching event listener
    const toggleButton = document.getElementById('toggle-btn');
    if (toggleButton) {
        toggleButton.addEventListener('click', function () {

            let navContainer = document.getElementById('nav-container');
            let toggleIcon = document.getElementById('toggle-icon');

            navContainer.classList.toggle('collapsed');
            toggleIcon.classList.toggle('collapsed');

            if (toggleIcon.innerHTML === '&gt;') {
                toggleIcon.innerHTML = '&lt;';
            } else {
                toggleIcon.innerHTML = '&gt;';
            }
        });
    }
});