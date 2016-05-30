
{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("", "&larr; Ínicio") }}
    </li>
    <li class="next">
        {{ link_to("product/new", "Cadastrar") }}
    </li>
</ul>

{{ form("product/search", "autocomplete": "off", "class": "form-inline") }}

<div class="center scaffold">
    <div class="page-header">
        <h2>Pesquisar Produtos</h2>
    </div>
    <div class="form-inline">
        {% for element in form %}
            {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
                {{ element }}
            {% else %}
                <div class="form-group">
                    {{ element.label(['class': 'control-label']) }}
                    <div class="">
                        {{ element.render(['class': 'form-control']) }}
                    </div>
                </div>
            {% endif %}
        {% endfor %}
        {{ submit_button("Buscar", "class": "btn btn-primary") }}
    </div>
</div>

</form>