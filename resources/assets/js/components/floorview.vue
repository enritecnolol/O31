<template>
    <div class="container-fluid" style="">
        <div class="" v-if="prueba == false">
            <div class="" style="background: url('../../../../local/fondo6.png')">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 15px">
                            <div class="row row-horizon">
                                <div>
                                    <span class="categorias" style="margin-left: 2px;cursor: pointer" @click="openmodal"><i class="fa fa-plus-circle"></i></span>
                                </div>
                                <template v-for="(item, index) in dataareas">
                                    <div>
                                        <span class="categorias" style="margin-left: 2px;cursor: pointer"  :class="{selectcategories : item.active}" @click="corotosporarea(item.id)">{{item.nombre}}
                                            <template v-if="areaid != 0">
                                                <i class="fa fa-edit" style="position: absolute;top: 7px" v-if="editar == false" @click="editar = true"></i>
                                                <i class="fa fa-save" style="position: absolute;top: 7px" v-else @click="salvar"></i>
                                            </template>
                                        </span>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="col-" style="overflow-y: auto;margin:0; padding:0;height: 800px;">
                            <div class="container">
                               <div class="text-center">
                                   <p style="color:#4272d7;font-size: 26px;font-family: cursive"><u>Objetos</u></p>
                               </div>
                                <template v-for="item in objetos">
                                    <div class="text-center" style="margin-top: 5px">
                                        <div class="card-mio" @click="nuevocoroto(item.img,item.name)">
                                            <div class="card-img-wrap" style="box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.75);">
                                                <img class="img-card" :src="'../../../../local/'+item.img" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="col-md-10" style="background: url('../../../../local/wood.png');height: 800px;border-radius: 10px 10px 10px 10px;">
                            <div class="pull-right" style="margin-top: 5px">
                                <!--<button type="button" class="btn btn-outline-warning btn-sm" v-if="editar == false" @click="editar = true"><i class="fa fa-edit"></i> </button>-->
                                <!--<button type="button" class="btn btn-outline-primary btn-sm" v-else @click="salvar"><i class="fa fa-save"></i> Salvar</button>-->
                            </div>
                            <template v-for="(item, index) in corotos">
                                <template v-if="editar == true">
                                    <vue-draggable-resizable drag-handle=".drag" :x="item.left" :y="item.top"  :minw="10" :minh="10" :w="item.width" :h="item.height" v-on:dragging="onDrag" v-on:resizing="onResize" :parent="true" :resizable="editar" :draggable="editar"  @resizing="datoscoroto(item)" @resizestop="datoscoroto(item)" @dragstop="datoscoroto(item)" @dragging="datoscoroto(item)">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-center" style="border-radius: 10px 10px 10px 10px;cursor: grab;box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);">
                                                    <div class="drag" style="color: white;font-size: 14px"><i style="color: black" class="fa fa-arrows-alt"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <ItemCoroto @eliminarcoroto="eliminarcoroto" :name="item.name" :area="areaid" :numero="item.numero" :editar="editar" :index="index" :key="item.id" :img="item.img" :id="item.id" :status="item.status" :y="item.top" :x="item.left" :w="item.width" :h="item.height"></ItemCoroto>
                                            </div>
                                        </div>
                                    </vue-draggable-resizable>
                                </template>
                                <template v-else>
                                    <template v-if="item.name === 'caja' || item.name == 'pared' || item.name == 'mata' || item.name == 'puerta'">
                                        <vue-draggable-resizable :x="item.left" :y="item.top"  :minh="10" :minw="10" :w="item.width" :h="item.height" v-on:dragging="onDrag" v-on:resizing="onResize" :parent="true" :resizable="editar" :draggable="editar" @resizing="datoscoroto(item)" @resizestop="datoscoroto(item)" @dragstop="datoscoroto(item)" @dragging="datoscoroto(item)">
                                            <div style="">
                                                <ItemCoroto @eliminarcoroto="eliminarcoroto" :name="item.name" :area="areaid" :numero="item.numero" :editar="editar" :index="index" :key="item.id" :img="item.img" :id="item.id" :status="item.status" :y="item.top" :x="item.left" :w="item.width" :h="item.height"></ItemCoroto>
                                            </div>
                                        </vue-draggable-resizable>
                                    </template>

                                    <template v-else>
                                        <vue-draggable-resizable @activated="modalcoroto(index)" style="cursor: pointer" :x="item.left" :y="item.top"  :minh="10" :minw="10" :w="item.width" :h="item.height" v-on:dragging="onDrag" v-on:resizing="onResize" :parent="true" :resizable="editar" :draggable="editar" @resizing="datoscoroto(item)" @resizestop="datoscoroto(item)" @dragstop="datoscoroto(item)" @dragging="datoscoroto(item)">
                                            <div style="">
                                                <ItemCoroto @eliminarcoroto="eliminarcoroto" :name="item.name" :area="areaid" :numero="item.numero" :editar="editar" :index="index" :key="item.id" :img="item.img" :id="item.id" :status="item.status" :y="item.top" :x="item.left" :w="item.width" :h="item.height"></ItemCoroto>
                                            </div>
                                        </vue-draggable-resizable>
                                    </template>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ordenes v-else @prueba="prueba2" :mesasocupada="mesasocupada" :mesa="mesa"></ordenes>

        <modal name="crear" :draggable="true" :height="200">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" style="background: #4272d7">
                        <div class="text-center">
                            <h2 style="color: white">Crear Area</h2>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 15px">
                        <div class="row form-group">
                            <div class="col col-md-4">
                                <label class=" form-control-label">Nombre del area</label>
                            </div>
                            <div class="col-12 col-md-8">
                                <input type="text" v-model="nombrearea" class="form-control" maxlength="15">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 15px">
                        <div class="text-center">
                            <button type="button" @click="savearea" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
        <modal name="coroto" :draggable="true">
            <div class="row" style="background: #fafaed">
                <div class="col-md-12" style="margin-top: 38px;padding-left: 104px;padding-right: 104px;margin-bottom: 10px">
                    <div class="text-center" style="background:whitesmoke;box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);border-radius: 10px 10px 10px 10px;margin-bottom: 10px">
                        <h3 style="">Mesa Disponible</h3>
                        <div class="row">
                            <div class="col-md-12" style="margin-top: 15px">
                                <h4 style="">Cantidad de invitados</h4>
                            </div>
                            <div class="col-md-12" style="margin-top: 15px">
                                <div class="" style="margin-bottom: 40px">
                                    <i style="cursor: pointer;" class="fas fa-2x fa-plus-circle" @click="aumentar('mas')"></i> <h3 style="">{{invitados}}</h3> <i @click="aumentar('menos')" class="fas fa-2x fa-minus-circle" style="cursor: pointer"></i>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 10px">
                                <div class="text-center" style="">
                                    <button type="button" class="btn btn-primary btn-sm" @click="continuar">Continuar <i class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>
