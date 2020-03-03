<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <div class="text-center">
          <h3 style="color: #4272d7">
            <u>Registro de Compra</u>
          </h3>
        </div>
      </div>
      <div class="col-md-12" style="margin-top: 15px">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
              <div class="row form-group">
                <div class="col col-md-3">
                  <label for="fecha" class="form-control-label">Fecha:</label>
                </div>
                <div class="col-12 col-md-9">
                  <input
                    type="date"
                    id="fecha"
                    value
                    v-model="fecha"
                    class="form-control form-control-sm"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="row form-group">
                <div class="col col-md-3">
                  <label for="vendedor" class="form-control-label">Provedor:</label>
                </div>
                <div class="col-12 col-md-9">
                  <input
                    type="text"
                    id="vendedor"
                    v-model="vendedor"
                    class="form-control form-control-sm"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="row form-group">
                <div class="col col-md-3">
                  <label for="cantidad" class="form-control-label">Monto:</label>
                </div>
                <div class="col-12 col-md-9">
                  <money
                    v-model="cantidad"
                    v-bind="money"
                    class="form-control form-control-sm float-right"
                    style="text-align: right;"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="nota" class="form-control-label">Nota:</label>
                <textarea id="nota" class="form-control form-control-sm" v-model="nota" rows="3"></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6" style="margin-top: 15px">
        <div class="container">
          <input
            type="text"
            v-model="search1"
            @input.stop="searchFirstTable"
            placeholder="Buscar producto"
            class="form-control form-control-sm"
          />
        </div>
      </div>
      <div class="col-md-6" style="margin-top: 15px">
        <div class="container">
          <input type="text" placeholder="Buscar producto" class="form-control form-control-sm" />
        </div>
      </div>
      <div class="col-md-12" style="margin-top: 15px">
        <div class="row">
          <div class="col-md-6">
            <div class="table-responsive" style="height: 500px;overflow-y: scroll">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Producto</th>
                    <th scope="col">Existencia</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <template v-for="(item, index) in productosSearch">
                    <tr :key="index">
                      <th scope="row">{{ item.name }}</th>
                      <td>{{ item.existence }}</td>
                      <td>
                        <button
                          type="button"
                          class="btn btn-primary btn-sm"
                          @click="pasarnuevaexistencia(item.id)"
                        >
                          <i class="fas fa-cart-plus" style="font-size: 18px"></i>
                        </button>
                      </td>
                    </tr>
                  </template>
                  <template v-if=" loading == true">
                    <tr>
                      <div class style="position: relative;left: 200px">
                        <img src="/loading.gif" width="100" alt />
                      </div>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-6">
            <div class="table-responsive" style="height: 500px;overflow-y: scroll">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Producto</th>
                    <th scope="col">Existencia</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio de compra</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <template v-for="(item, key) in productosnuevos">
                    <tr :key="key">
                      <th scope="row">{{ item.name }}</th>
                      <td>{{ item.existence }}</td>
                      <td>
                        <input
                          type="number"
                          style="width: 100px"
                          min="0"
                          v-model="item.cantidad_comprada"
                          class="form-control form-control-sm"
                        />
                      </td>
                      <td>
                        <money
                          v-model="item.precio_compra"
                          v-bind="money"
                          class="form-control form-control-sm float-right"
                          style="text-align: right;width: 130px"
                        />
                      </td>
                      <td>
                        <div
                          style="cursor: pointer;font-size: 24px"
                          @click="eliminarnuevaexistencia(item.id)"
                        >&times;</div>
                      </td>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-12" style="margin-top: 10px">
            <div class="text-center">
              <button type="button" class="btn btn-primary" @click="validarnuevaexistencia">
                <i class="fas fa-save"></i> Guardar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import money from "v-money";
Vue.use(money, { precision: 4 });
export default {
  data() {
    return {
      productos: [],
      productosSearch: [],
      productosnuevos: [],
      loading: false,
      fecha: "",
      vendedor: "",
      nota: "",
      cantidad: "",
      existenciarep: "",
      search1: "",
      money: {
        decimal: ".",
        thousands: ",",
        prefix: "RD$ ",
        precision: 2,
        masked: false
      }
    };
  },

  mounted() {
    this.todosproductos();
    this.fecha = moment().format("YYYY-MM-DD");
  },
  methods: {
    searchFirstTable() {
      let data = this.productos.filter(item => {
        return item.name.includes(this.search1);
      });

      this.productosSearch = data;
    },
    todosproductos() {
      this.loading = true;
      axios
        .post("/todos/productos")
        .then(response => {
          console.log(response);
          this.productos = response["data"];
          this.productosSearch = response["data"];
          this.loading = false;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    pasarnuevaexistencia(i) {
      for (var key in this.productos) {
        if (this.productos[key].id == i) {
          this.productosnuevos.push({
            id: this.productos[key].id,
            name: this.productos[key].name,
            existence: this.productos[key].existence,
            cantidad_comprada: 0,
            precio_compra: 0
          });
          var index = this.productos.indexOf(this.productos[key]);
          if (index > -1) {
            this.productos.splice(index, 1);
          }
          return;
        }
      }
    },
    eliminarnuevaexistencia(i) {
      for (var key in this.productosnuevos) {
        if (this.productosnuevos[key].id == i) {
          this.productos.push(this.productosnuevos[key]);
          this.productosnuevos.splice(key, 1);
          return;
        }
      }
    },
    validarnuevaexistencia() {
      for (var key in this.productosnuevos) {
        if (
          this.productosnuevos[key].cantidad_comprada <= 0 ||
          this.productosnuevos[key].precio_compra <= 0
        ) {
          toastr.warning(
            "Por favor revisar los productos con nueva existencia",
            "Validador"
          );
          return;
        }
      }
      this.registrarcompra();
    },
    registrarcompra() {
      if (
        this.fecha === "" ||
        this.vendedor === "" ||
        this.nota === "" ||
        this.cantidad === ""
      ) {
        toastr.warning("Por favor llenar todos los campos vacios", "Validador");
      } else {
        axios
          .post("/store/compra", {
            fecha: this.fecha,
            vendedor: this.vendedor,
            nota: this.nota,
            cantidad: this.cantidad,
            productoscomprados: this.productosnuevos
          })
          .then(response => {
            toastr.success("Datos Guardado Con Exito", "Validador");
            this.productosnuevos = [];
            this.todosproductos();
            this.fecha = moment().format("DD-MM-YYYY");
            this.vendedor = "";
            this.nota = "";
            this.cantidad = "";
          })
          .catch(function(error) {
            toastr.error("Se ha producido un error", "Error");
          });
      }
    }
  },
  computed: {}
};
</script>

<style lang="scss" scoped>
</style>