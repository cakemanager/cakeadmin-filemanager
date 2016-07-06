<?php
namespace FileManager\View\Helper;

use Cake\View\Helper;

/**
 * FileManager helper
 */
class FileManagerHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public $helpers = [
        'Html',
        'FileManager.FileManager'
    ];

    public function url($item, $path)
    {
        if ($item['type'] === 'folder') {
            $url = [
                'prefix' => 'admin',
                'plugin' => 'FileManager',
                'controller' => 'Manager',
                'action' => 'index',
                $path,
                $item['name'],
            ];
        }

        if ($item['type'] === 'file') {
            $url = [
                'prefix' => 'admin',
                'plugin' => 'FileManager',
                'controller' => 'Manager',
                'action' => 'view',
                $path,
                $item['name'],
            ];
        }

        return $url;
    }

    public function breadcrumb($crumb)
    {
        $stack = '';
        $this->Html->addCrumb('Webroot', ['action' => 'index']);
        foreach ($crumb as $item) {
            $stack = $stack . '/' . $item;
            $this->Html->addCrumb($item, ['action' => 'index', $stack]);
        }
        return $this->Html->getCrumbList();
    }

}