<script>
    import {Tabs, Tab} from 'vue-tabs-component';
    import VueDragResize from 'vue-drag-resize'
    import ItemCoroto from './itemcoroto'
    import ordenes from './ordenes'
    import vmodal from 'vue-js-modal';
    import VueDraggableResizable from 'vue-draggable-resizable'
    Vue.use(vmodal);
    Vue.component('vue-draggable-resizable', VueDraggableResizable);

    export default {
        name:'Tabitem',
        components:{Tabs,Tab,VueDragResize,ItemCoroto,ordenes,vmodal,VueDraggableResizable},
        data()
        {
            return{
                mesa:0,
                prueba:false,
                editar:false,
                width:0,
                height:0,
                top:0,
                left:0,
                x: 0,
                y: 0,
                ver:[],
                nombrearea:'',
                areaid:0,
                dataareas:[],
                corotos:[],
                objetos:[
                    {
                        name:'mesa',
                        img: 'mesa2.png',
                        width: 100,
                        height: 100,
                    },
                    {
                        name:'mesa',
                        img: 'mesa4.png',
                        width: 100,
                        height: 100,
                    },
                    {
                        name:'mesa',
                        img: 'mesa6.png',
                        width: 100,
                        height: 100,
                    },
                    {
                        name:'mesa',
                        img: 'mesa8.png',
                        width: 100,
                        height: 100,
                    },
                    {
                        name:'caja',
                        img: 'caja2.png',
                        width: 100,
                        height: 100,
                    },
                    {
                        name:'pared',
                        img: 'pared.png',
                        width: 100,
                        height: 100,
                    },
                    {
                        name:'mata',
                        img: 'mata.png',
                        width: 100,
                        height: 100,
                    },
                    {
                        name:'puerta',
                        img: 'door.png',
                        width: 100,
                        height: 100,
                    },

                ],
                bus:new Vue(),
                invitados:0,
                mesasocupada:[]
            }
        },
        methods:{
            continuar()
            {
              if (this.invitados <= 0)
              {
                  toastr.warning('ingrese la cantidad de invitados', 'validador');
              }else{
                  this.prueba = true;
                  var mesa;
                  for (var key in this.corotos)
                  {
                      if (this.corotos[key].id == this.mesa)
                      {
                          mesa = this.corotos[key];
                          this.corotos[key].status = 2
                      }
                  }
                         var mesa =
                      {
                          id:this.mesa,
                          mesa:mesa,
                          personas:this.invitados,
                          active:true
                      };
                  this.mesasocupada.push(mesa);
                  this.$modal.hide('coroto');
                  this.invitados = 0
              }
            },
            aumentar(accion)
            {
                if (accion == 'mas')
                {
                    this.invitados++;
                    if (this.invitados > 14)
                    {
                        this.invitados = 14;
                    }
                }else{
                    this.invitados = this.invitados - 1;
                    if (this.invitados < 0)
                    {
                        this.invitados = 0;
                    }
                }
            },
            onResize(x, y, width, height)
            {
                this.x = x;
                this.y = y;
                this.width = width;
                this.height = height
            },
            onDrag(x, y)
            {
                this.x = x;
                this.y = y;
            },
            modalcoroto(index)
            {
                this.mesa = this.corotos[index].id;
                if (this.mesasocupada.length >= 1){
                    for (var key in this.mesasocupada){
                        if (this.mesasocupada[key].id === this.corotos[index].id)
                        {
                            this.prueba = true;
                            break
                        }else{
                            this.$modal.show('coroto');
                            break
                        }
                    }
                }else {
                    this.mesa = this.corotos[index].id;
                        this.$modal.show('coroto');
                }
            },
            corotosporarea(id)
            {
                this.areaid = id;
                this.datoscorotos()
            },
            allareas()
            {
                axios.post('/all/area', {
                    nombre:this.nombrearea
                })
                    .then( (response) => {
                        console.log(response);
                        for (var key in response.data)
                        {
                            var data = {
                                id:response.data[key].id,
                                nombre:response.data[key].nombre,
                                user_id:response.data[key].user_id,
                                active:false,
                            };
                            this.dataareas.push(data)
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            savearea()
            {
                axios.post('/save/area', {
                    nombre:this.nombrearea
                })
                    .then( (response) => {
                        console.log(response);
                        toastr.success('Datos Guardados', 'Validador');
                        this.nombrearea = '';
                        this.allareas();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            openmodal()
            {
                this.$modal.show('crear');
            },
            prueba1()
            {
                this.prueba = true
            },
            prueba2()
            {
                this.prueba = false
            },
            organizarmesas()
            {
                var count = 0;
                for (var key in this.corotos)
                {
                    if (this.corotos[key].name == 'mesa')
                    {
                        count++;
                        this.corotos[key].numero = count;
                    }
                }
            },
            editar1()
            {
                this.editar = true
            },
            editar2()
            {
                this.editar = false;
                this.salvar();
            },
            resize(newRect)
            {
                this.width = newRect.width;
                this.height = newRect.height;
                this.top = newRect.top;
                this.left = newRect.left;
            },
            nuevocoroto(img, nombre)
            {
                if (this.areaid == 0)
                {
                    toastr.warning('Por favor Seleccionar un Area o sino Cree un Area', 'Validador')
                }
                else{
                    var count = 1;
                    for (var key in this.corotos)
                    {
                        if (nombre == 'mesa') {
                            count++;
                        }
                    }
                    if (nombre == 'mesa')
                    {
                        var corot = {
                            id:0,
                            name:'M'+count,
                            numero:count,
                            img: img,
                            width: 150,
                            height: 150,
                            status:true,
                            top: 0,
                            left: 0,
                        };
                        this.corotos.push(corot);
                    }else if (nombre == 'pared')
                    {
                        var corot = {
                            id:0,
                            name:nombre,
                            numero:count,
                            img: img,
                            width: 250,
                            height: 100,
                            status:true,
                            top: 0,
                            left: 0,
                        };
                        this.corotos.push(corot);
                    }else{
                        var corot = {
                            id:0,
                            name:nombre,
                            numero:'',
                            img: img,
                            width: 150,
                            height: 150,
                            status:true,
                            top: 0,
                            left: 0,
                        };
                        this.corotos.push(corot);
                    }
                }
            },
            eliminarcoroto(i)
            {
                console.log(i);
                this.corotos.splice(i.index,1);
                axios.post('/delete/coroto', {
                    id: i.id
                })
                    .then( (response) => {
                        console.log(response);
                        this.datoscorotos();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            datoscoroto(i)
            {
                i.top = this.y;
                i.left = this.x;
                i.width = this.width;
                i.height = this.height;
            },
            salvar()
            {
                this.editar = false;
                axios.post('/save/edit/corotos',{
                    corotos: this.corotos,
                    area:this.areaid
                })
                    .then( (response) => {
                        console.log(response);
                        toastr.success('Datos Guardado', 'Validado');
                        this.corotosporarea(this.areaid);
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
            },
            datoscorotos()
            {
                for (var key in this.dataareas)
                {
                    if (this.dataareas[key].active == true){
                        this.dataareas[key].active = false
                    }
                    if (this.dataareas[key].id == this.areaid){
                        this.dataareas[key].active = true;
                    }
                }
                axios.post('/corotos/all',{
                    area:this.areaid
                })
                    .then( (response) => {
                        console.log(response.data);
                        if (response.data == "['No Data']")
                        {
                            toastr.warning('No hemos encontrado datos');
                            this.corotos = [];
                        }else{
                            toastr.success('','Gestor de datos');
                            this.corotos = response.data
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                        toastr.error('Se ha producido un error')
                    });
            }
        },
        mounted() {
            // this.datoscorotos();
            this.allareas();
        }
    }
</script>
<style scoped>
    .letra{
        z-index: 4;
    }
    .title-card{
        position: absolute;
        left: 15px;
        top: 55px;
        color: white;
    }
    .card-mio{
        cursor: pointer;
        position:relative;
        opacity: 1;
        width: 120px;
        height: 120px;
    }
    .card-price{
        position: absolute;
        left: 40px;
        top: 42px;
        color: white;
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
    .tabs-component {
        margin: 4em 0;
    }

    .tabs-component-tabs {
        border: solid 1px #ddd;
        border-radius: 6px;
        margin-bottom: 5px;
    }

    @media (min-width: 700px) {
        .tabs-component-tabs {
            border: 0;
            align-items: stretch;
            display: flex;
            justify-content: flex-start;
            margin-bottom: -1px;
        }
    }

    .tabs-component-tab {
        color: #999;
        font-size: 14px;
        font-weight: 600;
        margin-right: 0;
        list-style: none;
    }

    .tabs-component-tab:not(:last-child) {
        border-bottom: dotted 1px #ddd;
    }

    .tabs-component-tab:hover {
        color: #666;
    }

    .tabs-component-tab.is-active {
        color: #000;
    }

    .tabs-component-tab.is-disabled * {
        color: #cdcdcd;
        cursor: not-allowed !important;
    }

    @media (min-width: 700px) {
        .tabs-component-tab {
            background-color: #fff;
            border: solid 1px #ddd;
            border-radius: 3px 3px 0 0;
            margin-right: .5em;
            transform: translateY(2px);
            transition: transform .3s ease;
        }

        .tabs-component-tab.is-active {
            border-bottom: solid 1px #fff;
            z-index: 2;
            transform: translateY(0);
        }
    }

    .tabs-component-tab-a {
        align-items: center;
        color: inherit;
        display: flex;
        padding: .75em 1em;
        text-decoration: none;
    }

    .tabs-component-panels {
        padding: 4em 0;
    }

    @media (min-width: 700px) {
        .tabs-component-panels {
            border-top-left-radius: 0;
            background-color: #fff;
            border: solid 1px #ddd;
            border-radius: 0 6px 6px 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .05);
            padding: 4em 2em;
        }
    }

    .isTrue{
        color: red;
    }
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
        overflow-x: scroll;
        overflow-y: hidden;
        white-space: nowrap;
        margin: 0 10px;
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
    .selectcategories {
        background-color:#6B6B6B !important;
        color:#E2E2E2 !important;
        border-bottom: 3px solid #f65e48 !important;
    }


</style>