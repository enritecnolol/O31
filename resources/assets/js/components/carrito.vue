<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row-horizon">
                <template v-for="(item, index) in mesasocupadas">
                    <span class="categorias" style="margin-left: 2px;cursor: pointer" :class="{selectcategories : item.active}">{{item.mesa.name}}</span>
                </template>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 10px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-left">
                            <div class="text-center">
                                <!--<h4>Elegir Cliente</h4>-->
                                <h4>Clientes</h4>
                            </div>
                        </div>
                        <div class="pull-right" style="">
                            <div class="row">
                                <div class="col">
                                    <!--<i class="fas fa-angle-left" style="cursor: pointer;" @click="invitado('menos')"></i>-->
                                </div>
                                <div class="col-">
                                    <!--<div class="text-center"><h5> {{invitadoturno}} - {{invitadott}}</h5></div>-->
                                    <div class="text-center">
                                        <div class="row">
                                            <div class="col"><i class="fas fa-1x fa-users"></i></div>
                                            <div class="col"> <h3 style="float: right">{{invitadott}}</h3></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <!--<i class="fas fa-angle-right" style="cursor: pointer" @click="invitado('mas')"></i>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 15px">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5 table-header">
                                    <h5>Productos</h5>
                                </div>
                                <div class="col-md-2 table-header">
                                    <h5>Precio</h5>
                                </div>
                                <div class="col-md-3 table-header">
                                    <h5>Cantidad</h5>
                                </div>
                                <div class="col-md-2 table-header">
                                    <h5>Total</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="height: 700px;overflow-y:auto;background: url('../../../../local/fondo6.png')" id="listacarrito">
                        <template v-if="productoselecionado.length == 0">
                            <div class="messageVide" style="margin-top: 15px">
                                NO HAY PRODUCTOS
                                <span>(Seleccionar Producto)</span>
                            </div>
                        </template>
                        <template v-for="(item, index) in productoselecionado">
                            <itemcarrito @cambiarcantidad="cambiarcantidad" :index="index" :productoselecionado="item" ></itemcarrito>
                        </template>
                    </div>
                    <div class="col-md-12" style="background: white">
                        <!--<div class="table-responsive col-sm-12 totalTab">-->
                            <!--<table class="table table-sm">-->
                                <!--<tbody>-->
                                <!--<tr>-->
                                    <!--<td class="active" width="40%">-->
                                        <!--SubTotal-->
                                    <!--</td>-->
                                    <!--<td class="whiteBg" width="60%">-->
                                        <!--<span id="Subtot">-->
                                            <!--430.00-->
                                        <!--</span>-->
                                        <!--SAR-->
                                        <!--<span class="float-right">-->
                                            <!--<b id="ItemsNum">-->
                                                <!--<span>43-->
                                                <!--</span> items-->
                                            <!--</b>-->
                                        <!--</span>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td class="active">Impuesto IVA</td>-->
                                    <!--<td class="whiteBg">-->
                                        <!--<input type="text" value="12%" class="total-input" placeholder="N/A" maxlength="8" aria-haspopup="true" role="textbox">-->
                                        <!--<span class="float-right">-->
                                            <!--<b id="taxValue">51.60 SAR</b>-->
                                        <!--</span>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td class="active">Descuento</td>-->
                                    <!--<td class="whiteBg">-->
                                        <!--<input type="text" value="" class="total-input" placeholder="N/A" maxlength="8" aria-haspopup="true" role="textbox">-->
                                        <!--<span class="float-right">-->
                                            <!--<b id="RemiseValue">-->
                                                <!--SAR-->
                                            <!--</b>-->
                                        <!--</span>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td class="active">Total</td>-->
                                    <!--<td class="whiteBg light-blue text-bold">-->
                                        <!--<span id="total">-->
                                            <!--481.60-->
                                        <!--</span>-->
                                        <!--SAR-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--</tbody>-->
                            <!--</table>-->
                        <!--</div>-->
                    </div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <div class="row">
                            <div class="col"><button type="button" class="btn btn-danger btn-lg btn-block "><i class="fas fa-times-circle"></i> Cancelar Compra</button></div>
                            <div class="col"><button type="button" class="btn btn-success btn-lg btn-block"><i class="fas fa-clipboard-list"></i> Ordenar</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import itemcarrito from './itemcarrito'
    export default {
        name:'carrito',
        props:['mesasocupadas', 'mesa', 'productoselecionado', 'bus'],
        components:{itemcarrito},
        data()
        {
            return{
                invitadott:0,
                invitadoturno:1,
            }
        },
        methods:{
            cambiarcantidad(i)
            {
              this.$emit('cambiarcantidad',i)
            },
            invitado(accion)
            {
                for (var key in this.mesasocupadas)
                {
                    if (this.mesasocupadas[key].id == this.mesa)
                    {
                        this.invitadott = this.mesasocupadas[key].personas;
                        if (accion == 'mas')
                        {
                            this.invitadoturno++;
                            if (this.invitadoturno > this.mesasocupadas[key].personas)
                            {
                                this.invitadoturno = this.mesasocupadas[key].personas;
                            }
                        }else if (accion == 'menos') {
                            this.invitadoturno = this.invitadoturno -1;
                            if (this.invitadoturno < 1 )
                            {
                                this.invitadoturno = 1;
                            }
                        }else{
                            this.invitadott = this.mesasocupadas[key].personas;
                        }
                    }
                }
            },
            bajarscroll()
            {
                $("#listacarrito").animate({scrollTop:$('#listacarrito').prop("scrollHeight")},420);
            }

        },
        computed:{
        },
        mounted() {
            this.invitado('nuevo');
            this.bus.$on('bajar', this.bajarscroll)
        }
    }
