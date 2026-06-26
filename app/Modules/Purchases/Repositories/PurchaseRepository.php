<?php

namespace App\Modules\Purchases\Repositories;

use App\Repositories\BaseRepository;
use PDO;

class PurchaseRepository extends BaseRepository
{
    protected string $table = 'purchases';

    /**
     * Génère un numéro d'achat
     */
    public function generatePurchaseNumber(): string
    {
        return 'PO-'
            . date('Ymd')
            . '-'
            . rand(1000, 9999);
    }

    /**
     * Créer achat
     */
    public function createPurchase(
        array $data
    ): bool {

        $statement =
            $this->db->prepare(
                "
                INSERT INTO purchases
                (
                    purchase_number,
                    supplier_id,
                    subtotal,
                    tax,
                    discount,
                    total,
                    payment_status,
                    order_status
                )
                VALUES
                (
                    :purchase_number,
                    :supplier_id,
                    :subtotal,
                    :tax,
                    :discount,
                    :total,
                    :payment_status,
                    :order_status
                )
                "
            );

        return $statement->execute($data);
    }

    /**
     * Créer ligne achat
     */
    public function createItem(
        array $data
    ): bool {

        $statement =
            $this->db->prepare(
                "
                INSERT INTO purchase_items
                (
                    purchase_id,
                    product_id,
                    quantity,
                    unit_cost,
                    total_cost,
                    expiry_date,
                    batch_number
                )
                VALUES
                (
                    :purchase_id,
                    :product_id,
                    :quantity,
                    :unit_cost,
                    :total_cost,
                    :expiry_date,
                    :batch_number
                )
                "
            );

        return $statement->execute($data);
    }

    /**
     * Historique achats
     */
    public function allPurchases(): array
    {
        $statement =
            $this->db->query(
                "
                SELECT
                    p.*,
                    s.company_name
                FROM purchases p
                LEFT JOIN suppliers s
                    ON s.id = p.supplier_id
                ORDER BY p.id DESC
                "
            );

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }

    /**
     * Get purchase items
     */
    public function getItems(int $purchaseId): array
    {
        $statement = $this->db->prepare(
            "
            SELECT *
            FROM purchase_items
            WHERE purchase_id = :purchase_id
            "
        );

        $statement->execute([
            'purchase_id' => $purchaseId
        ]);

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }

}
