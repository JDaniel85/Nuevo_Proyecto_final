// session-timeout.js
class SessionTimeout {
    constructor() {
        this.timeoutMinutes = 1; // 3 minutos
        this.checkInterval = 30000; // Verificar cada 30 segundos
        this.warningTime = 30; // Mostrar advertencia 1 minuto antes
        this.checkTimer = null;
        this.warningShown = false;
        this.lastActivity = Date.now();
        
        this.init();
    }
    
    init() {
        // Eventos que indican actividad del usuario
        const events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'];
        
        events.forEach(event => {
            document.addEventListener(event, () => {
                this.updateActivity();
            }, true);
        });
        
        // Iniciar verificación periódica
        this.startChecking();
        
        // Verificar cuando la ventana obtiene el foco
        window.addEventListener('focus', () => {
            this.checkSession();
        });
        
        // Verificar cuando la página se vuelve visible
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                this.checkSession();
            }
        });
    }
    
    updateActivity() {
        this.lastActivity = Date.now();
        this.warningShown = false;
        
        // Cerrar modal de advertencia si está abierto
        if (typeof $.fn.modal !== 'undefined') {
            $('#sessionWarningModal').modal('hide');
        }
    }
    
    startChecking() {
        this.checkTimer = setInterval(() => {
            this.checkSession();
        }, this.checkInterval);
    }
    
    async checkSession() {
        try {
            const response = await fetch('/check-session', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const data = await response.json();
            
            if (!response.ok || !data.authenticated) {
                this.logout(data.redirect);
                return;
            }
            
            // Mostrar advertencia si queda poco tiempo
            if (data.remaining_time <= this.warningTime && !this.warningShown) {
                this.showWarning(data.remaining_time);
            }
            
        } catch (error) {
            console.error('Error verificando sesión:', error);
            // En caso de error de red, verificar después de un tiempo
            setTimeout(() => this.checkSession(), 10000);
        }
    }
    
    showWarning(remainingTime) {
        this.warningShown = true;
        const minutes = Math.floor(remainingTime / 60);
        const seconds = remainingTime % 60;
        
        // Crear modal de advertencia si no existe
        if (!document.getElementById('sessionWarningModal')) {
            this.createWarningModal();
        }
        
        const timeDisplay = minutes > 0 ? `${minutes}:${seconds.toString().padStart(2, '0')}` : `${seconds}`;
        document.getElementById('warningTime').textContent = timeDisplay;
        
        // Mostrar modal (AdminLTE usa Bootstrap)
        if (typeof $.fn.modal !== 'undefined') {
            $('#sessionWarningModal').modal('show');
        } else if (typeof bootstrap !== 'undefined') {
            new bootstrap.Modal(document.getElementById('sessionWarningModal')).show();
        }
    }
    
    createWarningModal() {
        const modalHTML = `
            <div class="modal fade" id="sessionWarningModal" tabindex="-1" role="dialog" aria-labelledby="sessionWarningModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h4 class="modal-title" id="sessionWarningModalLabel">
                                <i class="fas fa-exclamation-triangle"></i> Sesión por Expirar
                            </h4>
                        </div>
                        <div class="modal-body text-center">
                            <p>Tu sesión expirará en <strong><span id="warningTime"></span></strong> segundos por inactividad.</p>
                            <p>¿Deseas continuar con tu sesión?</p>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-success" id="extendSession">
                                <i class="fas fa-check"></i> Continuar Sesión
                            </button>
                            <button type="button" class="btn btn-secondary" id="logoutNow">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        // Eventos de los botones
        document.getElementById('extendSession').addEventListener('click', () => {
            this.extendSession();
        });
        
        document.getElementById('logoutNow').addEventListener('click', () => {
            this.logout();
        });
    }
    
    async extendSession() {
        try {
            const response = await fetch('/refresh-session', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                this.updateActivity();
                if (typeof $.fn.modal !== 'undefined') {
                    $('#sessionWarningModal').modal('hide');
                }
                
                // Mostrar notificación de éxito (si tienes Toastr o similar)
                if (typeof toastr !== 'undefined') {
                    toastr.success('Sesión extendida correctamente');
                }
            } else {
                this.logout(data.redirect);
            }
        } catch (error) {
            console.error('Error extendiendo sesión:', error);
            this.logout();
        }
    }
    
    logout(redirectUrl = '/login') {
        // Limpiar timers
        if (this.checkTimer) {
            clearInterval(this.checkTimer);
        }
        
        // Mostrar mensaje de cierre
        if (typeof toastr !== 'undefined') {
            toastr.warning('Sesión cerrada por inactividad');
        } else {
            alert('Tu sesión ha sido cerrada por inactividad');
        }
        
        // Redirigir después de un breve delay
        setTimeout(() => {
            window.location.href = redirectUrl;
        }, 1000);
    }
    
    destroy() {
        if (this.checkTimer) {
            clearInterval(this.checkTimer);
        }
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Solo inicializar si el usuario está autenticado
    if (document.querySelector('meta[name="csrf-token"]')) {
        window.sessionTimeout = new SessionTimeout();
    }
});

// Limpiar al cambiar de página
window.addEventListener('beforeunload', function() {
    if (window.sessionTimeout) {
        window.sessionTimeout.destroy();
    }
});