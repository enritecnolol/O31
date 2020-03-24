<template>
    <div class="row">
        <div class="col-md-4" v-for="p in paginate.data">
            <div class="card" style="max-width: 400px;cursor: pointer" @click="productSelected(p)">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h6> {{p.barcode}} - {{p.name}}</h6>
                            <hr>
                        </div>

                        <div class="col-md-3">
                            <img class="rounded-circle mx-auto d-block" :src="'imagenes/'+p.img" alt="" style="width: 60px">
                        </div>
                        <div class="col-md-9">
                            <p>
                                Existencia: {{p.existence}} <br>
                                Precio: RD${{parseFloat(p.price).formatMoney(2)}} <br>
                                Itbis: {{p.porciento}}% <br>
                                Estado : <span :style="{color: p.estado ? 'green' : 'red'}">{{p.estado ? 'Activo':'Inactivo'}}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <pagination
                    v-if="paginate"
                    align="right"
                    :data="paginate"
                    :limit="1"
                    :show-disabled="true"
                    @pagination-change-page="changePage"
            />
        </div>
    </div>
</template>

<script>
    window.Vue = require("vue");
    Vue.component("pagination", require("laravel-vue-pagination"));
    export default {
        props: {
            pagination: {
                type: Boolean,
                default: false
            },
            paginate: {
                type: Object
            },
        },
        methods: {
            changePage(page) {
                this.$emit("pageChange", page);
            },
            productSelected(item)
            {
                this.$emit('productSelected', item);
            }
        }
    }
</script>

<style scoped>

</style>