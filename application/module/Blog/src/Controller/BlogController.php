<?php

namespace Blog\Controller;

use Blog\Form\PostForm;
use Blog\Model\Post;
use Blog\Model\PostTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BlogController extends AbstractActionController
{
    private $table;

    function __construct(PostTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        $postTabe = $this->table;
        return new ViewModel([
            'posts' => $postTabe->fetchAll()
        ]);
    }

    public function saveAction()
    {

        $form = new PostForm('Post');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $post = new Post();
                $post->exchangeArray($form->getData());
                $this->table->save($post);
                return $this->redirect()->toRoute('post');
            }
        }

        $id = (int) $this->params()->fromRoute('id', 0);

        if ($id) {
            try {
                $post = $this->table->find($id);
                $form->bind($post);
                $form->get('submit')->setAttribute('value', 'Edit Post');
            } catch (\Exception $e) {
                return $this->redirect()->toRoute('post');
            }
        }

        return [
            'id' => $id,
            'form' => $form
        ];
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('post');
        }

        $this->table->delete($id);
        return $this->redirect()->toRoute('post');
    }
}
