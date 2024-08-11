<?php

namespace app\File;
class ReportFileFactory implements FileFactory
{
public function createFile(): File
{
 return new ReportFile();
}
}
?>