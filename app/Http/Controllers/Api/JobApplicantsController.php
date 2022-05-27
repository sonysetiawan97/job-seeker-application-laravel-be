<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Jobs;
use Illuminate\Support\Facades\Validator;
use App\Models\Resources;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Services\ResponseService;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobApplicantsController extends ApiResourcesController
{
    protected $table_name = null;
    protected $model = null;
    protected $segments = [];
    protected $segment = null;
    protected $responder = null;

    public $response = array();

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(Request $request, Resources $model, ResponseService $responder)
    {

        try {
            $this->responder = $responder;
            $this->segment = $request->segment(3);
            if (file_exists(app_path('Models/' . Str::studly($this->segment)) . '.php')) {
                $this->model = app("App\Models\\" . Str::studly($this->segment));
            } else {
                if ($model->checkTableExists($this->segment)) {
                    $this->model = $model;
                    $this->model->setTable($this->segment);
                }
            }
            if ($this->model) {
                $this->responder->set('collection', $this->model->getTable());
                // SET default Authentication
                $this->middleware('auth:api', ['only' => $this->model->getAuthenticatedRoutes()]);
            }

            if (is_null($this->table_name)) $this->table_name = $this->segment;
            $this->segments = $request->segments();
        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    protected function checkPermissions($authenticatedRoute, $authorize)
    {
        if (in_array($authenticatedRoute, $this->model->getAuthenticatedRoutes())) {
            $table = $this->model->getTable();
            $generatedPermissions = [$table . '.*.*', $table . '.' . $authorize . '.*'];
            $defaultPermissions = $this->model->getPermissions($authorize);
            $permissions = array_merge($generatedPermissions, $defaultPermissions);
            $user = Auth::user();
            if (!$user->hasAnyPermission($permissions)) {
                throw new \Exception('You do not have authorization.');
            }
        }
    }

    public function applyJobs(Request $request)
    {
        if (is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->checkPermissions('store', 'create');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            $data = [];
            $user = Auth::user();
            if (is_null($user)) {
                $this->responder->set('message', 'User not found.');
                $this->responder->setStatus(404, '404 Not Found.');
                return $this->responder->response();
            }
            $roles = $user->getRoleNames()->toArray();
            if (!in_array('job_seeker', $roles)) {
                $this->responder->set('message', 'Invalid user role.');
                $this->responder->setStatus(404, '404 Not Found.');
                return $this->responder->response();
            }

            $jobId = $request->get('job_id');
            $userId = $user->id;
            $job = Jobs::find($jobId);
            if (is_null($job)) {
                $this->responder->set('message', 'Job Not Found.');
                $this->responder->setStatus(404, '404 Not Found.');
                return $this->responder->response();
            }
            $jobId = $job->id;
            
            $isApply = $this->isApply($jobId, $userId);
            if (!is_null($isApply)) {
                $this->responder->set('message', 'Job Already applied.');
                $this->responder->setStatus(400, 'Invalid data.');
                return $this->responder->response();
            }

            $params = [
                'user_id' => $userId,
                'job_id' => $jobId,
                'status_applicant' => 'review',
            ];

            foreach ($params as $key => $value) {
                $this->model->setAttribute($key, $value);
            }
            $this->model->save();
            $data = [
                'user' => $user,
                'job' => $job,
                'model' => $this->model,
            ];

            $this->responder->set('message', 'Job Applied.');
            $this->responder->set('data', $data);
            return $this->responder->response();
        } catch (Exception $exception) {
            $this->responder->set('message', $exception->getMessage());
            $this->responder->setStatus(500, 'Internal Server Error.');
            return $this->responder->response();
        }
    }

    public function isApply($jobId, $userId)
    {
        $model = $this->model->where('job_id', '=', $jobId)->where('user_id', '=', $userId)->first();
        return $model;
    }
}
