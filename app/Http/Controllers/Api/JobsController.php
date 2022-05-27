<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Resources;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Services\ResponseService;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobsController extends ApiResourcesController
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
        $user = Auth::user();
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->checkPermissions('index', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            $user = Auth::user();
            $roles = $user->getRoleNames()->toArray();
            $company = null;

            if (in_array('recruiter', $roles)) {
                $company = $user->company($user['id']);
            }
            $count = $this->model->count();
            $model = $this->model->filter();

            $format = $request->get('format', 'default');

            $limit = intval($request->get('limit', 25));
            if ($limit > 100) {
                $limit = 100;
            }

            $p = intval($request->get('page', 1));
            $page = ($p > 0 ? $p - 1 : $p);

            if ($format == 'datatable') {
                $draw = $request['draw'];
            }

            $modelCount = clone $model;
            $meta = array(
                'recordsTotal' => $count,
                'recordsFiltered' => $modelCount->count()
            );

            $data = $model->offset($page * $limit)->limit($limit);

            if ($company) {
                $data->where('company_id', $company->id);
            }

            $data = $data->get();

            $this->responder->set('message', 'Data retrieved.');
            $this->responder->set('meta', $meta);
            $this->responder->set('data', $data);
            if ($format == 'datatable') {
                $this->responder->set('draw', $draw);
                $this->responder->set('recordsFiltered', $meta['recordsFiltered']);
                $this->responder->set('recordsTotal', $meta['recordsTotal']);
            }
            return $this->responder->response();
        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }
}
