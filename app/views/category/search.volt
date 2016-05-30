{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("category", "&larr; Voltar") }}
    </li>
    <li class="next">
        {{ link_to("category/new", "Cadastrar") }}
    </li>
</ul>

{% for category in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped table-responsive" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nome</th>
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
            <td>{{ category.id }}</td>
            <td>{{ category.name }}</td>
            <td width="7%">{{ link_to("category/edit/" ~ category.id, '<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar', "class": "btn btn-primary") }}</td>
            <td width="7%">{{ link_to("category/delete/" ~ category.id, '<i class="fa fa-trash" aria-hidden="true"></i> Excluir', "class": "btn btn-danger") }}</td>
        </tr>
    {% if loop.last %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="4" align="right">
                {{ link_to("category/search", '<i class="icon-fast-backward"></i> Primeira', "class": "btn") }}
                {{ link_to("category/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Anterior', "class": "btn") }}
                {{ link_to("category/search?page=" ~ page.next, '<i class="icon-step-backward"></i> Próxima', "class": "btn") }}
                {{ link_to("category/search?page=" ~ page.last, '<i class="icon-step-backward"></i> Última', "class": "btn") }}
                <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
            </td>
        </tr>
    </tbody>
</table>
    {% endif %}
{% else %}
    Nenhuma categoria cadastrada
{% endfor %}