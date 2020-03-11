<template>
  <card-panel>
    <template slot="body">
      <div class="loader" v-if="loading"></div>
      <div class="card-body">
        <div class="row" v-if="data">
          <div class="col-md-12">
            <h3>Compra</h3>
            <hr>
          </div>
          <div class="col-md-7" style="margin-top: 20px">
            <div class="row">
              <div class="col-md-12">
                <h4>Detalle compra</h4>
              </div>
              <div class="col-md-12" style="margin-top: 5px">
                <general-table :striped="true" :responsive="false">
                  <template slot="table-body">
                    <tr>
                      <td><b>Total:</b> {{parseFloat(data.total).formatMoney(2)}}</td>
                      <td><b>Total pagos:</b> {{parseFloat(data.total - data.balance).formatMoney(2)}}</td>
                      <td><b>Saldo:</b> {{parseFloat(data.balance).formatMoney(2)}}</td>
                    </tr>
                    <tr>
                      <td><b>Fecha:</b> {{data.created_at}}</td>
                      <td><b>Orden de Compra No:</b> No existe</td>
                      <td><b>Almacen:</b> General</td>
                    </tr>
                    <tr>
                      <td><b>Proveedor:</b> {{getSupplier(data.supplier_id)}}</td>
                      <td><b>Teléfono:</b> Indefinido</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="3"><b>Nota:</b> {{data.note ? data.note : 'No hay notas'}}</td>
                    </tr>
                  </template>
                </general-table>
              </div>
              <div class="col-md-12" style="margin-top: 20px">
                <h4>Articulos</h4>
              </div>
              <div class="col-md-12" style="margin-top: 4px">
                <general-table :striped="true" :responsive="false" :header-light="true">
                  <template slot="table-header">
                    <tr>
                      <th>Ref.</th>
                      <th>Producto</th>
                      <th>Cant</th>
                      <th style="text-align: right">Precio</th>
                      <th style="text-align: right">Total</th>
                    </tr>
                  </template>
                  <template slot="table-body">
                    <tr v-for="(item, index) in data.details" :key="index">
                      <td>{{getProduct(item.product_id)['barcode']}}</td>
                      <td>{{getProduct(item.product_id)['name']}}</td>
                      <td>{{item.quantity}}</td>
                      <td style="text-align: right">{{parseFloat(item.price).formatMoney(2)}}</td>
                      <td style="text-align: right">{{parseFloat(item.total).formatMoney(2)}}</td>
                    </tr>
                  </template>
                </general-table>
              </div>
            </div>
          </div>
          <div class="col-md-5" style="margin-top: 20px">
            <div class="row">
              <div class="col-md-12">
                <h4>Listado de pagos de Compra</h4>
              </div>
              <div class="col-md-12" style="margin-top: 5px">
                <i class="fas fa-plus-circle" style="font-size: 26px;color: #108000" @click="openModal" v-if="data.balance > 0"/>
                <div class="alert alert-info" role="alert" v-if="data.balance === 0">
                  Cuenta saldada
                </div>
              </div>
              <div class="col-md-12" style="margin-top: 5px">
                <general-table :striped="true" :responsive="false" :header-light="true">
                  <template slot="table-header">
                    <tr>
                      <th>Fecha</th>
                      <th style="text-align: right">Cantidad</th>
                      <th>Tipo</th>
                      <th style="text-align: center">Acciones</th>
                    </tr>
                  </template>
                  <template slot="table-body">
                    <tr v-for="(item, index) in data.payments">
                      <td>{{item.date_payment}}</td>
                      <td style="text-align: right">{{parseFloat(item.amount).formatMoney(2)}}</td>
                      <td>{{item.payment_method}}</td>
                      <td style="text-align: center"><i class="fas fa-trash"  style="font-size: 22px;color: red" @click="deletePayment(item)"/></td>
                    </tr>
                  </template>
                </general-table>
              </div>
            </div>
          </div>
        </div>
        <modal-purchase-payment :data="data" @fetchData="fetch"/>
      </div>
    </template>
  </card-panel>
</template>

<script>
  import cardPanel from "../cardPanel";
  import generalTable from "../generalTable";
  import modalPurchasePayment from "./modalPurchasePayment";
  export default {
    name:'purchase-payment',
    components:{cardPanel, generalTable, modalPurchasePayment},
    data()
    {
      return {
        data:null,
        productsList: [],
        supplierList: [],
        loading:false
      }
    },
    methods:{
      deletePayment(item)
      {
        var r = confirm("Esta seguro de eliminar este pago?");
        if (r == true) {
          axios.delete('/purchase/payment', {
            params:{
              payment:item.id
            }
          })
          .then((response) => {
            toastr.success("El pago ha sido eliminado con exito", "Validador");
            this.fetch();
          })
          .catch((err) => {
            console.log(err);
          })
        }
      },
      openModal()
      {
        $('#modalPurchasePayment').modal('show');
      },
      getProduct(id)
      {
        return this.productsList.find(e => e.id == id) ? this.productsList.find(e => e.id == id) : 'no found';
      },
      getSupplier(id)
      {
        return this.supplierList.find(e => e.id == id) ? this.supplierList.find(e => e.id == id)['name'] : 'no found';
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
      },
      fetch(purchase)
      {
        if(!purchase)
        {
          this.loading = true;
          purchase = this.getUrlVars(window.location.href)["purchase"]
        }
        axios.get('/purchase/data', {
          params:{
            purchase:purchase
          }
        })
            .then((response) => {
              this.data = response.data
            })
            .catch((err) => {
              console.log(err)
            })
            .finally(()=> {
              this.loading = false;
            })
      },
      fetchProducts() {
        axios
            .get("/products/select")
            .then(response => {
              this.productsList = response["data"];
              if (this.getUrlVars(window.location.href)["purchase"]) {
                this.fetch(this.getUrlVars(window.location.href)["purchase"])
              }
            })
            .catch((error) => {
              console.log(error);
            });
      },
      fetchSupplier() {
        axios
            .get("/supplier/list/select")
            .then((response) => {
              this.fetchProducts();
              this.supplierList = response.data;
            })
            .catch((err) => {
              console.log(err);
            });
      }
    },
    created() {

      this.loading = true;
      this.fetchSupplier();
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