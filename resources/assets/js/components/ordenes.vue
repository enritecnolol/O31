<template>
    <div class="" style="background: url('../../../../local/fondo6.png')">
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left" style="position: absolute;z-index: 9999;left: 689px;top: 21px;">
                        <i class="fa fa-arrow-left fa-2x" @click="volverpantalla" style="cursor: pointer"></i>
                    </div>
                </div>
                <div class="col-md-5" style="height: 900px;background: #ecf0f1">
                    <carrito @volverpant="volverpantalla" @cambiarcantidad="cambiarcantidad" @productopormesa="productopormesa" :mesasocupadas="mesasocupada" :mesa="mesa" :productoselecionado="productoselecionado" :bus="bus" :detalle="detalle" ></carrito>
                </div>
                <div class="col-md-7" style="height: 900px;background: #ecf0f1">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row-horizon">
                                <span class="categorias" :class="{selectcategories : default1}"  @click="productocategoria(0)"><i class="fas fa-home"></i></span>
                                <template v-for="(item, index) in categorias">
                                    <span class="categorias" style="margin-left: 2px;cursor: pointer" :class="{selectcategories : item.active}" @click="productocategoria(item.id)">{{item.nombre}}</span>
                                </template>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 5px">
                            <input type="text" id="" placeholder="Buscador" v-model="buscador" @input.self="buscadorp" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-12" v-dragscroll style="height: 800px;overflow: auto;cursor: grab; cursor : -o-grab; cursor : -moz-grab; cursor : -webkit-grab;">
                            <div class="row" style="margin-top: 10px">
                                <template v-for="(item, index) in productos">
                                    <cardproduct @productoagregar="productoselect" @bajarscroll="bajarscroll" :index="index" :key="index" :producto="item" :mesa="mesa" :detalle="detalle"></cardproduct>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script !src="">
    import cardproduct from './cardproduct'
    import carrito from './carrito'
    import VueDragscroll from 'vue-dragscroll'
    Vue.use(VueDragscroll)
    export default {
        name:'ordenes',
        components:{cardproduct,carrito,VueDragscroll},
        props:['mesasocupada', 'mesa', 'bus'],
        data()
        {
            return{
                default1:false,
                mesav1:this.mesa,
                categorias:[],
                productos:[],
                buscador:'',
                categoriaselect:{
                    'background-color':'#6B6B6B !important',
                    'color':'#E2E2E2 !important',
                    'border-bottom': '3px solid #f65e48 !important'
                },
                productoselecionado:[],
                // bus: new Vue(),
                detalle:[],
                product:'',
                data:''
            }
        },
        methods:{
            productopormesa(i)
            {
                this.$emit('mesaocupadaactive',i);
                this.productoselecionado = [];
                axios.post('/buscar/orden/x/mesa', {
                    id:i.id
                })
                    .then((response) => {
                        this.mesav1 = i.id;
                        this.detalle = response['data'];
                        for (var key in this.detalle['detalle'])
                        {
                            for (var o in this.productos)
                            {
                                if (this.productos[o].id==this.detalle['detalle'][key]['product_id'])
                                {
                                    var esto = {
                                        id:this.detalle['detalle'][key]['id'],
                                        orden:this.detalle['orden'][0],
                                        index:0,
                                        cantidad:this.detalle['detalle'][key]['cantidad'],
                                        mesa:this.mesav1,
                                        total: parseFloat(parseFloat(this.detalle['detalle'][key]['cantidad']) * parseFloat(this.productos[o].price)).toFixed(2),
                                        producto: this.productos[o]
                                    };
                                    this.productoselecionado.push(esto);
                                    break
                                }
                            }
                        }
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
            },
            cambiarcantidad(i)
            {
                if (i.obt.cantidad === 0)
                {
                    if (this.productoselecionado[i.obt.index]['id'] != 0)
                    {
                        axios.post('/producto/orden/eliminar', {
                            producto:this.productoselecionado[i.obt.index],
                            orden:this.productoselecionado[i.obt.index]['orden']['id'],
                            subtotal:i.subtotal
                        })
                            .then(function (response) {
                                console.log(response);
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                    this.productoselecionado.splice(i.obt.index,1)

                }else{
                    this.productoselecionado[i.obt.index].total = parseFloat(this.productoselecionado[i.obt.index].producto.price * i.obt.cantidad).toFixed(2);
                    this.productoselecionado[i.obt.index].cantidad = i.obt.cantidad;
                    var total = 0;
                    for (var key in this.productoselecionado)
                    {
                        total = parseFloat(this.productoselecionado[key].total) + parseFloat(total)
                    }
                    if (this.productoselecionado[i.obt.index]['id'] != 0)
                    {
                        axios.post('/producto/orden/cambiar/cantidad', {
                            producto:this.productoselecionado[i.obt.index],
                            orden:this.productoselecionado[i.obt.index]['orden']['id'],
                            subtotal:total
                        })
                            .then(function (response) {
                                console.log(response);
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                }
            },
            productoselect(i)
            {
                function buscar(prod) {
                    return prod.producto.id == i.producto.id
                }
                if (this.productoselecionado.length === 0)
                {
                    this.productoselecionado.push(i);
                }else{
                    if (this.productoselecionado.find(buscar))
                    {
                        var cont = parseInt(this.productoselecionado.find(buscar).cantidad) + 1;
                        var precio = cont *  i.producto.price;
                        this.productoselecionado.map(function (data) {
                            if (data.producto.id === i.producto.id)
                            {
                                data.cantidad = cont;
                                data.total = parseFloat(precio).toFixed(2);
                            }
                            return data
                        });
                    }else{
                        this.productoselecionado.push(i);
                    }
                }
            },
            allcategorias()
            {
                axios.post('/all/categories')
                    .then( (response) => {
                        for (var key in response.data)
                        {
                            var datos = {
                                id: response.data[key].id,
                                nombre:response.data[key].nombre,
                                codigo:response.data[key].codigo,
                                img:response.data[key].img,
                                user_id:response.data[key].user_id,
                                activo:false
                            };
                            this.categorias.push(datos)
                        }
                        this.default1 = true;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            allproduct()
            {
                axios.post('/all/productos')
                    .then((response) => {
                        this.productos = response.data;
                        console.log(response);
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
            },
            volverpantalla()
            {
                this.$emit('prueba',{
                    prueba:false
                })
            },
            productocategoria(id)
            {
                for (var key in this.categorias)
                {
                    if (this.categorias[key].id != id)
                    {
                        this.categorias[key].active = false;
                        this.default1 = false;
                    }
                    if (this.categorias[key].id == id)
                    {
                        this.categorias[key].active = true;
                        this.default1 = false;
                    }
                }
                if (id == 0)
                {
                    this.default1 = true
                }
                axios.post('/productos/categoria/ordenes',{
                    id:id
                })
                    .then((response) => {
                        this.productos = response.data;
                        console.log(response);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            buscadorp() {
                axios.post('/buscar/producto/ordenes',{
                    producto: this.buscador
                })
                    .then((response) => {
                        this.productos = response.data;
                        console.log(response);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            bajarscroll(){
                this.bus.$emit('bajar')
            },
            buscarordenmesa(i){
                console.log('2')
                this.bus.$emit('ejecutarmesa2');
            },
        },
        computed:{

        },
        mounted() {
            this.allcategorias();
            this.allproduct();
            // this.$eventbus.$on('algo', this.buscarordenmesa());
            this.bus.$on('algo', this.buscarordenmesa());
        },
        created() {
        }
    }
</script>
<style>
    .selectcategories {
        background-color:#6B6B6B !important;
        color:#E2E2E2 !important;
        border-bottom: 3px solid #f65e48 !important;
    }
    .categorias{
        cursor: pointer;
        text-align:center;
        margin:5px 0;
        padding: 10px 20px;
        background-color:#E2E2E2;
        border-radius:3px;
        color:#6B6B6B;
        text-transform:uppercase;
        display:inline-block;
        font-weight:500;
        padding-bottom: 7px;
        border-bottom: 3px solid #6EC89B;
    }
    .letra{
        z-index: 4;
    }
    .title-card{
        position: absolute;
        left: 4px;
        top: 0px;
        color: #212121;
    }
    .card-mio{
        cursor: pointer;
        position:relative;
        opacity: 1;
        width: 103px;
        height: 122px;
    }
    .card-price{
        position: absolute;
        left: 30px;
        top: 84px;
        color: #212121;
        transition: transform .2s;
    }
    .img-card{
        border-radius: 10px 10px 10px 10px;
        width: 100px;
        height: 100px;
        transition: transform .2s;
    }
    .img-card:hover {
        transform: scale(1.5);
    }
    .card-img-wrap {
        border-radius: 10px 10px 10px 10px;
        overflow: hidden;
        position: relative;
        opacity: 0.5;
    }
    .card-img-wrap:after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255,255,255,0.3);
        opacity: 0;
        transition: opacity .25s;
    }
    .card-img-wrap img {
        transition: transform .25s;
        width: 100%;
    }
    .card-img-wrap:hover img {
        transform: scale(1.2);
    }
    .card-img-wrap:hover:after {
        opacity: 1;
    }
    /*================================================================*/
    .row-horizon::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius: 10px;
        background-color: #F5F5F5;
    }
    .row-horizon::-webkit-scrollbar
    {
        height: 8px;
        background-color: #F5F5F5;
    }
    .row-horizon::-webkit-scrollbar-thumb
    {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #777979;
    }
    .row-horizon {
        overflow-x: scroll !important;
        overflow-y: hidden !important;
        white-space: nowrap !important;
        margin: 0 10px !important;
    }
    .row-horizon > [class*="col-lg"], .row-horizon > [class*="col-md"], .row-horizon > [class*="col-sm"], .row-horizon > [class*="col-xs"] {
        float: none;
        display: inline-block;
        white-space: normal;
        vertical-align: top;
    }
    .row-horizon > .col-xs-12 {
        width: 90%;
    }
    .row-horizon > .col-xs-11 {
        width: 82.5%;
    }
    .row-horizon > .col-xs-10 {
        width: 75%;
    }
    .row-horizon > .col-xs-9 {
        width: 67.5%;
    }
    .row-horizon > .col-xs-8 {
        width: 60%;
    }
    .row-horizon > .col-xs-7 {
        width: 52.5%;
    }
    .row-horizon > .col-xs-6 {
        width: 45%;
    }
    .row-horizon > .col-xs-5 {
        width: 37.5%;
    }
    .row-horizon > .col-xs-4 {
        width: 30%;
    }
    .row-horizon > .col-xs-3 {
        width: 22.5%;
    }
    .row-horizon > .col-xs-2 {
        width: 15%;
    }
    .row-horizon > .col-xs-1 {
        width: 7.5%;
    }
    @media (min-width: 768px) {
        .row-horizon > .col-sm-12 {
            width: 90%;
        }
        .row-horizon > .col-sm-11 {
            width: 82.5%;
        }
        .row-horizon > .col-sm-10 {
            width: 75%;
        }
        .row-horizon > .col-sm-9 {
            width: 67.5%;
        }
        .row-horizon > .col-sm-8 {
            width: 60%;
        }
        .row-horizon > .col-sm-7 {
            width: 52.5%;
        }
        .row-horizon > .col-sm-6 {
            width: 45%;
        }
        .row-horizon > .col-sm-5 {
            width: 37.5%;
        }
        .row-horizon > .col-sm-4 {
            width: 30%;
        }
        .row-horizon > .col-sm-3 {
            width: 22.5%;
        }
        .row-horizon > .col-sm-2 {
            width: 15%;
        }
        .row-horizon > .col-sm-1 {
            width: 7.5%;
        }
    }
    @media (min-width: 992px) {
        .row-horizon > .col-md-12 {
            width: 90%;
        }
        .row-horizon > .col-md-11 {
            width: 82.5%;
        }
        .row-horizon > .col-md-10 {
            width: 75%;
        }
        .row-horizon > .col-md-9 {
            width: 67.5%;
        }
        .row-horizon > .col-md-8 {
            width: 60%;
        }
        .row-horizon > .col-md-7 {
            width: 52.5%;
        }
        .row-horizon > .col-md-6 {
            width: 45%;
        }
        .row-horizon > .col-md-5 {
            width: 37.5%;
        }
        .row-horizon > .col-md-4 {
            width: 30%;
        }
        .row-horizon > .col-md-3 {
            width: 22.5%;
        }
        .row-horizon > .col-md-2 {
            width: 15%;
        }
        .row-horizon > .col-md-1 {
            width: 7.5%;
        }
    }
    @media (min-width: 1200px) {
        .row-horizon > .col-lg-12 {
            width: 90%;
        }
        .row-horizon > .col-lg-11 {
            width: 82.5%;
        }
        .row-horizon > .col-lg-10 {
            width: 75%;
        }
        .row-horizon > .col-lg-9 {
            width: 67.5%;
        }
        .row-horizon > .col-lg-8 {
            width: 60%;
        }
        .row-horizon > .col-lg-7 {
            width: 52.5%;
        }
        .row-horizon > .col-lg-6 {
            width: 45%;
        }
        .row-horizon > .col-lg-5 {
            width: 37.5%;
        }
        .row-horizon > .col-lg-4 {
            width: 30%;
        }
        .row-horizon > .col-lg-3 {
            width: 22.5%;
        }
        .row-horizon > .col-lg-2 {
            width: 15%;
        }
        .row-horizon > .col-lg-1 {
            width: 7.5%;
        }
    }

</style>