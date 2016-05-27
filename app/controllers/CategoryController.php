<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CategoryController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Gerenciar Categorias');
        parent::initialize();
    }

    /**
     * Ação inicial, exibe o form de busca
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new CategoryForm;
    }

    /**
     * Realiza a busca de uma categoria baseada no que for informaado nos campos de pesquisa
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Category", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $category = Category::find($parameters);
        if (count($category) == 0) {
            $this->flash->notice("Nenhuma categoria encontrada");
            return $this->forward("category/index");
        }

        $pagintor = new Paginator(array(
            "data"  => $category,
            "limit" => 2,
            "page"  => $numberPage
        ));

        $this->view->page = $pagintor->getPaginate();
        $this->view->category = $category;
    }

    /**
     * Exibe a view para criar uma nova categoria
     */
    public function newAction()
    {
        $this->view->form = new CategoryForm(null, array('edit' => true));
    }

    /**
     * Cria uma categoria de acordo com os dados informados no método "newAction"
     */
    public function createAction()
    {
        if (!$this->request->isPost())
            return $this->forward('category/index');

        $form = new CategoryForm();
        $category = new Category();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $category)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('category/new');
        }
        
        if ($category->save() == false) {
            foreach ($category->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('category/new');
        }

        $form->clear();

        $this->flash->success('Categoria Cadastrada com sucesso');
        return $this->forward('category/index');
    }
}