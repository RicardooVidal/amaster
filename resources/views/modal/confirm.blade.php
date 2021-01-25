<!-- Modal confirm -->
<div class="modal fade" id="generic-modal-confirm" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
            <h4 class="modal-title" id="confirm">{{$titulo}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            @yield('modal-confirm-body')
        </div>
        <div class="modal-footer">
            @yield('modal-confirm-footer')
        </div>
    </div>
  </div>
</div>