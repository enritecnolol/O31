<template>
  <form @submit="save" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-12">
        <div class="float-left">
          <h3>Formulario de Producto</h3>
        </div>
        <div class="float-right">
          <button type="button"
                  class="btn btn-danger"
                  @click="goBack"><i class="fas fa-angle-left" /> Volver</button>
        </div>
      </div>
      <div class="col-md-12">
        <hr>
      </div>
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-12">
            <div class="group-control">
              <label for="name" class="control-label mb-1" >Nombre:</label>
              <input id="name" maxlength="50" type="text" class="form-control form-control-sm" v-model="name" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="group-control">
              <label for="code" class="control-label mb-1" >Referencia:</label>
              <input id="code" type="text" maxlength="10" class="form-control form-control-sm" v-model="code" required>
            </div>
          </div>
          <div class="col-md-8" />
          <div class="col-md-12">
            <div class="form-group">
              <label for="categories">Categoria:</label>
              <select class="form-control form-control-sm"  v-model="category"  id="categories" required>
                <option value="">Selecciona</option>
                <template v-for="(c, index) in categoriesList">
                  <option :value="c.id" :key="index">{{ c.nombre }}</option>
                </template>
                <option value="create" style="background-color: #2b32b2;color:white;">Crear categoria</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="itbis" class="control-label mb-1">Impuesto:</label>
              <select id="itbis"
                      required
                      v-model="itbis"
                      class="form-control form-control-sm"
                      name="compositeProduct">
                <option :value="0">Exento</option>
                <template v-for="(ref, index) in dataiItbisList">
                  <option :value="ref.id" :key="index">{{ ref.descripcion}}</option>
                </template>
              </select>
            </div>
          </div>
          <div class="col-md-8" />
          <div class="col-md-4">
            <div class="group-control">
              <label for="price" class="control-label mb-1" >Precio:</label>
              <money
                  v-if="!resetPriceInput"
                  id="price"
                  v-model="price"
                  v-bind="money"
                  class="form-control form-control-sm"
                  style="text-align: right"
                  required
              />
            </div>
          </div>
          <div class="col-md-8" />
          <div class="col-md-4">
            <div class="group-control">
              <label for="cost" class="control-label mb-1" >Costo:</label>
              <money v-if="!resetCostInput"
                     id="cost"
                     v-model="cost"
                     v-bind="money"
                     class="form-control form-control-sm"
                     style="text-align: right"
                     required
              />
            </div>
          </div>
          <div class="col-md-8"/>
          <div class="col-md-12">
            <div class="form-group">
              <label for="description">Descripcion:</label>
              <textarea id="description" class="form-control" rows="3" v-model="description"/>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="status" v-model="status">
              <label class="form-check-label" for="status">Activo</label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="productSale" v-model="saleConfig" title="activar o deshabilitar para indicar que el producto de venta">
              <label class="form-check-label" for="productSale">Producto de venta</label>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="ProductPurchase" v-model="purchaseConfig" title="activar o deshabilitar para indicar que el producto es de compra">
              <label class="form-check-label" for="ProductPurchase">Producto de compra</label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="ServiceProduct" v-model="serviceConfig" title="activar o deshabilitar para indicar que el producto es de servicio">
              <label class="form-check-label" for="ServiceProduct">Producto de servicio</label>
            </div>
            <div class="form-group form-check">
              <input type="checkbox"
                     class="form-check-input"
                     id="InventaryProduct"
                     v-model="inventoryConfig"
                     title="activar o deshabilitar para llevar el inventario del producto ">
              <label class="form-check-label"
                     for="InventaryProduct"
              >Producto de inventario</label>
            </div>
          </div>
          <div class="col-md-12 text-center">
            <input
                style="display: none"
                ref="cover"
                type="file"
                id="inputFileUpload"
                name="filename"
                class="form-control-file"
                @change="onFileChange"
            >
            <img :src="urlImg ? urlImg : 'imagenes/'+img" alt="" style="width: 150px;cursor:pointer" @click="$refs.cover.click()">
            <label>Haga click en la imagen para cambiarla</label>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="float-right">
          <button type="submit" class="btn btn-primary" value="Upload"><i class="fas fa-save" /> Salvar</button>
          <!--                    <button type="button" class="btn btn-danger"-->
          <!--                            @click="confirmProduct"-->
          <!--                            v-if="editData"-->
          <!--                    ><i class="fas fa-trash-alt" /> Inactivar</button>-->
          <button type="button" class="btn btn-warning" @click="back"><i class="fas fa-times" /> Cancelar</button>
        </div>
      </div>
    </div>
    <newCategory @refreshCategory="getCategoriesList"/>
  </form>
</template>