</script>
<style>
    .table-header h3{
        font-weight: 700;
        font-size: 1.1em;
        margin: 20px 0;
        text-align: center;
        text-transform: uppercase;
    }
    .product-details {
        border: none !important;
        margin-bottom: 3px !important;
        color: #81909a !important;
    }
    .nopadding {
        padding: 0 !important;
        margin: 0 !important;
    }
    .panel{
        margin-bottom:20px;
        background-color:#fff;
        border:1px solid transparent;
        border-radius:4px;
        -webkit-box-shadow:0 1px 1px rgba(0,0,0,.05);
        box-shadow:0 1px 1px rgba(0,0,0,.05);
    }
    .panel-default {
        border-color: #ddd;
    }
    .panel-body {
        padding: 15px;
    }
    .product-details{
        border: none;
        margin-bottom: 3px;
        color: #81909a;
    }

    .product-details input[type="text"]{
        width: 2.1em;
        padding: 3px;
        display: inline;
        text-align: center;
        height: 1.8em;
    }

    .delete-product{
        color: #f65e48;
        margin-top: 1px;
    }

    .textPD{
        margin-top: 5px;
        float: left;
    }

    .subtotal{
        float: right;
    }
    .Hold {
        cursor: pointer;
        text-align: center;
        margin: 5px 1px;
        padding: 2px 13px;
        background-color: #E2E2E2;
        border-radius: 3px;
        color: #6B6B6B;
        text-transform: uppercase;
        font-size: 20px;
        display: inline-block;
        font-weight: 600;
        padding-bottom: 7px;
        border-bottom: 3px solid #6EC89B;
    }
    .total-input {
        border: none;
        outline: none;
    }
    .whiteBg {
        background-color: #fff;
    }
    .text-bold {
        font-weight: 700;
    }

    .light-blue {
        color: #1abc9c;
    }
    .messageVide {
        font-size: 30px;
        width: 100%;
        background-color: white;
        padding: 1.5em 0;
        border-radius: 5px;
        font-weight: lighter;
        display: inline-block;
        text-align: center;
    }

</style>