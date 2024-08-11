<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Imports\DatasImport;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Singleton\SingletonTrait;

class ExcelController extends Controller
{
    use SingletonTrait;

    public function process(Request $r)
    {
        try {
            $unique = time() . Str::random(10);
            Session::put('unique_id', $unique);
            $file = Excel::import(new DatasImport, $r->file('file'));
            $fileName = $r->file('file')->getClientOriginalName();

            if ($file) {
                Session::put('preview_access','granted');
                Session::put('fileName', $fileName);
                return redirect()->to('admin/data/preview');
            } else {
                return redirect()->back()->with('error', 'Failed');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('excelNotValid', $e->getMessage());
        }
    }
}
