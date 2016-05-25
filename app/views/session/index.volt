
{{ content() }}

<div class="row">

    <div class="col-md-4">
        <div class="page-header">
            <h2>Gerencie - Admin</h2>
        </div>
        {{ form('session/start', 'role': 'form') }}
        <fieldset>
            <div class="form-group">
                <label for="email">E-mail</label>
                <div class="controls">
                    {{ text_field('email', 'class': "form-control") }}
                </div>
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <div class="controls">
                    {{ password_field('pass', 'class': "form-control") }}
                </div>
            </div>
            <div class="form-group">
                {{ submit_button('Entrar', 'class': 'btn btn-primary btn-large') }}
            </div>
        </fieldset>
        </form>
    </div>

</div>
