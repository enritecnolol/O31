<div class="modal fade" id="showsubcategorias" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Subcategorias</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th>Editar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-for="sc in subcategoria">
                        <tr>
                            <td><img class="rounded-circle mx-auto d-block" :src="'imagenes/'+sc.img" alt="" style="width: 60px"></td>
                            <td>@{{ sc.nombre }}</td>
                            <td>
                                <button type="button" data-toggle="modal" @click="subcategoriaedit(sc.id)" data-target="#editarsubcategoria" class="btn btn-sm btn-warning mb-1">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" @click="confimar2(sc.id)" title="Eliminar Categoria y Subcategorias">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>