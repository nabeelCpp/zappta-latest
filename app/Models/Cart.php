<?php

namespace App\Models;

use CodeIgniter\Model;

class Cart extends Model
{
    protected $table            = 'carts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'cart_contents',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getCart($user_id)
    {
        $cart = $this->where('user_id', $user_id)->first();
        if($cart) {
            return json_decode($cart['cart_contents'], true);
        }
    }

    public function updateCart($user_id, $data)
    {
        // Check if the cart already exists for the user
        $existingCart = $this->where('user_id', $user_id)->get()->getRow();

        if ($existingCart) {
            // Update the cart if it exists
            return $this->where('user_id', $user_id)->set('cart_contents', json_encode($data))->update();
        } else {
            // Create a new cart if it doesn't exist
            $data['user_id'] = $user_id; // Ensure user_id is included
            return $this->insert($data);
        }
    }

    /**
     * Destroy cart
     * @param int $user_id
     * @return bool
     * @since 2025-01-11
     * @version 1.0.0
     * @author M Nabeel Arshad
     */
    public function removeCart($user_id) : bool {
        return $this->where('user_id', $user_id)->delete();
    }
}
