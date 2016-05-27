{{ form("category/create", "class": "form-inline", "autocomplete": "off") }}
<div align="right">
    {{ link_to("category", "Cancelar", "class": "btn btn-primary") }}
</div>
    {{ content() }}
    <div class="page-header">
        <h2>Cadastrar nova categoria</h2>
    </div>
    <div class="form-group">
        {{ text_field("name", "size": 24, "maxlength": 80, "class": "form-control", "placeholder": "Nome") }}
    </div>
        {{ submit_button("Salvar", "class": "btn btn-success") }}
</form>