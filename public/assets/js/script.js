document.querySelectorAll('.favorite-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const currencyId = this.parentElement.querySelector('select').value;
        const action = this.classList.contains('favorited') ? 'favorite_remove' : 'favorite_add';

        fetch('show_price.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=${action}&currency=${currencyId}`
        })
        .then(response => response.json())
        .then(data => {
            updateFavouriteList(data); // Posodobi seznam priljubljenih na strani
            this.classList.toggle('favorited'); // Posodobi stanje zvezdice
        })
        .catch(error => console.error('Error:', error));
    });
});

function updateFavouriteList(favourites) {
    const listElement = document.getElementById('favouriteList');
    listElement.innerHTML = ''; // Počisti trenutni seznam
    favourites.forEach(favourite => {
        const listItem = document.createElement('li');
        listItem.textContent = favourite.currency_name; // Ali ustrezno lastnost iz vašega JSON odgovora
        listElement.appendChild(listItem);
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
