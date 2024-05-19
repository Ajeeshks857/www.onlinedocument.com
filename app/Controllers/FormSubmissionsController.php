<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DocumentsModel;
use App\Models\FormSubmissionModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class FormSubmissionsController extends BaseController
{

    use ResponseTrait;
    protected $auth;

    public function __construct()
    {
        $this->auth = service('authentication');
    }
    public function submitForm()
    {
        if (!$this->auth->check()) {
            return $this->failUnauthorized('User is not logged in');
        }
        $user = $this->auth->user();

        try {

            $validationRules = [
                'text'    => 'required',
                'email'   => 'required|valid_email',
                'phone'   => 'required|numeric|exact_length[10]',
                'address' => 'required',

            ];

            if (!$this->validate($validationRules)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $formData            = $this->request->getPost();
            $files               = $this->request->getFiles();
            $formData['user_id'] = $user->id;

            $formSubmissionModel = new FormSubmissionModel();
            $formSubmissionId    = $formSubmissionModel->insert($formData);

            if ($formSubmissionId) {
                $documentsModel = new DocumentsModel();

                foreach ($files['files'] as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move(WRITEPATH . 'uploads', $newName);

                        $documentData = [
                            'form_submission_id' => $formSubmissionId,
                            'file_name'          => $file->getClientName(),
                            'file_path'          => $newName,
                            'user_id'            => $user->id,

                        ];

                        $documentsModel->insert($documentData);
                    } else {
                        throw new \RuntimeException('File upload failed: ' . $file->getErrorString());
                    }
                }
            }

            return $this->respondCreated(['message' => 'Form submitted successfully'], ResponseInterface::HTTP_CREATED);
        } catch (\Exception $e) {
            log_message('error', 'Form submission error: ' . $e->getMessage());
            return $this->failServerError('An error occurred while processing the form submission');
        }
    }

    public function getDetails()
    {
        try {
            if (!$this->auth->check()) {
                return $this->response->setStatusCode(401)->setJSON(['error' => 'User is not logged in']);
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

            $documentsModel = new DocumentsModel();

            $totalRecords = $documentsModel->where('user_id', $user->id)->countAllResults();

            $submissions = $documentsModel->getFormSubmissionsWithDocuments($user->id, $perPage, ($page - 1) * $perPage);

            $data = [];
            foreach ($submissions as $submission) {
                $description = $submission->description;
                
                $data[] = [
                    'id'              => $submission->id,
                    'file_name'       => $submission->file_name,
                    'approval_status' => $submission->approval_status,
                    'description'     => $description,
                    'approved_date'   => date('d/m/Y', strtotime($submission->approved_date)),
                    'created_at'      => date('d/m/Y', strtotime($submission->created_at)),
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

}
