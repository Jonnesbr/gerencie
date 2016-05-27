{{ content() }}

<div align="right">
    {{ link_to("category/new", "Criar uma nova Categoria", "class": "btn btn-primary") }}
</div>

{{ form("category/search", "autocomplete": "off", "class": "form-inline") }}

    <div class="center scaffold">
        <div class="page-header">
            <h2>Pesquisar Categorias de Produtos</h2>
        </div>
        <div class="form-group">
            {{ numeric_field("id", "size": 11, "maxlenght": 10, "placeholder": "Id", "class": "form-control") }}
        </div>
        <div class="form-group">
            {{ text_field("nome", "size": 24, "maxlenght": 80, "placeholder": "Nome", "class": "form-control") }}
        </div>
        {{ submit_button("Buscar", "class": "btn btn-primary") }}
    </div>

</form>