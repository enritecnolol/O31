<template>
  <card-panel>
    <template slot="body">
      <div class="card-body">
        <div class="loader" v-if="loading" />
        <div v-if="confirmacion == false" class="row">
          <div class="col-md-12" style="margin-bottom: 10px">
            <div class="text-center">
              <h2>Devolución de productos</h2>
            </div>
          </div>
          <div class="col-md-12">
            <hr style="background-color: #0062cc">
          </div>
          <div class="col-md-12" style="margin-bottom: 15px">
            <div class="text-center">
              <div class="form-group">
                <label for="factura"><h4>No.Factura</h4></label>
                <input type="text"
                       style="text-align: center"
                       v-model="no_factura"
                       @keypress.enter="datosfactura(no_factura)"
                       class="form-control form-control-sm" id="factura" placeholder="">
              </div>
              <button class="btn btn-primary" @click="datosfactura(no_factura)">Buscar</button>
            </div>
          </div>
          <div class="col-md-12" v-if="datofactura === 'vacio'">
            <div class="row">
              <div class="col-md-12">
                <general-table :paginate="returns" @pageChange="returnsList" :responsive="false">
                  <template slot="table-header">
                    <tr>
                      <th>Id devolución</th>
                      <th>Fecha</th>
                      <th>Id factura</th>
                      <th>Cliente</th>
                      <th style="text-align: right">Monto</th>
<!--                      <th />-->
                    </tr>
                  </template>
                  <template slot="table-body">
                    <template v-if="!loading">
                      <tr v-for="(item, index) in returns.data" :key="index">
                        <td>{{item.id}}</td>
                        <td>{{item.date}}</td>
                        <th>#{{item.factura_id}}</th>
                        <td>{{clientName(item.client)}}</td>
                        <td style="text-align: right">{{parseFloat(item.total_devolucion).formatMoney(2)}}</td>
<!--                        <td>-->
<!--                            <i style="font-size: 22px;color: firebrick;cursor: pointer;" title="Anular devolucion" class="fas fa-times-circle" @click="cancelReturn" />-->
<!--                        </td>-->
                      </tr>
                    </template>
                  </template>
                </general-table>
              </div>
            </div>
          </div>
          <div class="col-md-12" v-if="datofactura != 'vacio'">
            <div class="row">
              <div class="col-md-4">
                <h5 style="float: left">No.factura</h5>
                <h5 style="float: right">{{ datofactura.id }}</h5>
              </div>
              <div class="col-md-4">
                <h5 style="float: left">Fecha</h5>
                <h5 style="float: right">{{ datofactura.date }}</h5>
              </div>
              <div class="col-md-4">
                <h5 style="float: left">Cliente</h5>
                <h5 style="float: right">{{ nombrecliente(datofactura.client) }} {{ clientenombre }}</h5>
              </div>
              <div class="col-md-4">
                <h5 style="float: left">Bruto</h5>
                <h5 style="float: right">{{ format2(datofactura.brute, 'RD$') }}</h5>
              </div>
              <div class="col-md-4">
                <h5 style="float: left">Descuento</h5>
                <h5 style="float: right">{{ format2(datofactura.desc, 'RD$') }}</h5>
              </div>
              <div class="col-md-4">
                <h5 style="float: left">Itbis</h5>
                <h5 style="float: right">{{ format2(datofactura.itbis, 'RD$') }}</h5>
              </div>
              <div class="col-md-4">
                <h5 style="float: left">devuelta</h5>
                <h5 style="float: right">{{ format2(datofactura.returns, 'RD$') }}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <hr style="background: #0062cc">
          </div>
          <div class="col-md-12" v-if="datofactura != 'vacio'">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                <tr>
                  <th >Producto / Servicio</th>
                  <th >Cantidad</th>
                  <th >Precio</th>
                  <th >Bruto</th>
                  <th >Itbis</th>
                  <th>Devolución</th>
                </tr>
                </thead>
                <tbody>
                <template v-for="(item, index) in datosdetallefactura">
                  <item-body
                      @nuevodetalle="nuevodetalle"
                      :bus="bus"
                      :key="index"
                      :id="item.product_id"
                      :index="index"
                      :nombre="item.name_product"
                      :servicio="item.description"
                      :cantidad="item.quanlity"
                      :precio="item.price"
                      :bruto="item.impost"
                      :itbis="item.depot"
                  />
                </template>
                </tbody>
              </table>
            </div>
            <div class="text-center" style="margin-top: 10px">
              <button type="button" @click="confimar" class="btn btn-primary btn-lg"><i class="fas fa-undo"></i> Efectuar Devolución</button>
            </div>
          </div>
        </div>
        <div v-if="confirmacion == true" class="row">
          <div class="col-md-12" style="margin-bottom: 10px">
            <div class="text-center">
              <h2>Devolución de productos</h2>
            </div>
          </div>
          <div class="col-md-12">
            <hr style="background-color: #0062cc">
          </div>
          <div class="col-md-12" style="margin-top: 10px;margin-bottom: 10px">
            <div class="text-right">
              <button type="button" @click="atras" class="btn btn-primary"><i class="fas fa-angle-left"></i> Volver</button>
            </div>
          </div>
          <div class="col-md-12">
            <div class="container-fluid"  style="width: 600px;box-shadow: 0px 0px 9px 0px rgba(0,0,0,0.75);">
              <invoice
                  :compania="compania"
                  :datosnuevodetalle="datosnuevodetalle"
                  :datofactura="datofactura"
                  :numerodevolucion="numerodevolucion"
                  :fecha="fecha"
                  :totaldevolver="totaldevolver"
                  :nfc="nfc"
              />
            </div>
          </div>
          <div class="col-md-12">
            <div class="float-right">
              <button type="button" id="printD" @click="testPrintButton" class="btn btn-primary"><i class="fas fa-print" id="imprimir"></i> Imprimir</button>
            </div>
          </div>
        </div>
      </div>
    </template>
  </card-panel>
