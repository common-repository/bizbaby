document.addEventListener('DOMContentLoaded', function () {
    const copyButtons = document.querySelectorAll('.copy-shortcode');

    copyButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const shortcode = button.getAttribute('data-shortcode');
            let prevText = button.textContent;
            copyTextToClipboard(shortcode).then(function (success) {
                if (success) {
                    button.textContent = 'Copied!';
                    // Reset the button after a brief delay
                    setTimeout(function () {
                        button.textContent = prevText;
                    }, 2000);
                }
            }).catch(function (error) {
                button.textContent = 'Error, please copy manually';
                setTimeout(function () {
                    button.textContent = prevText;
                }, 2000);
            });
        });
    });


    function copyTextToClipboard(text) {
        return navigator.clipboard.writeText(text).then(function () {
            return true;
        }).catch(function (err) {
            return false
        });
    }
});
