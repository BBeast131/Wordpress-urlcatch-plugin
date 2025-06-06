document.addEventListener('DOMContentLoaded', function() {
    function getVisibleLinks() {
        const links = document.querySelectorAll('a');
        const visibleLinks = [];
        const viewportHeight = window.innerHeight;

        links.forEach(link => {
            const rect = link.getBoundingClientRect();
            if (rect.top >= 0 && rect.top <= viewportHeight) {
                visibleLinks.push({
                    href: link.href,
                    text: link.textContent.trim()
                });
            }
        });

        return visibleLinks;
    }

    function sendTrackingData() {
        const links = getVisibleLinks();
        const screenSize = `${window.innerWidth}x${window.innerHeight}`;

        fetch(atfTracker.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'atf_track',
                nonce: atfTracker.nonce,
                links: JSON.stringify(links),
                screen_size: screenSize
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Tracking failed:', data.data);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    sendTrackingData();
});