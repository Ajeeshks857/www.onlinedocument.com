<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentsModel extends Model
{
    protected $table      = 'documents';
    protected $primaryKey = 'id';

    protected $allowedFields = ['form_submission_id',
        'file_name',
        'file_path',
        'user_id', 'approval_status', 'approved_date', 'description'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $returnType    = 'object';
    /**
     * Get form submissions with document details for a specific user.
     *
     * @param int $userId
     * @param int $perPage
     * @param int $offset
     * @return array
     */
    public function getFormSubmissionsWithDocuments(int $userId, int $perPage, int $offset)
    {
        return $this->select('*')
            ->where('user_id', $userId)
            ->findAll($perPage, $offset);
    }/**
     * Approve a document by its ID.
     *
     * @param int $documentId
     * @return bool
     */
    public function approveDocument(int $documentId)
    {

        $document = $this->find($documentId);
        $data     = [
            'approval_status' => 'approved',
            'approved_date'   => date('Y-m-d H:i:s'),
            'description'     => "Approved",
        ];

        return $this->update($documentId, $data);
    }

    /**
     * Reject a document by its ID.
     *
     * @param int $documentId
     * @return bool
     */
    public function rejectDocument(int $documentId,$description)
    {

        $document = $this->find($documentId);
        $data     = [
            'approval_status' => 'rejected',
            'description'     => $description,
        ];

        return $this->update($documentId, $data);
    }
}
