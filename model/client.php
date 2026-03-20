<?php


require_once __DIR__ . '/../config.php';

class Client
{

    public static function validate(array $data): array
    {
        $errors = [];

        $name  = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');
        $phone = trim($data['phone'] ?? '');

        if ($name === '')  $errors['name']  = 'El nombre es obligatorio.';
        if ($email === '') $errors['email'] = 'El email es obligatorio.';
        if ($phone === '') $errors['phone'] = 'El teléfono es obligatorio.';

        return $errors;
    }


    public static function all(): array
    {
        $stmt = db()->query("SELECT id, name, email, phone FROM clients ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function find(int $id): ?array
    {
        $stmt = db()->prepare("SELECT id, name, email, phone FROM clients WHERE id = :id");
        $stmt->execute([':id' => $id]);

        $client = $stmt->fetch(PDO::FETCH_ASSOC);
        return $client ? $client : null;
    }

    public static function create(array $data): void
    {
        $stmt = db()->prepare("
            INSERT INTO clients (name, email, phone)
            VALUES (:name, :email, :phone)
        ");

        $stmt->execute([
            ':name'  => trim($data['name']),
            ':email' => trim($data['email']),
            ':phone' => trim($data['phone']),
        ]);
    }

    public static function update(int $id, array $data): void
    {
        $stmt = db()->prepare("
            UPDATE clients
            SET name = :name, email = :email, phone = :phone
            WHERE id = :id
        ");

        $stmt->execute([
            ':id'    => $id,
            ':name'  => trim($data['name']),
            ':email' => trim($data['email']),
            ':phone' => trim($data['phone']),
        ]);
    }

    public static function delete(int $id): void
    {
        $stmt = db()->prepare("DELETE FROM clients WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
