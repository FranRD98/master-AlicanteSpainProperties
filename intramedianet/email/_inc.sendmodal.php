<div class="modal fade" id="sendModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php __('Enviar mensaje'); ?></h4>
            </div>
            <div class="modal-body">
               <div class="form-group">
                   <label for="tosend"><?php __('Destinatario'); ?>:</label>
                   <input type="email" name="tosend" id="tosend" class="form-control">
               </div>
               <div class="form-group">
                   <label for="subjectsend"><?php __('Asunto'); ?>:</label>
                   <input type="text" name="subjectsend" id="subjectsend" class="form-control">
               </div>
               <div class="form-group">
                   <label for="mensasend"><?php __('Mensaje'); ?>:</label>
                   <textarea name="mensasend" id="mensasend" cols="30" rows="10" class="form-control wysiwyg"></textarea>
               </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="sendbtnclose"><?php __('Cerrar'); ?></button>
                <button type="button" class="btn btn-primary" id="sendbtn" data-loading-text="<?php __('Procesando'); ?>..."><?php __('Enviar'); ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->