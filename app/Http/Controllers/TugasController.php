<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factories\AssignmentFactory;
use App\Factories\DataFactory;
use App\Factories\ReviewerFactory;
use App\Facades\ModelFacade;
use App\Events\DataUpdated;
use App\Models\Reviewer;
use Illuminate\Support\Facades\Session;

class TugasController extends Controller
{
    protected $assignmentFactory;
    protected $dataFactory;
    protected $reviewerFactory;
    protected $modelFacade;

    public function __construct(
        AssignmentFactory $assignmentFactory,
        DataFactory $dataFactory,
        ReviewerFactory $reviewerFactory,
        ModelFacade $modelFacade
    ) {
        $this->assignmentFactory = $assignmentFactory;
        $this->dataFactory = $dataFactory;
        $this->reviewerFactory = $reviewerFactory;
        $this->modelFacade = $modelFacade;
    }

    public function index(Request $r)
    {
        $post = $this->modelFacade->getAssignmentsWithUsersAndReviewers(Session::get('id'));
        $v = $this->modelFacade->getAllValues();

        if ($r->ajax()) {
            return view('admin.tugas.lists', compact('post'), ['values' => $v]);
        }

        return view('admin.tugas.index', compact('post'), ['values' => $v]);
    }

    public function index_user(Request $r)
    {
        $post = $this->modelFacade->getAssignmentsWithUsersAndReviewers(Session::get('id'));
        $v = $this->modelFacade->getAllValues();

        if ($r->ajax()) {
            return view('admin.tugas.lists', compact('post'), ['values' => $v]);
        }

        return view('user.tugas.index', compact('post'), ['values' => $v]);
    }

    public function data()
    {
        try {
            $id = $_GET['id'];
            $q1 = $this->modelFacade->getReviewerAssignments($id, 0);
            return response()->json(['status' => 'ok', 'datas' => $q1]);
        } catch (\Throwable $th) {
            return response()->json(['status' => $th->getMessage()]);
        }
    }

    public function finish()
    {
        try {
            $id = $_GET['id'];
            $q1 = $this->modelFacade->getReviewerAssignments($id, 1);
            return response()->json(['status' => 'ok', 'datas' => $q1]);
        } catch (\Throwable $th) {
            return response()->json(['status' => $th->getMessage()]);
        }
    }

    public function loadCard()
    {
        try {
            $id = $_GET['id'];
            $q1 = $this->modelFacade->getReviewerAssignments($id, null);
            $selesai = Reviewer::where('id_assignments', $id)->where('finish', 1)->count();
            $belumSelesai = Reviewer::where('id_assignments', $id)->where('finish', 0)->count();
            $assignment = $this->modelFacade->getAssignmentDetails($id);
            return response()->json([
                'status' => 'ok',
                'belum' => $belumSelesai,
                'selesai' => $selesai,
                'assignment' => $assignment,
                'datas' => $q1
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => $th->getMessage()]);
        }
    }

    public function dataChoosed()
    {
        try {
            $id = $_GET['id'];
            $q = $this->dataFactory->create()->where('id', $id)->first();

            return response()->json(['status' => 'ok', 'datas' => $q]);
        } catch (\Throwable $th) {
            return response()->json(['status' => $th->getMessage()]);
        }
    }

    public function submit()
    {
        try {
            $idData = $_POST['idData'];
            $idR = $_POST['idReviewer'];
            $ram3 = $_POST['ram3'];
            $ketRam3 = $_POST['ketRam3'];

            $updateData = ['ram3' => $ram3, 'keterangan_ram3' => $ketRam3];
            $updateR = ['finish' => 1];

            $this->modelFacade->updateDataAndReviewer($idData, $idR, $updateData, $updateR);

            // Fire the DataUpdated event
            event(new DataUpdated($updateData));

            return response()->json(['status' => 'ok']);
        } catch (\Throwable $th) {
            return response()->json(['status' => $th->getMessage()]);
        }
    }
}
