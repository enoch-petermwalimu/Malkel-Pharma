<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * Users
 */
class CreateUsersTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('users', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            full_name VARCHAR(255) NOT NULL,

            email VARCHAR(255) UNIQUE NOT NULL,

            password VARCHAR(255) NOT NULL,

            role VARCHAR(100) NOT NULL,

            is_active TINYINT(1) DEFAULT 1,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $this->db->exec(
            Schema::drop('users')
        );
    }
}