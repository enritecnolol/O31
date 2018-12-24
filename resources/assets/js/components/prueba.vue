<template>
    <div class="container" style="margin-top: -40px">
        <div class="card">
            <div class="card-body" style="background: url('../../../../local/fondo6.png')">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-warning btn-sm" @click="editar = true" v-if="editar == false">Editar</button>
                            <button class="btn btn-primary btn-sm" @click="editar = false" v-else>Editar</button>
                        </div>
                        <div class="col-md-2" style="overflow-y: auto;margin:0; padding:0;height: 800px;">
                            <template v-for="item in objetos">
                                <div class="text-center">
                                    <div class="card-mio" @click="nuevocoroto(item.img)" style="">
                                        <h5 class="title-card letra" style="color: #171a1d">{{item.name}}</h5>
                                        <h6 class="card-price letra" style="color: #171a1d"></h6>
                                        <div class="card-img-wrap" style="box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.75);">
                                            <img class="img-card" :src="'../../../../local/'+item.img" alt="">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="col-md-10" style="background: url('../../../../local/fondo7.png');height: 800px">
                            <template v-for="item in corotos">
                                <VueDragResize :parentLimitation="true" :aspectRatio="true" :isActive="editar" :w="item.width" :h="item.height" v-on:resizing="resize" v-on:dragging="resize" :isResizable="editar" :isDraggable="editar">
                                    <!--<img :src="'../../../../local/'+item.img" alt="">-->

                                </VueDragResize>
                            </template>

                            <tabs>
                                <tab name="Nueva Pestana">
                                    sfasfasdf
                                </tab>
                                <template v-for="item in areas">
                                    <tab :name="item.name">
                                        First tab content
                                    </tab>
                                </template>
                            </tabs>
                        </div>
                    </div>
                </div>
                <div class="container" style="margin-top: 40px">

                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {Tabs, Tab} from 'vue-tabs-component';
    import VueDragResize from 'vue-drag-resize'
    import Tabitem from './floorview'
    export default {
        name:'prueba',
        components:{
            VueDragResize,
            Tabitem,
            Tabs,
            Tab
        },
        data() {
            return{
                editar:false,
                objetos:[
                    {
                        name:'mesa',
                        img: 'mesao.png',
                        width: 100,
                        height: 100,
                    },

                ],
                corotos:[
                    {
                        id:1,
                        img: 'mesao.png',
                        width: 100,
                        height: 100,
                        status:true,
                        top: 0,
                        left: 0,
                    },
                ],
                areas:[
                    {
                        id:1,
                        name:'principal'
                    },
                    {
                        id:2,
                        name:'afuera'
                    }
                ]
            }
        },
        methods:{
            resize(newRect) {
                this.width = newRect.width;
                this.height = newRect.height;
                this.top = newRect.top;
                this.left = newRect.left;
            },
            nuevocoroto(img)
            {
                var corot = {
                    img: img,
                    width: 100,
                    height: 100,
                    status:true,
                    top: 0,
                    left: 0,
                }
                this.corotos.push(corot)
            }
        },
        mounted(){

        },
    }
</script>
<style>
    .letra{
        z-index: 4;
    }
    .title-card{
        position: absolute;
        left: 40px;
        top: 40px;
        color: white;
    }
    .card-mio{
        cursor: pointer;
        position:relative;
        opacity: 0.6;
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
        width: 120px;
        height: 120px;
        transition: transform .2s;
    }
    .img-card:hover {
        transform: scale(1.5);
    }
    .card-img-wrap {
        box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.75);
        border-radius: 10px 10px 10px 10px;
        overflow: hidden;
        position: relative;
    }
    .card-img-wrap:after {
        box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.75);
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

</style>