<template>
    <div class="shopping-cart">
        <div class="title">
            Orden - {{orden.name}}
        </div>
        <div style="overflow-y: auto;height: 304px;">
            <template v-for="(item, index) in details">
                <comandaordenitemitem :detail="item" :index="index" :key="index" @cambioestado="cambioestado" v-if="item.compuesto == 'si'"></comandaordenitemitem>
            </template>
        </div>
        <div class="title">
            <div class="text-center">
                <a style="text-decoration: none;color:#4CAF50" href="#" @click="ordenterminada">
                    Orden Terminada
                </a>
            </div>
        </div>
    </div>
</template>
<script>
    import comandaordenitemitem from './comandaordenitemitem'
    export default {
        name:'comandaordenitem',
        components:{comandaordenitemitem},
        props:['orden', 'details', 'index'],
        data(){
            return{
                productos:[],
            }
        },
        methods:{
            allproducts()
            {
                axios.post('/all/productos')
                    .then((response) => {
                        this.productos = response.data;
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
            },
            cambioestado(i)
            {
                this.$emit('cambioestado2',{
                    i,
                    ordendetalleindex:this.index
                });
            },
            ordenterminada()
            {
                var count=0;
                for (var key in this.details)
                {
                    if (this.details[key].compuesto == 'si')
                    {
                        if (this.details[key].estado == null)
                        {
                            toastr.warning('Faltan productos por preparar', 'Validador')
                            break;
                        }
                    }
                    count++
                }
                if (this.details.length == count)
                {
                    this.$emit('ordenterminada',{
                        index:this.index,
                        orden:this.orden
                    })
                }
            }
        },
        computed:{
        },
        created(){
            this.allproducts();
        }
    }
</script>
<style>
    @import url(https://fonts.googleapis.com/css?family=Roboto:300,400,500);

    .shopping-cart {
        width: 470px;
        height: 423px;
        margin: 10px;
        background: #FFFFFF;
        box-shadow: 1px 2px 3px 0px rgba(0,0,0,0.10);
        border-radius: 6px;

        display: flex;
        flex-direction: column;
    }

    .title {
        height: 60px;
        /*border-bottom: 1px solid #E1E8EE;*/
        padding: 20px 30px;
        color: orange;
        background: antiquewhite;
        font-size: 18px;
        font-weight: 400;
    }

    .item {
        padding: 0px 35px;
        height: 51px;
        display: flex;
        border-bottom:  1px solid #BDBDBD;
    }

    .item:nth-child(3) {
        border-top:  1px solid #BDBDBD;
        border-bottom:  1px solid #BDBDBD;
    }

    /* Buttons -  Delete and Like */
    .buttons {
        position: relative;
        padding-top: 16px;
        margin-right: 60px;
    }

    .process-btn {
        display: inline-block;
        cursor: pointer;
        width: 39px;
        height: 30px;
        background: url("../../../../public/cooking.png") no-repeat center;
        margin-right: 14px;
    }

    .like-btn {
        position: absolute;
        top: 9px;
        left: 15px;
        display: inline-block;
        /*background: url('twitter-heart.png');*/
        width: 60px;
        height: 60px;
        background-size: 2900%;
        background-repeat: no-repeat;
        cursor: pointer;
    }

    .is-active {
        animation-name: animate;
        animation-duration: .8s;
        animation-iteration-count: 1;
        animation-timing-function: steps(28);
        animation-fill-mode: forwards;
    }

    @keyframes animate {
        0%   { background-position: left;  }
        50%  { background-position: right; }
        100% { background-position: right; }
    }

    /* Product Image */
    .image {
        margin-right: 50px;
    }

    /* Product Description */
    .description {
        padding-top: 10px;
        margin-right: 60px;
        width: 135px;
    }

    .description span {
        display: block;
        font-size: 14px;
        color: #43484D;
        font-weight: 400;
    }

    .description span:first-child {
        margin-bottom: 5px;
    }
    .description span:last-child {
        font-weight: 300;
        margin-top: 8px;
        color: #86939E;
    }

    /* Product Quantity */
    .quantity {
        padding-top: 20px;
        margin-right: 60px;
    }
    .quantity input {
        -webkit-appearance: none;
        border: none;
        text-align: center;
        width: 32px;
        font-size: 16px;
        color: #43484D;
        font-weight: 300;
    }

    button[class*=btn] {
        width: 30px;
        height: 30px;
        background-color: #E1E8EE;
        border-radius: 6px;
        border: none;
        cursor: pointer;
    }
    .minus-btn img {
        margin-bottom: 3px;
    }
    .plus-btn img {
        margin-top: 2px;
    }
    button:focus,
    input:focus {
        outline:0;
    }

    /* Total Price */
    .total-price {
        width: 83px;
        padding-top: 19px;
        text-align: center;
        font-size: 16px;
        color: #43484D;
        font-weight: 300;
    }

    /* Responsive */
    @media (max-width: 800px) {
        .shopping-cart {
            width: 100%;
            height: auto;
            overflow: hidden;
        }
        .item {
            height: auto;
            flex-wrap: wrap;
            justify-content: center;
        }
        .image img {
            width: 50%;
        }
        .image,
        .quantity,
        .description {
            width: 100%;
            text-align: center;
            margin: 6px 0;
        }
        .buttons {
            margin-right: 20px;
        }
    }
</style>