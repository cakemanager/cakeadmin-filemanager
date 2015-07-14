<?php
namespace FileManager\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\Routing\Router;

/**
 * FileManager component
 */
class FileManagerComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function read($path)
    {
        $dir = new Folder($path);
        $read = $dir->read();

        $result = [];

        foreach ($read[0] as $folder) {
            $info = new Folder($path . DS . $folder);
            $reference = Router::fullBaseUrl() . '/' . $this->toRelative($path . '/' . $folder);

            $data = [
                'name' => $folder,
                'type' => 'folder',
                'path' => $path . DS . $folder,
                'reference' => $reference,
                'extension' => 'folder',
                'size' => $info->dirsize(),
            ];
            $result[] = $data;
        }

        foreach ($read[1] as $file) {
            $info = new File($path . DS . $file, false);
            $reference = Router::fullBaseUrl() . '/' . $this->toRelative($path . '/' . $file);

            $data = [
                'name' => $info->info()['basename'],
                'type' => 'file',
                'path' => $path,
                'reference' => $reference,
                'extension' => $info->info()['extension'],
                'size' => $info->info()['filesize'],
            ];
            $result[] = $data;
        }

        return $result;
    }

    public function breadcrumb($path)
    {
        return explode('/', $path);
    }

    public function toRelative($path)
    {
        $base = WWW_ROOT;

        return str_replace($base, "", $path);
    }
}
