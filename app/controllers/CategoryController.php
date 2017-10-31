<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

/**
 * Class CategoryController
 *
 * Gerenciamento de todas as operações do CRUD de Categoria
 */
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
            "limit" => 5,
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

        $this->flash->success('Categoria cadastrada com sucesso');
        return $this->forward('category/index');
    }

    /**
     * Antes de editar categoria, é verificado se o ID informado existe, se sim, é carregado CategoryForm.
     *
     * @param string $argId
     */
    public function editAction($argId)
    {
        if (!$this->request->isPost()) {
            $category = Category::findFirstById($argId);
            if(!$category) {
                $this->flash->error("Categoria não encontrada");
                return $this->forward('category/index');
            }

            $this->view->form = new CategoryForm($category, array('edit' => true));
        }
    }

    /**
     * Salva a categoria que foi carregada para edição, após validação (editAction)
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward('category/index');
        }

        $id = $this->request->getPost("id", "int");

        $category = Category::findFirstById($id);
        if (!$category) {
            $this->flash->error('Categoria não existente');
            return $this->forward('category/index');
        }

        $form = new CategoryForm;

        $data = $this->request->getPost();
        if (!$form->isValid($data, $category)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('category/edit' . $id);
        }

        if ($category->save() == false) {
            foreach ($category->getMessages() as $message) {
                    $this->flash->error($message);
            }
            return $this->forward('category/new');
        }

        $form->clear();

        $this->flash->success('Categoria atualizada com sucesso');
        return $this->forward('category/index');
    }

    /**
     * Excluir categoria
     *
     * @param string $argId
     */
    public function deleteAction($argId)
    {
        $category = Category::findFirstById($argId);
        if (!$category) {
            $this->flash->error('Categoria não encontrada');
            return $this->forward('category/index');
        }

        if (!$category->delete()) {
            foreach ($category->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('category/search');
        }

        $this->flash->success('Categoria excluida com sucesso');
        return $this->forward('category/index');
    }
}
