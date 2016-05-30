{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("product", "&larr; Voltar") }}
    </li>
    <li class="next">
        {{ link_to("product/new", "Cadastrar") }}
    </li>
</ul>

{% for product in page.items %}
    {% if loop.first %}
        <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Preço</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
    {% endif %}
    <tr>
        <td>{{ product.id }}</td>
        <td>{{ product.name }}</td>
        <td>{{ product.getCategory().name }}</td>
        <td>${{ "%.2f"|format(product.price) }}</td>
        <td>{{ product.getActiveDetail() }}</td>
        <td width="7%">{{ link_to("product/edit/" ~ product.id, '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar', "class": "btn btn-primary") }}</td>
        <td width="7%">{{ link_to("product/delete/" ~ product.id, '<i class="fa fa-trash" aria-hidden="true"></i> Excluir', "class": "btn btn-danger") }}</td>
    </tr>
    {% if loop.last %}
        </tbody>
        <tbody>
        <tr>
            <td colspan="7" align="right">
                {{ link_to("product/search", '<i class="icon-fast-backward"></i> Primeira', "class": "btn") }}
                {{ link_to("product/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Anterior', "class": "btn") }}
                {{ link_to("product/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Próxima', "class": "btn") }}
                {{ link_to("product/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Última', "class": "btn") }}
                <span class="help-inline">{{ page.current }} / {{ page.total_pages }}</span>
            </td>
        </tr>
        </tbody>
        </table>
    {% endif %}
{% else %}
    Nenhum produto encontrado
{% endfor %}
