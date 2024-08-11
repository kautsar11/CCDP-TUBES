<?php

namespace app\File;
class TemplateFileFactory implements FileFactory
{
public function createFile(): File
{
 return new TemplateFile();
}
}
?>
