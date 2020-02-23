<?php

namespace Blog\Form;

use Zend\Form\Form;

class PostForm extends Form
{

    public function __construct($name)
    {
        parent::__construct($name);

        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);

        $this->add([
            'name' => 'title',
            'type' => 'text',
            'options' => [
                'label' => 'Title'
            ]
        ]);

        $this->add([
            'name' => 'content',
            'type' => 'text',
            'options' => [
                'label' => 'Content'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Add Post',
                'id' => 'submitbutton'
            ]
        ]);
    }
}
