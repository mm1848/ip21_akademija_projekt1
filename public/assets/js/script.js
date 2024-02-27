document.getElementById('priceForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var form = this;
    var formData = new FormData(form);

    fetch(form.action + '?' + new URLSearchParams(formData))
        .then(response => response.text())
        .then(data => {
            document.getElementById('priceResult').innerHTML = data;
            document.getElementById('priceResult').style.display = 'block';
        });
});

