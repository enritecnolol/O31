<div class="modal fade" id="createsubcategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Crear Subcategoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="nueva/subcategoria" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nombre de la Subcategoria: </label>
                        <input type="text" required autofocus name="nombre" class="form-control" id="exampleFormControlInput1" placeholder="Nombre">
                    </div>

                    <input type="text" hidden v-model="idcategoria" name="idcategoria">

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Imagen</label>
                        <input type="file" name="img" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                    <br>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>