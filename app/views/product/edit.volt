
{{ form("product/save", 'role': 'form') }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("product", "&larr; Cancelar") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Salvar", "class": "btn btn-success") }}
    </li>
</ul>

{{ content() }}

<h2>Editar Produto</h2>

<fieldset>

    {% for element in form %}
        {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            {{ element }}
        {% else %}
            <div class="form-group">
                {{ element.label() }}
                {{ element.render(['class': 'form-control']) }}
            </div>
        {% endif %}
    {% endfor %}

</fieldset>

</form>
