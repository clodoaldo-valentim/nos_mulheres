// Validação de formulário de cadastro de livros
document.getElementById("book-form").addEventListener("submit", function(e) {
  e.preventDefault();
  var title = document.getElementById("title").value;
  var author = document.getElementById("author").value;
  var subject = document.getElementById("subject").value;

  if (!title || !author || !subject) {
    alert("Por favor, preencha todos os campos obrigatórios");
  } else {
    // Envia o formulário para o servidor
    this.submit();
  }
});

// Atualização em tempo real da lista de livros
setInterval(function() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "get-books.php", true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var books = JSON.parse(xhr.responseText);
      var bookList = document.getElementById("book-list");
      bookList.innerHTML = "";
      for (var i = 0; i < books.length; i++) {
        bookList.innerHTML += "<tr><td>" + books[i].title + "</td><td>" + books[i].author + "</td><td>" + books[i].subject + "</td></tr>";
      }
    }
  };
  xhr.send();
}, 1000);