<script>
import money from "v-money";
import newCategory from "./categoryModal";
Vue.use(money, { precision: 4 });
export default {
  props:['editData'],
  components:{newCategory},
  data()
  {
    return{
      resetCostInput:false,
      resetPriceInput:false,
      money: {
        decimal: ".",
        thousands: ",",
        prefix: "RD$ ",
        precision: 2,
        masked: false
      },
      code:'',
      name:'',
      price:0,
      cost:0,
      compositeProduct:'no',
      itbis:0,
      dataiItbisList:[],
      category:'',
      categoriesList:[],
      filename: '',
      file: '',
      success: '',
      status:true,
      img:'default.jpg',
      saleConfig:false,
      serviceConfig:false,
      inventoryConfig:false,
      purchaseConfig:false,
      urlImg:"",
      description:"",
      loading:false
    }
  },
  methods:{
    confirmProduct (){
      var txt;
      var r = confirm("Estas Seguro que quieres INACTIVAR este producto?");
      if (r == true){
        txt = this.deleteProduct(this.editData.id);
      }
    },
    deleteProduct(id){
      axios.post('/eliminar/producto',{
        id:id
      })
          .then((response) => {
            toastr.success(response.data.message);
            this.reset();
            this.$emit('refreshData')
          })
          .catch((error) => {
            console.log(error.response.data.message)
          });
    },
    goBack()
    {
      this.reset();
      this.$emit('productForm')
    },
    onFileChange(e)
    {
      console.log(e)
      this.filename = "Selected File: " + e.target.files[0].name;
      this.file = e.target.files[0];
      this.urlImg = URL.createObjectURL(this.file);
    },
    itbisList()
    {
      axios.post('/impuestoref/datos/producto',)
          .then((response) => {
            this.dataiItbisList = response.data;
          })
          .catch( (error) => {
            console.log(error)
          });
    },
    getCategoriesList() {
      axios.post('/ver/categoria')
          .then( (response) => {
            this.categoriesList = response["data"];
            this.category = "";
            if(this.editData)
            {
              this.completeForm()
            }
          })
          .catch((error) => {
            console.log(error)
          });
    },
    save(e)
    {
      e.preventDefault();
      const config = {
        headers: {
          'content-type': 'multipart/form-data',
        }
      };
      // form data
      if(this.cost.toString().length > 12 || this.price.toString().length > 12)
      {
        toastr.warning("Hemos encontrado una irregularidad en los numeros");
        return;

      }
      let formData = new FormData();
      if(this.editData)
      {
        formData.append('id', this.editData.id);
      }
      formData.append('img', this.file);
      formData.append('barcode', this.code);
      formData.append('nombre', this.name);
      formData.append('precio', this.price);
      formData.append('cost', this.cost);
      formData.append('refimpuestoid', this.itbis);
      formData.append('categoria', this.category);
      formData.append('subcategoria', '');
      formData.append('compuesto', this.compositeProduct);
      formData.append('estado', this.status ? 1 : 0);
      formData.append('saleConfig', this.saleConfig ? 1 : 0);
      formData.append('serviceConfig', this.serviceConfig ? 1 : 0);
      formData.append('inventoryConfig', this.inventoryConfig ? 1 : 0);
      formData.append('purchaseConfig', this.purchaseConfig ? 1 : 0);
      formData.append('description', this.description);

      // send upload request
      let url = this.editData ? '/anja/' + this.editData.id : 'productos';
      this.loading = true;
      axios.post(url, formData, config)
          .then( (response) => {
            toastr.success(response.data.message);
            this.reset();
            this.$emit('refreshData')
          })
          .catch( (error) => {
            toastr.error(error.response.data.message);
          })
          .finally( () => {
            this.loading = false;
          })
      ;
    },
    back()
    {
      this.$emit('refreshData');
    },
    reset()
    {
      this.file = "";
      this.filename = "";
      this.code = "";
      this.name = "";
      this.price = "";
      this.cost = "";
      this.itbis = "";
      this.category = "";
      this.compositeProduct = "";
      this.saleConfig = false;
      this.serviceConfig = false;
      this.inventoryConfig = false;
      this.purchaseConfig = false;
      this.description = "";
    },
    completeForm()
    {
      this.code = this.editData.barcode;
      this.name = this.editData.name;
      this.price = this.editData.price;
      this.cost = this.editData.cost;
      this.itbis = this.editData.impuestoref_id;
      this.category = this.editData.categoria_id;
      this.compositeProduct = this.editData.compuesto;
      this.status = this.editData.estado;
      this.img = this.editData.img;
      this.saleConfig = this.editData.sale_config;
      this.serviceConfig = this.editData.service_config;
      this.inventoryConfig = this.editData.inventory_config;
      this.purchaseConfig = this.editData.purchase_config;
      this.description = this.editData.description;
    }
  },
  watch:{
    category()
    {
      if (this.category === "create")
      {
        $('#newCategory').modal('show')
      }
    },
    cost(newCost, oldCost)
    {
      if(newCost > 999999999.99)
      {
        this.resetCostInput = true;
        this.cost = oldCost;
        setTimeout(() => {
          this.resetCostInput = false;
        },1)
      }
    },
    price(newPrice, oldPrice)
    {
      if(newPrice > 999999999.99)
      {
        this.resetPriceInput = true;
        this.price = oldPrice;
        setTimeout(() => {
          this.resetPriceInput = false;
        },1)
      }
    }
  },
  created() {
    this.itbisList();
    this.getCategoriesList();
    if(this.editData)
    {
      this.completeForm()
    }
  }
}
</script>


<style scoped>

</style>
