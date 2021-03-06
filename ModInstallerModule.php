<?php
/**
 * @author: he11d0g <im@helldog.net>
 * @date:   15.10.13
 * @link    http://helldog.net
 */
use yupe\components\WebModule;

class ModInstallerModule extends WebModule
{
  public function getDependencies()
    {
        return array();
    }

    public function getModulesPath()
    {
        return Yii::getPathOfAlias('application.modules');
    }

    public function getTempPath()
    {
        return Yii::getPathOfAlias('application.runtime');
    }

    public function checkSelf()
    {
        $messages = array();

        $modulesPath = $this->getModulesPath();
        $tempPath = $this->getTempPath();
        if (!is_writable($modulesPath) || !is_writable($tempPath)) {
            $messages['dir'] = 'Директория "'.$modulesPath.'" или директория "{'.$tempPath.'}" не доступна для записи!';
        }
        if (!extension_loaded("zip")) {
            $messages['zip'] = 'Не установлено расширения для работы с архивами!';
        }
        return $messages ? $messages : true;
    }

    public function getParamsLabels()
    {
        return array();
    }
    
    public function getAdminPageLink()
    {
        return '/modinstaller/defaultBackend/index';
    }
    
    public function getCategory()
    {
        return Yii::t('ModinstallerModule.modinstaller', 'Сервисы');
    }

    public function getEditableParams()
    {
        return array();
    }

    public function getVersion()
    {
        return Yii::t('ModInstallerModule.modinstaller', '0.1');
    }

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getName()
    {
        return Yii::t('ModInstallerModule.modinstaller', 'Установщик модулей');
    }

    public function getDescription()
    {
        return Yii::t('ModInstallerModule.modinstaller', 'Модуль для установки сторонних модулей');
    }

    public function getAuthor()
    {
        return Yii::t('ModInstallerModule.modinstaller', 'he11d0g');
    }

    public function getAuthorEmail()
    {
        return Yii::t('ModInstallerModule.modinstaller', 'im@helldog.net');
    }

    public function getUrl()
    {
        return Yii::t('ModInstallerModule.modinstaller', 'http://helldog.net');
    }

    public function getIcon()
    {
        return "leaf";
    }

    public function getNavigation()
    {
        return array(

        );
    }

    public function isMultiLang()
    {
        return true;
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'modinstaller.models.*',
            'modinstaller.components.*',
        ));
    }
}
