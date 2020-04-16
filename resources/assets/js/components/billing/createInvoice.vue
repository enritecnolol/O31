<template>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <div class="float-left">
          <h3>{{clientForm ? 'Crear cliente' : createdOrEdit ? 'Editando Factura' : 'Creando Factura'}}</h3>
        </div>
        <div class="float-right" v-if="!clientForm">
          <button class="btn btn-sm btn-primary" @click="createFormStatus">Lista de Factura</button>
        </div>
        <div class="float-right" v-else>
          <button class="btn-sm btn-warning" @click="hideClientForm">
            <i class="fas fa-angle-left" /> Volver
          </button>
        </div>
      </div>
      <div class="col-md-12">
        <hr />
      </div>
      <div class="col-md-12" v-show="!clientForm">
        <div class="row">
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">
                    Cliente:
                    <span style="color:red">*</span>
                  </label>
                  <div class="col-sm" style="padding: 0">
                    <v-select v-model="selectedCustomer" :options="clientsListForSelect" @input="setSelected" />
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label for="Textarea1" class="col-sm-2 col-form-label">
                    Dirección:
                    <span style="color:red">*</span>
                  </label>
                  <textarea class="form-control col-sm" id="Textarea1" rows="1" v-model="address" />
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label for="TexInputEmail" class="col-sm-2 col-form-label">
                    Email:
                    <span style="color:red">*</span>
                  </label>
                  <input
                          type="text"
                          maxlength="50"
                          class="form-control form-control-sm col-sm"
                          v-model="email"
                          id="TexInputEmail"
                  />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label for="id" class="col-sm-4 col-form-label">
                    RNC/Cedula:
                    <span style="color:red">*</span>
                  </label>
                  <input
                          id="id"
                          name="id"
                          v-model="data_ncf.rnc"
                          class="form-control form-control-sm col-sm"
                          type="text"
                  />
                </div>
              </div>
              <div class="col-md-6"/>
            </div>
          </div>
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">
                    Fecha:
                    <span style="color:red">*</span>
                  </label>
                  <div class="col-sm">
                    <datepicker
                            :bootstrap-styling="true"
                            v-model="estimateDate"
                            :calendar-class="'form-control form-control-sm'"
                            :format="'yyyy-MM-dd'"
                            name="estimateDate"
                    />
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <select-term @changeTerm="changeTerm" :termExternal="term" :landscape="true"/>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">
                    Vencimiento:
                  </label>
                  <div class="col-sm">
                    <datepicker
                            :bootstrap-styling="true"
                            v-model="dueDate"
                            :calendar-class="'form-control form-control-sm'"
                            :format="'yyyy-MM-dd'"
                            name="dueDate"
                    />
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label for="NCF_type" class="col-sm-4 col-form-label">Tipo ncf:</label>
                  <div class="col-sm">
                    <select id="NCF_type" class="form-control form-control-sm" v-model="type_ncf">
                      <option value="01">01 | Credito Fiscal</option>
                      <option value="02" selected>02 | Facturas de Consumo</option>
                      <option value="03">03 | Notas de Debito</option>
                      <option value="04">04 | Notas de Credito</option>
                      <option value="11">11 | Provedores Informales</option>
                      <option value="12">12 | Registro Unico de Ingresos</option>
                      <option value="13">13 | Registro de Gastos Menores</option>
                      <option value="14">14 | Regímenes Especiales de Tributación</option>
                      <option value="15">15 | Comprobantes Gubernamentales</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label for="ncf" class="col-sm-4 col-form-label">NCF:</label>
                  <div class="col-sm">
                    <input type="text" :disabled="type_ncf == '02'" class="form-control form-control-sm" id="ncf">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <client-form v-if="clientForm" @hideForm="clientForm = false" />
      </div>
    </div>

    <div class="row" style="margin-top: 20px" v-show="!clientForm">
      <div class="col-md-12">
        <table-estimate>
          <template slot="table-header">
            <th>Producto/Servicio</th>
            <th>Descripción</th>
            <th>
              <p style="float: right">Cantidad</p>
            </th>
            <th>
              <p style="float: right">Precio</p>
            </th>
            <th>
              <p style="float: right">Itbis</p>
            </th>
            <th>
              <p style="float: right">Importe</p>
            </th>
            <th />
          </template>
          <template slot="table-body">
            <template v-for="(item, index) in items">
              <itemBody
                      :key="index"
                      :index="index"
                      :item="item"
                      :products-list="productsList"
                      @removeItem="removeElement"
                      @replaceElement="replaceElement"
                      :list-itbis="ListItbis"
              />
            </template>
          </template>
        </table-estimate>
      </div>
      <div class="col-md-12" style="margin-top: 20px">
        <div class>
          <button class="btn btn-primary btn-sm" @click="addrow" style="width: 150px">
            <i class="fas fa-cart-arrow-down" /> Agregar fila
          </button>
        </div>
        <hr />
      </div>
      <div class="col-md-12" style="margin-top: 15px">
        <estimate-total :subTotal="subTotal" :discount-percent="discount" :total="total" :tax="tax" @ChangeDiscountApplied="ChangeDiscountApplied"/>
        <div class="float-left">
          <div class="row">
            <div class="col-md-4">
              <textarea
                      placeholder="Nota"
                      class="form-control"
                      id="NoteTextArea"
                      rows="4"
                      v-model="note"
              />
            </div>
            <div class="col-md-6">
              <textarea
                      placeholder="Aqui va lo terminos o acuerdo..."
                      class="form-control"
                      id="terms"
                      rows="4"
                      style="width:470px;"
                      v-model="termNote"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row" style="margin-top: 20px" v-show="!clientForm">
      <div class="col-md-12">
        <button class="btn btn-primary btn-sm" @click="save(false)">
          <i class="far fa-file-alt" />
          {{createdOrEdit ? 'Salvar' : 'Guardar'}}
        </button>
        <button class="btn btn-success btn-sm" @click="save(true)">
          <i class="far fa-file-alt" />
          <i class="fas fa-paper-plane" />
          {{createdOrEdit ? 'Salvar' : 'Guardar'}} y enviar
        </button>
        <button class="btn btn-success btn-sm" @click="duplicate(dataEdit.id)" v-if="createdOrEdit">
          <i class="fas fa-paste" />
          Duplicar
        </button>
      </div>
    </div>
  </div>
