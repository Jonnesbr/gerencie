<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

/**
 * Class ProductController
 *
 * Gerenciamento de todas as operações do CRUD de Produto
 */
class ProductController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Gerenciar Produtos');
        parent::initialize();
    }

    /**
     * Ação inicial, exibe o form de busca
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new ProductForm;
    }

    /**
     * Realiza a busca de um produto baseada no que for informado nos campos de pesquisa
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Product", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $product = Product::find($parameters);
        if (count($product) == 0) {
            $this->flash->notice("Nenhum produto encontrado");
            return $this->forward("product/index");
        }

        $pagintor = new Paginator(array(
            "data"  => $product,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $pagintor->getPaginate();
        $this->view->category = $product;
    }

    /**
     * Exibe a view para criar um novo produto
     */
    public function newAction()
    {
        $this->view->form = new ProductForm(null, array('edit' => true));
    }

    /**
     * Cria um produto de acordo com os dados postados
     */
    public function createAction()
    {
        if (!$this->request->isPost())
            return $this->forward('product/index');

        $form = new ProductForm();
        $product = new Product();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $product)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('product/new');
        }

        if ($product->save() == false) {
            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('product/new');
        }

        $form->clear();

        $this->flash->success('Produto cadastrado com sucesso');
        return $this->forward('product/index');
    }

    /**
     * Salva o produto que foi carregado para edição, após validação (editAction)
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward('product/index');
        }

        $id = $this->request->getPost("id", "int");

        $product = Product::findFirstById($id);
        if (!$product) {
            $this->flash->error('Produto não existente');
            return $this->forward('product/index');
        }

        $form = new ProductForm;
        $this->view->form = $form;

        $data = $this->request->getPost();
        if (!$form->isValid($data, $product)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('product/edit/' . $id);
        }

        if ($product->save() == false) {
            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('product/edit/' . $id);
        }

        $form->clear();

        $this->flash->success('Produto atualizado com sucesso');
        return $this->forward('product/index');
    }

    /**
     * Antes de editar produto, é verificado se o ID informado existe, se sim, é carregado ProductForm.
     *
     * @param string $argId
     */
    public function editAction($argId)
    {
        if (!$this->request->isPost()) {
            $product = Product::findFirstById($argId);
            if(!$product) {
                $this->flash->error("Produto não encontrado");
                return $this->forward('product/index');
            }

            $this->view->form = new ProductForm($product, array('edit' => true));
        }
    }

    /**
     * Excluir produto
     *
     * @param string $argId
     */
    public function deleteAction($argId)
    {
        $product = Product::findFirstById($argId);
        if (!$product) {
            $this->flash->error('Produto não encontrada');
            return $this->forward('product/index');
        }

        if (!$product->delete()) {
            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('product/search');
        }

        $this->flash->success('Produto excluido com sucesso');
        return $this->forward('product/index');
    }

}

