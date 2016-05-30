

{{ form("product/create") }}

    {{ content() }}
    <div class="page-header">
        <h2>Cadastrar novo produto</h2>
    </div>

    <fieldset>

        <div class="form-horizontal">
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
            <div class="form-group">
                {{ submit_button("Salvar", "class": "btn btn-success") }}
                {{ link_to("product", "Cancelar", "class": "btn btn-primary") }}
            </div>
        </div>

    </fieldset>

</form>