</template>

<script>
  import Invoice from "./Invoice";
  import cardInvoice from "./cardInvoice";
  import itemBody from "./itemBody";
  import cardPanel from "../cardPanel";
  import generalTable from "../generalTable";
  export default {
    components:{
      Invoice,
      cardInvoice,
      itemBody,
      cardPanel,
      generalTable
    },
    data(){
      return {
        no_factura:'',
        datofactura:'vacio',
        datosdetallefactura: 'vacio',
        datosnuevodetalle:[],
        bus: new Vue(),
        confirmacion:false,
        clientenombre:'',
        compania:'',
        totaldevolver:0,
        numerodevolucion:0,
        fecha:'',
        devolucionesanteriores:'',
        nfc:'',
        invoicesList:[],
        loading:false,
        returns:null,
        clientsData:[]
      }
    },watch: {
    },
    mounted(){
    },
    created()
    {
      // this.listInvoices()
      this.returnsList();
      this.checkInvoice();
    },
    methods:{
      // cancelReturn()
      // {
      //   var r = confirm("Esta seguro de Anular la devolucion ?");
      //   if (r == true){
      //     txt = this.botondevolver();
      //   }
      // },
      checkInvoice()
      {
        if(this.getUrlVars(window.location.href)['invoice'])
        {
          this.no_factura =  this.getUrlVars(window.location.href)['invoice'];
          this.datosfactura(this.no_factura);
        }
      },
      ClientsDate() {
        axios
            .post("/clientes/datos/tabla2")
            .then(response => {
              this.clientsData = response["data"];
            })
            .catch(error => {
              console.log(error);
            })
            .finally(() => {
              this.loading = false;
            });
      },
      getUrlVars()
      {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
          hash = hashes[i].split('=');
          vars.push(hash[0]);
          vars[hash[0]] = hash[1];
        }
        return vars;
      },
      clientName(client)
      {
        let found;
        for (const index in this.clientsData) {
          if(this.clientsData[index].id == client)
          {
            found = this.clientsData[index];
            break;
          }
        }
        return found ? found.nombre :"General"
      },
      formatMoment(datetime)
      {
        return moment(datetime).format('DD-MMM-YYYY hh:mm A')
      },
      listInvoices()
      {
        axios.get('/invoices/last')
            .then((resp)=> {
              this.invoicesList = resp.data
            })
            .catch( ( err )=> console.log(err))
      },
      format2(n, currency) {
        return currency + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
      },
      testPrintButton()
      {

        $("#printD").click( () => {
          var mode = 'iframe'; //popup
          var close = mode == "popup";
          var options = { mode : mode, popClose : close};
          $("div#myPrintArea").printArea(options);
        });

      },
      decimal(i) {
        return parseFloat(i).toFixed(2)
      },
      datosfactura (id) {
        if(id)
        {
          this.no_factura = id
        }
        this.loading = true;
        axios.post('/devolucion/buscar/factura', {
          id:this.no_factura
        })
            .then((response) => {
              if  (response['data']['factura'] == 'vacio' && response['data']['detalle'] == 'vacio'){
                toastr.warning('No existe factura con este numero');
              }
              this.datofactura = response['data']['factura'];
              if (response['data']['detalle_devolucion'] != "vacia")
              {
                this.datosdetallefactura = response['data']['detalle_devolucion']
              }else {
                this.datosdetallefactura= response['data']['detalle'];
              }
            })
            .catch((error) => {
              toastr.warning('Se ha producido un Error');
            })
            .finally(()=> {
              this.loading = false;
            });
      },
      nuevodetalle (i) {
        for(var key in this.datosdetallefactura)
        {

          if (key == i.index)
          {
            var detalle = {
              name_product: this.datosdetallefactura[key].name_product,
              description: this.datosdetallefactura[key].description,
              cantidad: parseFloat(i.datos.cantidaddevolcer),
              price: this.datosdetallefactura[key].quanlity ==  parseFloat(i.datos.cantidaddevolcer) ? parseFloat(this.datosdetallefactura[key].price) : parseFloat(this.datosdetallefactura[key].price) / parseFloat(this.datosdetallefactura[key].quanlity) * parseFloat(i.datos.cantidaddevolcer) ,
              itbis: this.datosdetallefactura[key].quanlity ==  parseFloat(i.datos.cantidaddevolcer) ? parseFloat(this.datosdetallefactura[key].depot) : parseFloat(this.datosdetallefactura[key].depot) / parseFloat(this.datosdetallefactura[key].quanlity) * parseFloat(i.datos.cantidaddevolcer),
              bruto: this.datosdetallefactura[key].quanlity ==  parseFloat(i.datos.cantidaddevolcer) ? parseFloat(this.datosdetallefactura[key].impost): parseFloat(this.datosdetallefactura[key].impost) / parseFloat(this.datosdetallefactura[key].quanlity) * parseFloat(i.datos.cantidaddevolcer),
              product_id: this.datosdetallefactura[key].product_id,
            };
            this.datosnuevodetalle.push(detalle);
            return
          }
        }

      },
      realizardevolucion () {
        if(this.datosnuevodetalle.length == 0)
        {
          toastr.warning("Revise los producto a devolver", "Validador")
          return;
        }

        axios.post('/devolucion/store', {
          factura: this.datofactura,
          detalle_devolucion: this.datosnuevodetalle,

        })
            .then((response) => {
              if(response['data'] === "No es posible hacer la factura por falta de Comprobantes")
              {
                toastr.warning('No es posible hacer la devolucion por falta de Comprobantes');
                return;
              }
              this.confirmacion = true;
              toastr.success('La Devolucion se ha realizado Correctamente');
              this.compania = response['data'][0][0];
              this.totaldevolver = response['data'][1];
              this.fecha = response['data'][2];
              this.numerodevolucion = response['data'][3];
              this.nfc = response['data'][4];
              if(response['data'][5] != "")
              {
                toastr.warning(response['data'][5]);
              }
            })
            .catch((error) => {
              console.log(error);
            });
      },
      confimar (){
        var txt;
        var r = confirm("Esta seguro que quiere hacer esta devolucion ?");
        if (r == true){
          txt = this.botondevolver();
        }
      },
      botondevolver () {
        ;
        this.bus.$emit('ejecutar');
        this.realizardevolucion();

      },
      nombrecliente (i) {
        var nombre;
        if (i == null)
        {
          this.clientenombre = ''
        }else{
          axios.post('/cliente/buscar/nombre', {
            id:i
          })
              .then( (response) =>{
                if (response['data'] == null)
                {
                  this.clientenombre = ''
                }else
                {
                  for (var key in response['data'])
                  {
                    if (i == response['data'][key].id){
                      this.clientenombre = response['data'][key].nombre
                    }
                  }
                }
              })
              .catch((error) => {
                console.log(error);
              });
        }
      },
      atras () {
        this.no_factura = '';
        this.datofactura ='vacio';
        this.datosdetallefactura = 'vacio';
        this.datosnuevodetalle = [];
        this.confirmacion = false;
        this.clientenombre ='';
        this.compania ='';
        this.totaldevolver = 0;
        this.numerodevolucion = 0;
        this.fecha = '';
        this.devolucionesanteriores = '';
        this.returnsList();
      },
      returnsList(page)
      {
        this.loading = true;
        axios.get('/devolucion/list',{
          params: {
            page: page
          }
        })
            .then((response) => {
              this.returns = response.data;
              this.ClientsDate();
            })
            .catch((error) => {
              console.log(error)
            })
            .finally(()=> {
            })
      }
    },
    computed:{

    },
  }
</script>

<style scoped>

</style>
