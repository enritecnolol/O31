<div class="modal fade" id="crearcategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <h2>Crear Categoria</h2>
                    </div>
                    <div class="card-body">
                        <form action="categorias/nueva" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1" >Nombre Categoria</label>
                                <input id="cc-pament" name="categoria" minlength="0" required type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{ old('categoria') }}">
                            </div>

                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1" >codigo</label>
                                <input id="cc-pament" name="codigo" minlength="0" required type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{ old('codigo') }}">
                                <br>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <p>El codigo ya es existente</p>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Example file input</label>
                                <input type="file" value="{{ old('img') }}" class="form-control-file"  name="img" id="exampleFormControlFile1">
                            </div>
                            <div>
                                <button id="payment-button" type="submit" class="btn btn-info btn-block">
                                    <i class="fa fa-check-square fa-lg"></i>&nbsp;
                                    <span id="payment-button-amount">Guardar</span>
                                    <span id="payment-button-sending" style="display:none;">Enviando…</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>