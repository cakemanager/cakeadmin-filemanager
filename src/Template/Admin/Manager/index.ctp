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

//debug($path);
?>
    <h3>FileManager</h3>

<?= $this->FileManager->breadcrumb($crumb, $path) ?>

    <div class="row">

        <div class="col-md-8 large-8 columns">
            <h4>Files & Folders</h4>
            <hr>
            <table cellpadding="0" cellspacing="0" class="table">
                <thead>
                <tr>
                    <td> Name</td>
                    <td> Size</td>
                    <td> Actions</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($files as $item): ?>
                    <tr>
                        <td><?= $this->Html->link($item['name'], $this->FileManager->url($item, $path)) ?></td>
                        <td><?= $this->Number->toReadableSize($item['size']) ?></td>
                        <td>
                            <?= $this->Form->postLink(
                                'Delete',
                                ['action' => 'delete', $path, $item['name']],
                                ['confirm' => __('Are you sure you want to delete # {0}?', $item['name'])]
                            ) ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-4 large-4 columns">
            <h4>Actions</h4>
            <hr>

            <h5>Create folder</h5>
            <?= $this->element('FileManager.create') ?>

            <h5>Upload file</h5>
            <?= $this->element('FileManager.upload') ?>

        </div>
    </div>

<?php
