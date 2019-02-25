# PHP-OOP-CRUD
Here we have my example of Create Read Update Delete OOP PDO class. I use dependency injection.

In index.php there is few line of code:

//$crud->insert([['Szymon', 'Tyrul'], ['Adam', 'Ryszard']]);

//$crud->update(["Max" => "Ryszard"]);

//$crud->remove([2, 3]);

var_dump($crud->read("SELECT * from books"));
