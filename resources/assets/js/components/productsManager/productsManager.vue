<template>
    <card-panel>
        <template slot="body">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12" v-if="productForm">
                        <product-form @productForm="productForm = false" :editData="editData" @refreshData="refreshData"/>
                    </div>
                    <div class="col-md-12" v-else>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-left">
                                    <h3>
                                        <i class="fas"
                                           :class="list ? 'fa-list' : 'fa-th'"
                                           @click="list = !list"
                                           style="cursor: pointer"
                                        /> Lista de productos</h3>
                                </div>
                                <div class="float-right">
                                    <button type="button" class="btn btn-primary" @click="productForm = true">
                                        <i class="fas fa-plus" /> Crear producto
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="searchProduct">Buscar producto:</label>
                                                    <input
                                                            type="text"
                                                            id="searchProduct"
                                                            class="form-control form-control"
                                                            v-model="search"
                                                            @keypress.enter="getProducts"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button
                                                        type="button"
                                                        class="btn btn-primary"
                                                        style="margin-top: 33px;"
                                                        @click="getProducts"
                                                >
                                                    <i class="fas fa-search" /> Buscar
                                                </button>
                                            </div>
                                            <div class="col-md-4">
                                                <filterCategory @categorySelect="categoriesSelect" :reset="reset"/>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="ProductStatus">Estado:</label>
                                                    <select
                                                            id="ProductStatus"
                                                            class="form-control form-control-sm"
                                                            v-model="filter.status"
                                                    >
                                                        <option :value="0">Inactivo</option>
                                                        <option :value="1">Activo</option>
                                                        <option :value="'all'">Todos</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" v-if="list">
                                <div class="row">
                                    <div class="col-md-12">
                                        <general-table
                                                :responsive="false"
                                                :paginate="products"
                                                @pageChange="getProducts"
                                                :hover="true">
                                            <template slot="table-header">
                                                <th>
                                                    <select name="select" id="select" class="form-control form-control-sm " v-model="paginate" style="width: 80px">
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="15">15</option>
                                                    </select>
                                                </th>
                                                <th>Nombre</th>
                                                <th>Codigo</th>
                                                <th>Existencia</th>
                                                <th>Precio</th>
                                                <th>Impuesto</th>
                                                <th>Estado</th>
                                                <th>Editar</th>
                                            </template>
                                            <template slot="table-body">
                                                <tr v-if="loading">
                                                    <td colspan="8" style="text-align: center">
                                                        <h3>Cargando ...</h3>
                                                    </td>
                                                </tr>
                                                <template v-for="p in products.data" v-else>
                                                    <tr>
                                                        <td><img class="rounded-circle mx-auto d-block" :src="'imagenes/'+p.img" alt="" style="width: 60px"></td>
                                                        <td>{{p.name }}</td>
                                                        <td>{{p.barcode}}</td>
                                                        <td>{{p.existence}}</td>
                                                        <td><strong>{{p.price}}.00</strong></td>
                                                        <td>{{p.porciento}}%</td>
                                                        <td :style="{color: p.estado ? 'green' : 'red'}">{{p.estado ? 'Activo':'Inactivo'}}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-warning mb-1" @click="editProduct(p)">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-outline-danger btn-sm" @click="confirmProduct(p.id)" title="Eliminar Producto">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </template>
                                        </general-table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top: 10px" v-else>
                                <cards-view :paginate="products" @productSelected="editProduct" @pageChange="getProducts"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </card-panel>
</template>

<script>
    import cardPanel from '../cardPanel'
    import generalTable from "../generalTable";
    import cardsView from "./cardsView";
    import productForm from "./productForm";
    import filterCategory from "./filterCategory";
    export default {
        components:{
            cardPanel,
            generalTable,
            cardsView,
            productForm,
            filterCategory
        },
        data()
        {
            return{
                products:null,
                paginate:5,
                loading:false,
                list:true,
                editData:null,
                productForm:false,
                search:'',
                filtering:false,
                filter:{
                    category:null,
                    status:'all'
                },
                reset:false
            }
        },
        methods:{
            categoriesSelect(i)
            {
                this.filter.category = i.categories;
            },
            refreshData()
            {
                this.productForm = false;
                this.editData = null;
                this.getProducts();
            },
            editProduct(product)
            {
                this.editData = product;
                this.productForm = true;
            },
            getProducts(page) {
                this.loading = true;
                axios.post('/productos/paginate', {
                    page:page,
                    paginate:this.paginate,
                    search:this.search,
                    filter:this.filter
                })
                    .then( (response) => {
                        this.products = response.data;
                    })
                    .catch( (error) => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.loading = false;
                    })
                ;
            },

            confirmProduct (id){
                var txt;
                var r = confirm("Estas Seguro que quieres INACTIVAR este producto?");
                if (r == true){
                    txt = this.deleteProduct(id);
                }
            },
            deleteProduct(id){
                axios.post('/eliminar/producto',{
                    id:id
                })
                    .then((response) => {
                        toastr.success(response.data.message);
                        this.getProducts();
                    })
                    .catch((error) => {
                        console.log(error.response.data.message)
                    });
            },
        },
        watch:{
            paginate()
            {
                this.getProducts()
            },
            list()
            {
                if(!this.list)
                {
                    this.paginate = 9;
                }else{
                    this.paginate = 10;
                }
            },
            filter:{
                handler()
                {
                    this.getProducts();
                },
                deep:true
            }
        },
        created() {
            this.getProducts();
        }
    }
</script>

<style>

</style>
