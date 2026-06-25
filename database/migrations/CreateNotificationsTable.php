<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * Notifications queue
 */
class CreateNotificationsTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('notifications', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            recipient_type VARCHAR(100),

            recipient_id INT NULL,

            channel VARCHAR(100),

            message LONGTEXT,

            status VARCHAR(50) DEFAULT "pending",

            attempts INT DEFAULT 0,

            sent_at TIMESTAMP NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $this->db->exec(
            Schema::drop('notifications')
        );
    }
}