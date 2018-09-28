<!-- modal large -->
<div class="modal fade" id="buscarp" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="largeModalLabel">Buscar producto por codigo </h5>
                <div class="col-md-5">
                    <input type="search" v-model="referencia"  v-on:input.self="buscarreferencia(referencia)" class="form-control" value="" placeholder="Referencia...">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3">
                        <thead style="background: #1b1b1b">
                        <tr>
                            <th>Referencia</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Existencia</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-if="productosreferencia == ''">
                            <tr v-for="p in productos">
                                <td>@{{ p.barcode }}</td>
                                <td>@{{ p.name }}</td>
                                <td>@{{ p.price }}</td>
                                <td>@{{ p.existence }}</td>
                                <td><i class="fas fa-plus"></i></td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr v-for="p in productosreferencia">
                                <td>@{{ p.barcode }}</td>
                                <td>@{{ p.name }}</td>
                                <td>@{{ p.price }}</td>
                                <td>@{{ p.existence }}</td>
                                <td><i class="fas fa-plus"></i></td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end modal large -->