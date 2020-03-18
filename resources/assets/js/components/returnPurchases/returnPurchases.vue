<template>
  <card-panel>
    <template slot="body">
      <div class="card-body">
        <div class="loader" v-if="loading"></div>
        <div class="row">
          <div class="col-md-12 text-center">
            <h2>Devolución de compra</h2>
            <hr style="background-color: #0062cc">
          </div>
          <div class="col-md-12" style="margin-bottom: 15px">
            <div class="text-center">
              <div class="form-group">
                <label for="compra"><h4>No.Compra</h4></label>
                <input type="text"
                       style="text-align: center"
                       v-model="id_Purchase"
                       @keypress.enter="dataPurchase(id_Purchase)"
                       class="form-control form-control-sm" id="compra" placeholder="">
              </div>
              <button class="btn btn-primary" @click="dataPurchase(id_Purchase)">Buscar</button>
            </div>
          </div>
          <div class="col-md-12" v-if="!purchaseData">
            <general-table :paginate="returnPurchaseList" :hover="true" :responsive="false">
              <template slot="table-header">
                <tr>
                  <th>Fecha emitida</th>
                  <th style="text-align: right">Total devolucion</th>
                  <th style="text-align: center">Compra</th>
                  <th>No. Documento</th>
                  <th>Fecha de compra</th>
                  <th>Tipo Compra</th>
                </tr>
              </template>
              <template slot="table-body">
                <tr v-if="loading">
                  <td colspan="6" style="text-align: center">
                    <h3>Cargando ...</h3>
                  </td>
                </tr>
                <tr v-for="(item, index) in returnPurchaseList.data" v-else :key="index" v-show="returnPurchaseList">
                  <td>{{item.date}}</td>
                  <td style="text-align: right">RD${{parseFloat(item.total_return).formatMoney(2)}}</td>
                  <th style="text-align: center">#{{item.purchase_id}}</th>
                  <td>{{item.document_no}}</td>
                  <td>{{item.invoice_date}}</td>
                  <td>{{item.kind_purchase}}</td>
                </tr>
              </template>
            </general-table>
          </div>
          <div class="col-md-12" v-if="purchaseData">
            <div class="row">
              <div class="col-md-4">
                <h5 style="float: left">no. Documento: </h5>
                <h5 style="float: right">{{ purchaseData.document_no }}</h5>
              </div>
              <div class="col-md-4">
                <h5 style="float: left">Fecha: </h5>
                <h5 style="float: right">{{ purchaseData.created_at }}</h5>
              </div>
              <div class="col-md-4">
                <h5 style="float: left">Proveedor:</h5>
                <h5 style="float: right">{{ supplierName(purchaseData.supplier_id) }} </h5>
              </div>
              <div class="col-md-4">
                <h5 style="float: left">Subtotal:</h5>
                <h5 style="float: right">RD${{ parseFloat(purchaseData.subtotal).formatMoney(2) }}</h5>
              </div>
              <div class="col-md-4">
                <h5 style="float: left">Itbis:</h5>
                <h5 style="float: right">RD${{ parseFloat(purchaseData.itbis).formatMoney(2) }}</h5>
              </div>
              <div class="col-md-4">
                <h5 style="float: left">Total:</h5>
                <h5 style="float: right">RD${{ parseFloat(purchaseData.total).formatMoney(2) }}</h5>
              </div>
              <div class="col-md-12">
                <hr style="background: #0062cc">
              </div>
              <div class="col-md-12">
                <general-table :hover="true" :bordered="true">
                  <template slot="table-header">
                    <tr>
                      <th>Producto</th>
                      <th style="text-align: center">Cantidad</th>
                      <th style="text-align: right">Precio</th>
                      <th style="text-align: right">Itbis</th>
                      <th style="text-align: right">Total</th>
                      <th>Devolución</th>
                    </tr>
                  </template>
                  <template slot="table-body">
                    <item-body v-for="(item,index) in purchaseData.details"
                               :key="index"
                               :item="item"
                               :bus="bus"
                               :index="index"
                               @return_purchase_detail="return_purchase_detail"
                    />
                  </template>
                </general-table>
                <div class="text-center" style="margin-top: 10px">
                  <button type="button" class="btn btn-primary btn-lg" @click="confirmReturn"><i class="fas fa-undo"></i> Efectuar Devolución</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </card-panel>
