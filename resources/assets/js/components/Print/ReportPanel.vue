<template>
    <div style="background:white;">
        <div id="reportTable" style="background: white;">
            <table width="100%" style="margin-top: 10px">
                <thead>
                <tr>
                    <td>
                        <div class="container-fluid" style="margin-top:10px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <h5 style="">Business Intelligence</h5>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <h6>{{title}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr style="border-top: 1px solid black;">
                    <td>
                        <div class="container-fluid">
                            <template v-if="title == 'Ventas por Productos'">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6 style="float:left;">
                                                    Rango de fecha:
                                                    <b>{{DateFormat(filtros.date[0])}}</b> - <b>{{DateFormat(filtros.date[1])}}</b>
                                                </h6>
                                            </div>
                                            <div class="col-md-12">
                                                <h6 style="float:left;">
                                                    Categoria:
                                                    <b> Todas las categoria </b>
                                                </h6>
                                            </div>
                                            <div class="col-md-12">
                                                <h6 style="float:left;">
                                                    Productos :
                                                    <b>Todos</b>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div id>
                            <table id="tabledata" width="100%" style="margin-top: 5px">
                                <thead id="theaderdata">
                                <tr>
                                    <th v-for="(val, index) in headers" :key="index" :style="hidecolumn(val) ? 'display:none;' : ''">
                                        <b>{{val}}</b>
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="tbodydata">
                                <tr v-for="(item, index) in table_data" :key="index" style>
                                    <td
                                            class="hide"
                                            v-for="(value,key) in item"
                                            :key="key"
                                            :style="hidecolumn(key) ? 'display:none;' : ''"
                                    >
                        <span
                        >{{value}}</span>
                                    </td>
                                </tr>
                                <tr
                                        style="border-top: 1px solid black;color: black;font-weight: bold;text-align: left;">
                                    <td
                                            class="hide"
                                            v-for="(val, index) in totales"
                                            :key="index"
                                            :style="constains(index) ? 'float:right;' : ''"
                                    >
                                        {{val}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td>
                        <div class="container-fluid" style="margin-top:10px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 style="float:right;">Fecha: 2019-01-25</h6>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name:'ReportPanel',
        data(){
            return {
                seleccionado:'',
                title:'Ventas por Productos',
                filterHeaders:['monto_normal'],
                table_data:
                    [],
                headers:[],
                filtros:{},
                totales:[]
            }
        },
        methods:{
            constains(str) {
                console.log(str);
                // if (
                //     this.title == "Ventas por Productos"
                // ) {
                    // if (str.includes(".")) {
                    //     return true;
                    // } else if (
                    //     str == "Total" ||
                    //     str == "Total Neto" ||
                    //     str == "Total Bruto" ||
                    //     str == "ITBIS"
                    // ) {
                    //     return true;
                    // }
                // }
                // return false;
            },
            DateFormat(date){
                return moment(date).format('D MMMM  YYYY');
            },
            hidecolumn(key) {
                var found = this.filterHeaders.find(
                    e => e.toLowerCase() == key.toLowerCase()
                );

                if (found) {
                    return true;
                }
                return false;
            },
            hideColumnsFunc(val) {
                if (val === undefined) {
                    $("td,th").show();
                    setTimeout(() => {
                        this.filterHeaders.forEach(item => {
                            let ind = this.headers.indexOf(item) + 1;
                            $("td:nth-child(" + ind + "),th:nth-child(" + ind + ")").hide();
                        });
                    }, 10);
                }

                let ind = this.headers.indexOf(val) + 1;
                $("td:nth-child(" + ind + "),th:nth-child(" + ind + ")").hide();
            },
        },
        mounted(){
            var url = new URL(window.location.href);
            var date = url.searchParams.get("date");
            var products = url.searchParams.get("products");
            var categories = url.searchParams.get("categories");
            var seleccionado = url.searchParams.get("seleccionado");
            this.totales = JSON.parse(url.searchParams.get("totales"));
            this.seleccionado = seleccionado;
            this.filtros = {
                date:JSON.parse(date),
                products:JSON.parse(products),
                categories:JSON.parse(categories)
            };

            axios.post('/reportv2/return/data' , {
                date: JSON.parse(date),
                seleccionado:seleccionado,
                categories:JSON.parse(categories),
                products:JSON.parse(products)
            })
                .then( (response) => {
                    this.table_data = response.data['data'];
                    this.headers = response.data['header'];
                })
                .catch( (error) => {
                    console.log(error);
                })
                .finally(() => {
                    setTimeout(window.print(), 4000);
                });
        }
    }
</script>

<style>

    .petite {
        font-size: 10px;
    }
    .petitefooter {
        font-size: 8px;
    }
    .button {
        background-color: #4caf50; /* Green */
        border: none;
        color: white;
        padding: 3px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        -webkit-transition-duration: 0.4s; /* Safari */
        transition-duration: 0.4s;
        cursor: pointer;
    }
    .button2 {
        background-color: white;
        color: black;
        border: 2px solid #008cba;
    }

    .button2:hover {
        background-color: #008cba;
        color: white;
    }
    @page {
        @bottom-right {
            content: counter(page) " of " counter(pages);
        }
    }
    #pageFooter:after {
        counter-increment: page;
        content: "Page " counter(page);
        left: 0;
        top: 100%;
        white-space: nowrap;
        z-index: 20px;
        -moz-border-radius: 5px;
        -moz-box-shadow: 0px 0px 4px #222;
        background-image: -moz-linear-gradient(top, #eeeeee, #cccccc);
        background-image: -moz-linear-gradient(top, #eeeeee, #cccccc);
    }
    #content {
        display: table;
    }

    #pageFooter {
        display: table-footer-group;
    }

    #pageFooter:after {
        counter-increment: page;
        content: counter(page);
    }
    @page {
        margin: 10px;
        size: landscape;
    }
    @media print and (width: 8.5in) and (height: 11in) {
        @page {
            margin: 10px;
            size: landscape;
        }
    }
    #reportTable {
        margin: 5px;
    }
    h5 {
        font-weight: bold;
    }
    #theaderdata {
        border-bottom: 1px solid black;
        border-top: 1px solid black;
        font-weight: bold;
        text-align: left;
    }
    tfoot {
        border-top: 1px solid black;
        color: black;
        font-weight: bold;
        text-align: left;
    }
    #tbodydata {
        text-align: left;
    }
    .signature {
        border: 0;
        border-bottom: 1px solid #000;
    }
    table {
        text-align: left;
    }
    .outTable {
        text-align: left;
    }
    footer {
        position: absolute;
        bottom: 60px;
        width: 100%;
        height: 100px;
    }
    body {
        background: white !important;
        min-width: 600px;
    }

</style>