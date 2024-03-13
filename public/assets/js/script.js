document.querySelectorAll('.favorite-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const currencyId = this.parentElement.querySelector('select').value;
        const isFavorited = this.classList.contains('favorited');
        const action = isFavorited ? 'favorite_remove' : 'favorite_add';

        fetch('show_price.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=${action}&currency=${currencyId}`
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            updateFavouriteList(data);
            this.classList.toggle('favorited');
        })
        .catch(error => console.error('Error:', error));
    });
});

function updateFavouriteList(favourites) {
    const dropdownElement = document.getElementById('favouriteCurrenciesDropdown');
    if (!dropdownElement) {
        console.error('Dropdown element for favourite currencies not found.');
        return;
    }
    while (dropdownElement.options.length > 1) {
        dropdownElement.remove(1);
    }
    favourites.forEach(favourite => {
        const option = new Option(favourite.currency_name, favourite.currency_id);
        dropdownElement.add(option);
    });
}

document.getElementById('priceForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var form = this;
    var formData = new FormData(form);

    fetch(form.action + '?' + new URLSearchParams(formData), {
        method: 'GET'
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('priceResult').innerHTML = data;
        document.getElementById('priceResult').style.display = 'block';
    });
});