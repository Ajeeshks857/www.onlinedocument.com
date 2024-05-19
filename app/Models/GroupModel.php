<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{
  protected $table = 'auth_groups_users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

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
    /**
     * Check if a user belongs to a specific group.
     *
     * @param int    $userId  The ID of the user.
     * @param string $groupName The name of the group to check.
     *
     * @return bool True if the user belongs to the group, false otherwise.
     */
    public function inGroup(int $userId, string $groupName): bool
    {
        $query = $this->db->table($this->table)
            ->where('user_id', $userId)
            ->where('group_id', function ($builder) use ($groupName) {
                $builder->select('id')
                    ->from('auth_groups')
                    ->where('name', $groupName)
                    ->limit(1);
            })
            ->countAllResults();

        return $query > 0;
    }
    
}
