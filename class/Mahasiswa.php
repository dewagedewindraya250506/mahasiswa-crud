<?php
// class/Mahasiswa.php

class Mahasiswa {
    protected Database $db;
    protected PDO $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->conn;
    }

    // create
    public function create(array $data): bool {
        $sql = "INSERT INTO mahasiswa (nama, nim, prodi, angkatan, foto_path, status) 
                VALUES (:nama, :nim, :prodi, :angkatan, :foto_path, :status)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nama' => $data['nama'],
            ':nim' => $data['nim'],
            ':prodi' => $data['prodi'],
            ':angkatan' => $data['angkatan'],
            ':foto_path' => $data['foto_path'] ?? null,
            ':status' => $data['status'],
        ]);
    }

    // read all
    public function getAll(): array {
        $sql = "SELECT * FROM mahasiswa ORDER BY id ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    // read by id
    public function getById(int $id): ?array {
        $sql = "SELECT * FROM mahasiswa WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ? $row : null;
    }

    // update
    public function update(int $id, array $data): bool {
        $sql = "UPDATE mahasiswa SET nama = :nama, nim = :nim, prodi = :prodi, angkatan = :angkatan, 
                foto_path = :foto_path, status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nama' => $data['nama'],
            ':nim' => $data['nim'],
            ':prodi' => $data['prodi'],
            ':angkatan' => $data['angkatan'],
            ':foto_path' => $data['foto_path'] ?? null,
            ':status' => $data['status'],
            ':id' => $id
        ]);
    }

    // delete
    public function delete(int $id): bool {
        $sql = "DELETE FROM mahasiswa WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // optional: search by nim or nama (not required but handy)
    public function search(string $q): array {
        $sql = "SELECT * FROM mahasiswa WHERE nama LIKE :q OR nim LIKE :q ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':q' => "%$q%"]);
        return $stmt->fetchAll();
    }
}