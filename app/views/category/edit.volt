{{ form("category/save", 'role': 'form') }}

{{ content() }}
<div class="page-header">
    <h2>Editar Categoria</h2>
</div>

<fieldset>

    {% for element in form %}
        {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            {{ element }}
        {% else %}
            <div class="form-group">
                {#{{ element.label(['class': 'control-label']) }}#}
                <div class="controls">
                    {{ element }}
                </div>
            </div>
        {% endif %}
    {% endfor %}

    {{ submit_button("Salvar", "class": "btn btn-success") }}
    {{ link_to("category", "Cancelar", "class": "btn btn-primary") }}
</fieldset>

</form>

