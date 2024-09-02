document.addEventListener('DOMContentLoaded', function() {
    let modal = document.getElementById('book_modal');
    let close_btn = document.querySelector('.modal .close');

    function openModal(book_id) {
        fetch('books/' + book_id)
        .then(Response => Response.json())
        .then(data => {
            let modal_body = document.getElementById('modal_body');
            let book_cover = data.book_cover ? '<p><strong>Cover:</strong><br><img src="/storage/' + data.book_cover + '" width="200" alt="Book Cover"></p>' : '';
            modal_body.innerHTML =
            '<p><strong>Book Name:</strong>' + (data.book_name) + '</p>' +
            '<p><strong>Author:</strong>' + (data.author) + '</p>' +
            book_cover;

            modal.style.display = 'block';
        })

        .catch(error => {
            console.error('Error fetching book details:', error);
        });
    }

    document.querySelectorAll('.book-row').forEach(row => {
        row.addEventListener('click', function() {
            let book_id = this.getAttribute('data-id');
            openModal(book_id);
        });
    });

    close_btn.addEventListener('click', function() {
        modal.style.display = none;
    })

    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = none;
        }
    });
});