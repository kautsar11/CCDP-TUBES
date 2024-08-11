<?php

namespace app\File;
use app\File\File;
class TemplateFile implements File
{
private $path;
private $name;
public function __construct()
{
 $this->path = 'public/template/DataTemplate.xlsx';
 $this->name = 'DataTemplate.xlsx';
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