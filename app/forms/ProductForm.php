<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Numericality;

class ProductForm extends Form
{
    /**
     * Incializando o form de produtos
     */
    public function initialize($entity = null, $options = array())
    {
        if (!isset($options['edit'])) {
            $element = new Text('id');
            $this->add($element->setLabel('Id'));
        } else {
            $this->add(new Hidden('id'));
        }

        $name = new Text('name');
        $name->setLabel('Nome');
        $name->setFilters(array('striptags', 'string'));
        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'O campo Nome é obrigatório'
            ))
        ));
        $this->add($name);

        $category = new Select('category_id', Category::find(), array(
            'using'      => array('id', 'name'),
            'useEmpty'   => true,
            'emptyText'  => 'Selecione',
            'emptyValue' => ''
        ));
        $category->setLabel('Categoria');
        $this->add($category);

        $price = new Text('price');
        $price->setLabel('Preço');
        $price->setFilters(array('float'));
        $price->addValidators(array(
            new PresenceOf(array(
                'message' => 'O campo Preço é obrigatório'
            )),
            new Numericality(array(
                'message' => 'O campo Preço possui um valor inválido'
            ))
        ));
        $this->add($price);
    }
}