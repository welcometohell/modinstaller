<?php
/**
 * @author: he11d0g <im@helldog.net>
 * @date:   15.10.13
 * @link    http://helldog.net
 */

class Form extends CFormModel
{
    public $file;
    public $url;
    public $tempfile;
    
    public function rules()
    {
        return array(
            array('file','file','types' => 'zip','allowEmpty' => true),
            array('url','url','allowEmpty' => true),
        );
    }

    public function saveModule($moduleName)
    {
         $tempPath = Yii::app()->controller->module->getTempPath();
         $tempCat = $tempPath.'/'.$moduleName;
         $todir = Yii::app()->controller->module->getModulesPath();
         $todir = $todir.'/'.$moduleName;
         CFileHelper::copyDirectory($tempCat, $todir);
         CFileHelper::removeDirectory($tempCat);
         //rmdir($tempCat);
         unlink($this->tempfile);
    }
    
    public function validate() {
        $zip = new ZipArchive();
        $file = CUploadedFile::getInstance($this,'file');
        $tempPath = Yii::app()->controller->module->getTempPath();
        $this->tempfile = $tempFile = $tempPath.'/'.$file->name;
        // сохраним во временную папку
        $file->saveAs($tempFile);
        $moduleName = "";
        if ($zip->open($tempFile) == true) {
            // пройдемся по архиву, проверим, есть ли там класс модуля, заодно если есть извлечем из него имя модуля
            for($i = 0; $i < $zip->numFiles; $i++)
            {
                $filename = $zip->getNameIndex($i);
                if (strstr($filename, "Module.php") && !strstr($filename, "/") ){
                    $moduleName = mb_strtolower(str_replace("Module.php", "", $filename));
                }
            }
        }
        else {
            unlink($this->tempfile);
            $this->addError('attr', "Что-то не так с архивом, проверьте.. (.zip?)");
            return false;
        }
        if ($moduleName) {
            // хорошо бы уточнить, нет ли уже у нас такого модуля?
            foreach (scandir (Yii::app()->controller->module->getModulesPath()) as $name) {
                if ($name == $moduleName) {
                    // уже есть, что делать будем?
                    $zip->close();
                    unlink($this->tempfile);
                    $this->addError('attr', "У же есть такой модуль.. Можно было-бы его заменить по согласию, но это позже");
                    return false;
                }
            }
            // если нашли файл модуля, то скорее всего все хорошо, распакуем архив
            $zip->extractTo($tempPath.'/'.$moduleName);
            $zip->close();
            return $moduleName;
        }
        else {
            unlink($this->tempfile);
            $this->addError('attr', "Не корректная струтура каталогов модуля, мы не нашли основной файл модуля");
            return false;
        }
    }
    
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'file'             => Yii::t('ModInstallerModule.modinstaller', 'file'),
            'url'      => Yii::t('ModInstallerModule.modinstaller', 'url'),
        );
    }


}
