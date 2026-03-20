<?php


require_once __DIR__ . '/../model/Client.php';

class ClientController
{
    public function index(): void
    {
        $clients = Client::all();
        require __DIR__ . '/../views/clients/index.php';
    }

    public function create(array $old = [], array $errors = []): void
    {
        require __DIR__ . '/../views/clients/create.php';
    }

    public function store(array $post): void
    {
        $errors = Client::validate($post);

        if (!empty($errors)) {
            $this->create($post, $errors);
            return;
        }

        Client::create($post);

        header('Location: index.php?action=index');
        exit;
    }

    public function edit(int $id, array $old = [], array $errors = []): void
    {
        $client = Client::find($id);

        if (!$client) {
            echo "Cliente no encontrado";
            return;
        }

        require __DIR__ . '/../views/clients/edit.php';
    }

    public function update(int $id, array $post): void
    {
        $client = Client::find($id);

        if (!$client) {
            echo "Cliente no encontrado";
            return;
        }

        $errors = Client::validate($post);

        if (!empty($errors)) {
            $this->edit($id, $post, $errors);
            return;
        }

        Client::update($id, $post);

        header('Location: index.php?action=index');
        exit;
    }

    public function destroy(int $id): void
    {
        $client = Client::find($id);

        if (!$client) {
            echo "Cliente no encontrado";
            return;
        }

        Client::delete($id);

        header('Location: index.php?action=index');
        exit;
    }
}
