<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * User sessions
 */
class CreateUserSessionsTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('user_sessions', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            user_id INT NOT NULL,

            session_token VARCHAR(255),

            ip_address VARCHAR(100),

            user_agent TEXT,

            last_activity TIMESTAMP,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $this->db->exec(
            Schema::drop('user_sessions')
        );
    }
}