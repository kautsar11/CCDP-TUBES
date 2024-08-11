<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function download($parameter)
    {
    if (!$parameter) {
     return redirect()->to('/auth');
    } else {
     switch ($parameter) {
     case 'DataTemplate':
     $factory = new TemplateFileFactory();
     break;
     case 'MonthlyReport':
     $factory = new ReportFileFactory();
     break;
     default:
     return redirect()->to('/auth');
     }
     $file = $factory->createFile();
     return response()->download($file->getPath(), $file->getName());
    }
    }
    
}
