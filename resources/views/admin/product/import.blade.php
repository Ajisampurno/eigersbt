<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Category</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <form action="import/product" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <table class="table table_modal">
                    <tr>
                        <td>Impor file</td>
                        <td>
                            <input type="file" name="file" required="required">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Process</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
      </div>

  </div>
</div>
