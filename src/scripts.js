
    function edit_Book(bookId) {
    window.location.href = `edit_book.php?id=${bookId}`;
}

    function delete_Book(bookId) {
        if (confirm('Are you sure you want to delete this book?')) {
        fetch(`delete_book.php?id=${bookId}`, { method: 'POST' })
        .then(response => response.text())
        .then(data => {
        alert(data);
        window.location.href = 'index.php';
        });
    }
}
