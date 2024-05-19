<?php

namespace App\Models;

use CodeIgniter\Model;

class FormSubmissionModel extends Model
{
    protected $table      = 'form_submissions';
    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id', 'text', 'email', 'phone', 'address'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

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
            ->findAll($perPage, $offset);
    }
    /**
     * Get form submissions with document details for a specific form submission ID.
     *
     * @param int $formSubmissionId
     * @return array
     */
    public function getFormSubmissionsWithDocument(int $formSubmissionId)
    {
        return $this->select('documents.*')
            ->join('documents', 'documents.form_submission_id = form_submissions.id')
            ->where('form_submissions.id', $formSubmissionId)
            ->findAll();
    }
}
