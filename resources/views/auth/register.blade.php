@extends('adminlte::auth.register')

@section('auth_body')

    {{-- Conserva el formulario original --}}
    @parent

    {{-- Aviso de privacidad --}}
    <div class="form-group mb-3 mt-2">
        <div class="form-check">
            <input type="checkbox" name="privacidad" class="form-check-input" id="privacyCheck" value="1">
            <label class="form-check-label" for="privacyCheck">
                Acepto el <a href="#" data-toggle="modal" data-target="#privacyModal">aviso de privacidad</a>
            </label>
        </div>
        @error('privacidad')
            <span class="text-danger d-block"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    {{-- Modal del aviso --}}
    <div class="modal fade" id="privacyModal" tabindex="-1" role="dialog" aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aviso de Privacidad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    <p><strong>Responsable del Tratamiento:</strong> Esta aplicación es responsable de resguardar sus datos personales.</p>
                    <p><strong>Datos que recabamos:</strong> Nombre, correo electrónico, contraseña y otros datos requeridos por el sistema.</p>
                    <p><strong>Finalidades:</strong> Registrar usuarios, autenticar el acceso, ofrecer funcionalidades según el rol y enviar notificaciones del sistema.</p>
                    <p><strong>Protección:</strong> Se aplican medidas técnicas y administrativas para resguardar su información.</p>
                    <p><strong>Derechos ARCO:</strong> Usted puede acceder, rectificar, cancelar u oponerse al tratamiento de sus datos en cualquier momento.</p>
                    <p><strong>Transferencias:</strong> No se comparten sus datos con terceros, salvo requerimiento legal.</p>
                    <p><strong>Modificaciones:</strong> Este aviso puede cambiar. Le notificaremos por este medio.</p>
                    <p class="mb-0"><strong>Fecha de actualización:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkbox = document.getElementById('privacyCheck');
            const form = document.querySelector('form');
            const registerBtn = form.querySelector('button[type="submit"]');

            if (checkbox && registerBtn) {
                registerBtn.disabled = true;

                checkbox.addEventListener('change', function () {
                    registerBtn.disabled = !checkbox.checked;
                });

                form.addEventListener('submit', function (e) {
                    if (!checkbox.checked) {
                        e.preventDefault();
                        alert('Debes aceptar el aviso de privacidad para continuar.');
                    }
                });
            }
        });
    </script>
@endsection
