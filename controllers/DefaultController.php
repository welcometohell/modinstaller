<?php
/**
 * @author: he11d0g <im@helldog.net>
 * @date:   15.10.13
 * @link    http://helldog.net
 */

class DefaultController extends yupe\components\controllers\BackController
{
    private $_error;

    public function actionIndex()
    {
        $model = new Form();
        if(isset($_POST['Form'])){
            $check=Yii::app()->controller->module->checkSelf();
            if($check === true)
            {
                $model->attributes = $_POST['Form'];
                if($name = $model->validate()) {
                    $model->saveModule($name);
                    Yii::app()->user->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('ModInstallerModule.modinstaller', 'Модуль '.$name.' успешно установлен!')
                    );
                }
             }
             else {
               $model->addErrors($check);
             }
        }
        $this->render('index',array('model' => $model));
    }

}
