<?php
/**
 * CakeManager (http://cakemanager.org)
 * Copyright (c) http://cakemanager.org
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) http://cakemanager.org
 * @link          http://cakemanager.org CakeManager Project
 * @since         1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace FileManager\Controller\Admin;

use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use CakeAdmin\Controller\AppController;

/**
 * Manager Controller
 *
 * @property \FileManager\Model\Table\ManagerTable $Manager
 */
class ManagerController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('FileManager.FileManager');


    }

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        $this->Menu->active('filemanager');
    }

    public function index($path = null)
    {
        $root = WWW_ROOT;
        $fullPath = $root . $path;

        $files = $this->FileManager->read($fullPath);


        $this->set('path', $path);
        $this->set('crumb', $this->FileManager->breadcrumb($path));
        $this->set('fullPath', $fullPath);
        $this->set('files', $files);
    }

    public function view($path = null)
    {
        $file = new File($path, false);

        if (!$file->exists()) {
            return $this->redirect($this->referer());
        }

        $this->set('file', $file);
        $this->set('crumb', $this->FileManager->breadcrumb($path));

    }

    public function create($path = null)
    {
        $root = WWW_ROOT;
        $fullPath = $root . $path;

        if ($this->request->is('post')) {
            $folderName = $this->request->data['name'];

            $folder = new Folder($fullPath);

            if ($folder->create($folderName)) {
                $this->Flash->success(__('The folder "{0}" has been created.', $folderName));
                return $this->redirect(['action' => 'index', $path]);
            }
            $this->Flash->error(__('The folder "{0}" could not be created.', $folderName));
        }
    }

    public function upload($path = null)
    {
        $root = WWW_ROOT;
        $fullPath = $root . $path;

        if ($this->request->is('post')) {
            foreach ($this->request->data['file'] as $file) {
                $new = new File($fullPath . DS . $file['name'], false);

                if (!$new->exists()) {
                    $new->create();
                    $new->write(file_get_contents($file['tmp_name']));
                }

            }

            if (count($this->request->data['file']) > 1) {
                $this->Flash->success(__('The files have been saved.'));
            } else {
                $this->Flash->success(__('The file has been saved.'));
            }
            return $this->redirect(['action' => 'index', $path]);
        }
        $this->Flash->error(__('The file(s) could not be saved.'));
    }

    public function delete($path)
    {
        $root = WWW_ROOT;
        $fullPath = $root . $path;

        $dir = new File($path, false);
        if (!$dir->exists()) {
            $dir = new Folder($path);
        }
        if ($dir->delete()) {
            $this->Flash->success(__('Deleted successfully.'));
        } else {
            $this->Flash->error(__('Could not delete.'));
        }
        return $this->redirect($this->referer());
    }

}
