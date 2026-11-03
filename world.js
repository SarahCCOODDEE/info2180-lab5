document.addEventListener('DOMContentLoaded', () => {
    const countryInput = document.getElementById('country');
    const result = document.getElementById('result');

    function fetchData(extra = '') {
        const country = encodeURIComponent(countryInput.value.trim());
        fetch(`world.php?country=${country}${extra}`)
            .then(response => {
                if (!response.ok) throw new Error('Request failed');
                return response.text();
            })
            .then(html => { result.innerHTML = html; })
            .catch(err => { result.textContent = 'Error: ' + err.message; });
    }

    document.getElementById('lookup')
        .addEventListener('click', () => fetchData());

    document.getElementById('lookupCities')
        .addEventListener('click', () => fetchData('&lookup=cities'));
});
