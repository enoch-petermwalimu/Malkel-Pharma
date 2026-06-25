<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * Audit logs
 */
class CreateAuditLogsTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('audit_logs', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            user_id INT NULL,

            action VARCHAR(255),

            entity_type VARCHAR(100),

            entity_id INT NULL,

            old_values LONGTEXT,

            new_values LONGTEXT,

            ip_address VARCHAR(100),

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $this->db->exec(
            Schema::drop('audit_logs')
        );
    }
}