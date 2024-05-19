<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DocumentsModel;
use App\Models\FormSubmissionModel;
use CodeIgniter\API\ResponseTrait;

class AdminController extends BaseController
{
    use ResponseTrait;
    protected $auth;

    public function __construct()
    {
        $this->auth = service('authentication');
    }
    public function getDetails()
    {
        try {
            if (!$this->auth->check()) {
                return $this->failUnauthorized('User is not logged in');
            }

            $user = $this->auth->user();

            $cacheKey = 'form_submissions_user_' . $user->id;
            $cache    = \Config\Services::cache();

            $cachedData = $cache->get($cacheKey);
            // if ($cachedData) {
            //     return $this->response->setStatusCode(200)->setJSON($cachedData);
            // }

            $perPage = $this->request->getVar('length') ? (int) $this->request->getVar('length') : 10;
            $page    = $this->request->getVar('start') ? ((int) $this->request->getVar('start') / $perPage) + 1 : 1;

            $formSubmissionModel = new FormSubmissionModel();

            $totalRecords = $formSubmissionModel->where('user_id', $user->id)->countAllResults();

            $submissions = $formSubmissionModel->getFormSubmissionsWithDocuments($user->id, $perPage, ($page - 1) * $perPage);

            $data = [];
            foreach ($submissions as $submission) {
                $data[] = [
                    'id'         => $submission['id'],
                    'text'       => $submission['text'],
                    'email'      => $submission['email'],
                    'phone'      => $submission['phone'],
                    'address'    => $submission['address'],
                    'created_at' => date('d/m/Y', strtotime($submission['created_at'])),
                ];
            }

            $response = [
                'draw'            => (int) $this->request->getVar('draw'),
                'recordsTotal'    => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data'            => $data,
            ];

            $cache->save($cacheKey, $response, 1800);

            return $this->response->setStatusCode(200)->setJSON($response);
        } catch (\Exception $e) {
            log_message('error', 'Error getting form submissions: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => 'An error occurred while fetching form submissions']);
        }
    }
    public function getUserDocuments()
    {
        try {
            $formSubmissionId = $this->request->getPost('form_submission_id');

            if (!$formSubmissionId) {
                return $this->fail('Form submission ID is required', 400);
            }

            $model = new FormSubmissionModel();
            $data  = $model->getFormSubmissionsWithDocument($formSubmissionId);

            return $this->respond([
                'status' => 'success',
                'data'   => $data,
            ]);
        } catch (\Exception $e) {
            return $this->fail('An error occurred while processing the request', 500);
        }
    }

    public function verifyDoc()
    {
        try {
            $type        = $this->request->getPost('type');
            $userId      = $this->request->getPost('user_id');
            $id          = $this->request->getPost('id');
            $description = $this->request->getPost('description');

            $documentsModel = new DocumentsModel();

            switch ($type) {
                case 'approve':

                    $result = $documentsModel->approveDocument($id);
                    break;
                case 'reject':

                    $result = $documentsModel->rejectDocument($id,$description);
                    break;
                default:
                    return $this->fail('Invalid action type', 400);
            }

            if ($result) {
                return $this->respond(['status' => 'success', 'message' => 'Document action successful']);
            } else {
                return $this->fail('Failed to process the document action', 500);
            }
        } catch (\Exception $e) {
            return $this->fail('An error occurred while processing the request', 500);
        }
    }

}