</template>
<script>
  import Vue from "vue";
  import vSelect from "vue-select";
  import "vue-select/dist/vue-select.css";
  import money from "v-money";
  import Datepicker from "vuejs-datepicker";
  import itemBody from "../estimate/ItemBody";
  import clientForm from "../estimate/clientForm";
  import EstimateTotal from "../estimate/Estimatetotal";
  import tableEstimate from "../estimate/table-estimate";
  import selectTerm from "../terms/selectTerm";
  Vue.use(money, { precision: 4 });
  Vue.component("v-select", vSelect);
  import modalBig from "../modal/modalBig";

  export default {
    name: "create-estimate",
    components: {
      Datepicker,
      itemBody,
      clientForm,
      EstimateTotal,
      tableEstimate,
      selectTerm,
      modalBig
    },
    props: ["dataEdit", "loading"],
    data() {
      return {
        clientForm: false,
        estimateDate: "",
        dueDate: "",
        selectedCustomer: "",
        clientsData: [],
        productsList: [],
        items: [
          {
            product: "",
            description: "",
            quantity: "1",
            price: 0,
            discount: 0,
            amount: 0,
            tax:0
          }
        ],
        note: "",
        address: "",
        codeEstimate: "",
        email: "",
        type_ncf: "02",
        term: "",
        data_ncf: {
          telefono: "",
          rnc: "",
          razon: ""
        },
        rnc_data: {},
        settings: {},
        idCedula:"",
        ListItbis:[],
        termNote:"",
        discount:0,
      };
    },
    methods: {
      ChangeDiscountApplied(amount)
      {
        this.discount = amount
      },
      duplicate(id)
      {
        axios.get('/invoices/duplicate', {
          params:{
            id:id
          }
        })
                .then((response) => {
                  toastr.success(response.data.message)
                })
                .catch((error) => {
                  toastr.warning(error.response.data.message);
                  console.log(error)
                })
      },
      changeTerm({ id, number_days }) {
        if (number_days === "") {
          return;
        }
        this.term = id;
        var today = new Date();
        var dueDate = new Date();
        dueDate.setDate(today.getDate() + number_days);
        this.dueDate = dueDate;
      },
      buscar_rnc() {
        this.loadingStatus(true);
        this.data_ncf.razon = "cargando...";
        axios
                .post("/rnc/test", {
                  rnc: this.data_ncf.rnc
                })
                .then(response => {
                  if (this.rnc_data === 0) {
                    toastr.warning("No se ha encotrado este RNC");
                    return;
                  }
                  let dataXML = this.convertirXmlEnObjeto($.parseXML(response.data));
                  this.rnc_data = JSON.parse(
                          dataXML["soap:Body"]["GetContribuyentesResponse"][
                                  "GetContribuyentesResult"
                                  ]
                  );
                  this.data_ncf.razon = this.rnc_data["RGE_NOMBRE"];
                })
                .catch(function(error) {
                  this.data_ncf.razon = "";
                })
                .finally(function() {
                  if (this.data_ncf.razon === "cargando...") {
                    this.data_ncf.razon = "";
                  }
                  this.loadingStatus(false);
                });
      },
      loadingStatus(val) {
        this.$emit("loading", val);
      },
      convertirXmlEnObjeto(xml) {
        var objeto = {};
        var esRaiz = false;

        //  Objeto "raiz"
        if (xml.nodeType == 1) {
          // Objeto
          // Se recuperan sus atributos
          if (xml.attributes.length > 0) {
            for (var j = 0; j < xml.attributes.length; j++) {
              var atributo = xml.attributes.item(j);
              objeto[atributo.nodeName] = atributo.nodeValue;
            }
          }
        } else if (xml.nodeType == 3) {
          // Texto
          objeto = xml.nodeValue;
        } else if (xml.nodeType == 9) {
          // Elemento raiz
          esRaiz = true;
        }

        // Atributos del objeto (objetos hijos)
        if (xml.hasChildNodes()) {
          for (var i = 0; i < xml.childNodes.length; i++) {
            var item = xml.childNodes.item(i);
            var nombreNodo = item.nodeName;

            // Si objeto no tiene un atributo con el nombre nombreNodo se anade, si ya lo tiene (es un array) se anade
            // a la lista del objeto con nombre nombreNodo
            if (typeof objeto[nombreNodo] == "undefined") {
              // Si el elemento es un CDATA se copia el contenido en el elemento y no se crea un
              // hijo para almacenar el texto
              if (nombreNodo == "#cdata-section") {
                objeto = item.nodeValue;
              } else if (nombreNodo == "#text") {
                // Si el elemento es un texto no se crea el objeto #text
                if (item.childNodes.length < 1) {
                  objeto = item.nodeValue;
                } else {
                  objeto[nombreNodo] = this.convertirXmlEnObjeto(item);
                }
              } else {
                if (esRaiz) {
                  objeto = this.convertirXmlEnObjeto(item);
                } else {
                  objeto[nombreNodo] = this.convertirXmlEnObjeto(item);
                }
              }
            } else {
              // Si el atributo no es una lista se convierte el atributo en un array y se anade el
              // valor a dicho array
              if (typeof objeto[nombreNodo].push == "undefined") {
                var valorAtributo = objeto[nombreNodo];
                objeto[nombreNodo] = new Array();
                objeto[nombreNodo].push(valorAtributo);
              }

              objeto[nombreNodo].push(this.convertirXmlEnObjeto(item));
            }
          }
        }

        return objeto;
      },
      itemsEditFormat(items) {
        let array = [];
        for (var index in items) {
          array.push({
            id: items[index].id,
            product: {
              label: items[index].name_product
                      ? items[index].name_product
                      : items[index].product,
              code: items[index].product_id
            },
            description: items[index].description,
            quantity: items[index].quanlity
                    ? items[index].quanlity
                    : items[index].quantity,
            price: items[index].price,
            discount: items[index].descuento
                    ? items[index].descuento
                    : items[index].discount
                            ? items[index].discount
                            : 0,
            amount: items[index].amount
                    ? items[index].amount
                    : items[index].amount,
            tax:items[index].impuestoref_id,
            product_id: items[index].product_id
          });
        }
        return array;
      },
      createFormStatus() {
        this.$emit("createFormStatus", false);
      },
      setSelected(val) {
        let found = this.clientsData.find(e => e.id === val.code);
        if (found) {
          this.address = found.direccion;
          this.email = found.email;
          this.term = found.term;
          this.data_ncf.rnc = found.rnc;
        }
      },
      hideClientForm() {
        this.clientForm = false;
        this.selectedCustomer = "";
        this.ClientsDate();
      },
      labelView(label) {
        return label.label ? label.label : label;
      },
      config() {
        axios
                .post("/configuracion/sale")
                .then(response => {
                  for (var key in response["data"]) {
                    this.settings = response["data"][key];
                    break;
                  }
                })
                .catch(function(error) {});
      },
      save(send) {
        if (
                this.selectedCustomer === "" ||
                this.email === "" ||
                this.address === "" ||
                this.selectedCustomer === ""
        ) {
          toastr.warning("por favor llenar los datos necesarios");
          return;
        }

        if( !this.term || this.term === "new")
        {
          toastr.warning("Es necesario relacionar una condicion");
          return;
        }

        if(send && this.email === "")
        {
          toastr.warning("La factura no tiene un email relacionado");
          return;
        }

        if (this.settings.generacomprobante === "si") {
          if (this.type_ncf !== "02") {
            if (
                    this.data_ncf.rnc === ""
            ) {
              toastr.warning("Por favor llenar RNC/Cedula");
              return;
            }
          }
        }

        if (this.reduceItems.length === 0) {
          toastr.warning("La factura no posee articulos vinculados");
          return;
        }
        if(this.total === 0)
        {
          var r = confirm("Estas seguro que quieres guardar la factura en 0 ?");
          if (r == false)
          {
            return;
          }
        }

        let url = this.createdOrEdit ? "/invoice/edit" : "/invoice";
        this.loadingStatus(true);
        axios
                .post(url, {
                  id: this.createdOrEdit ? this.dataEdit.id : this.dataEdit,
                  invoice_number: this.codeEstimate,
                  invoice_date: this.estimateDate,
                  due_date: this.dueDate,
                  client_id: this.selectedCustomer,
                  address: this.address,
                  email: this.email,
                  note: this.note,
                  subtotal: this.subTotal,
                  total: this.total,
                  tax:this.tax,
                  details: this.reduceItems,
                  send: send,
                  tiponfc: this.type_ncf,
                  datancf: this.data_ncf,
                  term:this.term,
                  term_note:this.termNote,
                  discount:this.discountTotal,
                  discountPercent: this.discount

                })
                .then(response => {
                  if (
                          response.data ===
                          "No es posible hacer la factura por falta de Comprobantes"
                  ) {
                    toastr.warning(
                            "No es posible hacer la factura por falta de Comprobantes",
                            "validador"
                    );
                    return;
                  }
                  if (response.data.notification) {
                    toastr.info(response.data.notification, "Documento Fiscal");
                  }
                  toastr.success("Datos guardado correctamente");
                  this.reset();
                })
                .catch(error => {
                  toastr.warning(error.response.data.message);
                })
                .finally(() => {
                  this.loadingStatus(false);
                })
        ;
      },
      reset() {
        var today = new Date();
        var dueDate = new Date();
        dueDate.setDate(today.getDate() + 15);

        Object.assign(this.$data, {
          clientForm: false,
          estimateDate: today,
          dueDate: dueDate,
          selectedCustomer: "",
          items: [
            {
              product: "",
              description: "",
              quantity: "1",
              price: 0,
              discount: 0,
              amount: 0,
              tax:0
            }
          ],
          note: "",
          address: "",
          codeEstimate: "",
          email: "",
          termNote:"",
          discount:0
        });
      },
      ClientsDate() {
        axios
                .post("/clientes/datos/tabla2")
                .then(response => {
                  this.clientsData = response["data"];
                  if (this.dataEdit) this.completeForm();
                  this.clientToInvoice();
                })
                .catch(error => {
                  console.log(error);
                });
      },
      completeForm() {
        this.estimateDate = this.dataEdit.date
                ? new Date(moment(this.dataEdit.date).add(0, 'days'))
                : this.dataEdit.invoice_date;
        this.dueDate = new Date(moment(this.dataEdit.due_date).add(0, 'days'));
        let client = this.dataEdit.client_id
                ? parseInt(this.dataEdit.client_id)
                : parseInt(this.dataEdit.client);
        this.selectedCustomer = this.clientsListForSelect.find(
                e => e.code === client
        );
        this.term = this.dataEdit.term_id;
        this.address = this.dataEdit.address;
        this.codeEstimate = this.dataEdit.id;
        this.email = this.dataEdit.email;
        this.items = this.itemsEditFormat(this.dataEdit.invoice_details);
        this.note = this.dataEdit.note;
        this.termNote = this.dataEdit.term_note;
        this.discount = this.dataEdit.discount_percent;
      },
      getProducts() {
        axios
                .get("/products/select/sale")
                .then(response => {
                  this.productsList = response["data"];
                })
                .catch(error => {
                  console.log(error);
                });
      },
      addrow() {
        this.items.push({
          product: "",
          description: "",
          quantity: 1,
          price: 0.0,
          discount: 0,
          amount: 0.0,
          tax:0
        });
      },
      removeElement(index) {
        this.items.splice(index, 1);
      },
      replaceElement({ index, item }) {
        this.items.splice(index, 1, item);
      },
      clientToInvoice() {
        if (this.getUrlVars(window.location.href)["client"]) {
          this.selectedCustomer = this.clientsListForSelect.find(
                  e =>
                          e.code === parseInt(this.getUrlVars(window.location.href)["client"])
          );
          this.setSelected(this.selectedCustomer);
        }
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
      itbisList()
      {
        axios.post("/impuestoref/datos/producto")
                .then((res) => {
                  this.ListItbis = res.data;
                  console.log(res)
                })
                .catch((error) => {
                  console.log(error)
                })
      }
    },
    computed: {
      createdOrEdit() {
        return this.dataEdit && this.dataEdit.action !== "create";
      },
      reduceItems() {
        let array = [];
        for (var index in this.items) {
          if (
                  this.items[index].product !== "" ||
                  this.items[index].description !== ""
          ) {
            array.push(this.items[index]);
          }
        }
        return array;
      },
      clientsListForSelect() {
        let array = [];
        for (var index in this.clientsData) {
          array.push({
            label: this.clientsData[index].nombre,
            code: this.clientsData[index].id
          });
        }
        array.push({
          label:"Nuevo cliente",
          code:"new"
        });

        return array;
      },
      productsListForSelect() {
        let array = [];
        for (var index in this.productsList) {
          array.push({
            label: this.productsList[index].name,
            code: this.productsList[index].id
          });
        }
        return array;
      },
      total()
      {
        return this.subTotal - this.discountTotal  + this.tax;
      },
      discountTotal()
      {
        let discount = this.discount/100;
        discount = this.subTotal * discount;
        return discount;
      },
      subTotal() {
        let total = 0;

        for (var index in this.items) {
          var impost = this.ListItbis.find(e => e.id == this.items[index].tax);
          if(!impost)
          {
            impost = {
              porciento:0
            }
          }
          var price = this.items[index].price * this.items[index].quantity;

          if (this.settings.impuesto === "incluido")
          {
            total += price / parseFloat('1.'+ impost.porciento);
          }else{
            total += price + (price * parseFloat('0.' + impost.porciento));
          }

        }
        return total;
      },
      tax() {
        let tax = 0;
        if(!this.ListItbis)
        {
          return 0;
        }
        for (var index in this.items) {
          var impost = this.ListItbis.find(e => e.id == this.items[index].tax);
          if(!impost)
          {
            impost = {
              porciento:0
            }
          }

          var price = this.items[index].price * this.items[index].quantity;
          var discount = this.discount / 100;
          var TotalDesc = price * discount;
          price = price - TotalDesc;

          if (this.settings.impuesto === "incluido")
          {
            tax += price -  (price / parseFloat('1.'+ impost.porciento));
          }else{
            tax += price * parseFloat('0.' + impost.porciento);
          }

        }
        return tax;
      }
    },
    watch:{
      selectedCustomer()
      {
        if (this.selectedCustomer.code === "new") {
          this.clientForm = true;
          return;
        }
      }
    },
    created() {
      this.config();
      this.itbisList();
      this.getProducts();
      this.ClientsDate();
      var today = new Date();
      var dueDate = new Date();
      dueDate.setDate(today.getDate() + 5);
      this.estimateDate = today;
      this.dueDate = dueDate;
    }
  };
</script>
<style>
  .createCustomer:hover {
    color: #0e3bbb !important;
  }
  input[type="number"] {
    text-align: right;
  }
</style>