</template>

<script>
  import cardPanel from "../cardPanel";
  import generalTable from "../generalTable";
  import itemBody from "./itemBody";
  export default {
    components:{
      cardPanel,
      generalTable,
      itemBody
    },
    data()
    {
      return {
        id_Purchase:'',
        purchaseData:null,
        suppliers:[],
        newDetails:[],
        bus: new Vue(),
        loading:false,
        returnPurchaseList:null
      }
    },
    methods:{
      return_purchase_detail(i)
      {
        for (var index in this.purchaseData.details)
        {
          console.log(i.index + ' ===== ' + index)
          if(i.index == index)
          {
            this.newDetails.push({
              name:this.purchaseData.details[index].name,
              quantity:i.data.returnsQuantity,
              price:this.purchaseData.details[index].price,
              itbis:0,
              bruto:0,
              total:i.data.total,
              product_id: this.purchaseData.details[index].product_id
            });
            return
          }
        }
      },
      confirmReturn (){
        var r = confirm("Esta seguro que quiere hacer esta devolucion ?");
        if (r == true){
          this.bus.$emit('ejecutar');
          this.returnPurchase();
        }
      },
      returnPurchase()
      {
        if(this.newDetails.length == 0)
        {
          toastr.warning("Revise los articulos a devolver", "Validador");
          return;
        }
        this.loading = true;
        axios.post('/purchase/return', {
          purchase_data: this.purchaseData,
          new_details:this.newDetails
        })
                .then((response) => {
                  toastr.success(response.data.message);
                  this.purchaseData = null;
                  this.newDetails = [];
                  this.getReturnPurchases()
                })
                .catch((error) => {
                  console.log(error)
                })
                .finally(() => {
                  this.loading = false;
                })
      },
      supplierName(id)
      {
        let found = this.suppliers.find(e => e.id == id);
        if(found)
        {
          return found.name;
        }
        return "No found"
      },
      getSupplierData()
      {
        this.loading = true;
        axios
                .get("/supplier/list/select")
                .then(response => {
                  this.suppliers = response.data;
                })
                .catch(err => {
                  console.log(err);
                })
                .finally(() => {
                  this.loading = false;
                });
      },
      dataPurchase(id_Purchase)
      {
        axios.get('/purchase/data/return', {
          params:{
            id:id_Purchase
          }
        })
                .then((response) => {
                  this.purchaseData = response.data;
                })
                .catch((error) => {
                  console.log(error)
                })
      },
      getReturnPurchases(page)
      {
        this.loading = true;
        axios.get('/purchase/return/list', {
          params:{page:page}
        })
                .then((response) => {
                  this.returnPurchaseList = response.data
                  console.log(response)
                })
                .catch((err) => {
                  console.log(err)
                })
                .finally(() => {
                  this.loading = false
                })
      },
      getUrlVars() {
        var vars = [],
                hash;
        var hashes = window.location.href
                .slice(window.location.href.indexOf("?") + 1)
                .split("&");
        for (var i = 0; i < hashes.length; i++) {
          hash = hashes[i].split("=");
          vars.push(hash[0]);
          vars[hash[0]] = hash[1];
        }
        return vars;
      }
    },
    created() {
      this.getSupplierData();
      this.getReturnPurchases();
      if(this.getUrlVars(window.location.href)["purchase"])
      {
        this.id_Purchase = this.getUrlVars(window.location.href)["purchase"];
        this.dataPurchase(this.id_Purchase);
      }
    }
  }
</script>

<style>
  .loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url("../../../../../public/loading2.gif") 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
  }
</style>
