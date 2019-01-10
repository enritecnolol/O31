<template>
    <div class="row" style="margin-top: 10px">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Cedula</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Codigo</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-for="camarero in camarerospaginate">
                        <tr>
                            <th scope="row">{{ camarero.nombre }}</th>
                            <td>{{ camarero.cedula }}</td>
                            <td>{{ camarero.telefono }}</td>
                            <td>{{ camarero.codigo }}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" @click="editar(camarero.id)"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger btn-sm" @click="eliminar(camarero.id)"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>
            <br>
            <nav v-if="pagination.last_page>1" aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li v-if="pagination.current_page==1" class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Anterior</a>
                    </li>
                    <li v-else class="page-item">
                        <a class="page-link" href="#" tabindex="-1" @click="datostablacamarero(pagination.prev_page_url)">Anterior</a>
                    </li>

                    <li v-for="page in pagination.last_page" v-if="pagination.current_page==page" class="page-item active">
                        <a class="page-link" href="#">{{ page }}</a>
                    </li>
                    <li v-else class="page-item">
                        <a class="page-link" href="#" @click="datostablacamarero(pagination.path+'?page='+page)">{{ page }}</a>
                    </li>
                    <li v-if="pagination.current_page==pagination.last_page" class="page-item disabled">
                        <a class="page-link" href="#">Siguiente</a>
                    </li>
                    <li v-else class="page-item">
                        <a class="page-link" href="#" @click="datostablacamarero(pagination.next_page_url)">Siguiente</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>
<script>
    export default {
        name:'tablacamarero',
        props:['camareros', 'camarerospaginate','pagination'],
        components:{},
        data()
        {
            return {
            }
        },
        methods:{
            editar(i){
                this.$emit('editar',i)
            },
            eliminar(i){
                var txt;
                var r = confirm("Estas Seguro que quiere eliminar el camarero ? 😀");
                if (r == true){
                    this.$emit('eliminar',i)
                }
            },
            datostablacamarero(url) {
                this.$emit('datospaginare', url)
            },
        },
        computed:{
        },
        mounted() {
        },
        created() {
        }
    }
</script>
<style>

</style>