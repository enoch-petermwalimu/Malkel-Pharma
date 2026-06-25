<?php

use App\Core\Migration;

class AlterUsersProfileFields extends Migration
{
    public function up(): void
    {
        $columns = [];

        $result = $this->db->query("
            SHOW COLUMNS FROM users
        ");

        foreach ($result->fetchAll() as $column) {
            $columns[] = $column['Field'];
        }

        if (!in_array('profile_photo', $columns)) {

            $this->db->exec("
                ALTER TABLE users
                ADD profile_photo VARCHAR(255) NULL
            ");
        }

        if (!in_array('phone', $columns)) {

            $this->db->exec("
                ALTER TABLE users
                ADD phone VARCHAR(50) NULL
            ");
        }
    }

    public function down(): void
    {
    }
}