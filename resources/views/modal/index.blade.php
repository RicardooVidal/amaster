<!-- Modal -->
<div class="modal fade" id="generic-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered generic-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $titulo }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div id="modal-message-handler"></div>
                @yield('modal-body')
            </div>
            @yield('modal-footer')
        </div>
    </div>
</div>