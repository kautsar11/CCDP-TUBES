<?php

namespace app\File;
class ReportFile implements File
{
private $path;
private $name;
public function __construct()
{
 $this->path = 'public/reports/MonthlyReport.pdf';
 $this->name = 'MonthlyReport.pdf';
}
public function getPath(): string
{
 return Storage::path($this->path);
}
public function getName(): string
{
 return $this->name;
}
}

?>