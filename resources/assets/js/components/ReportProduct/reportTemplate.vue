<template>
  <div style="background:white;">
    <div class="loader" v-if="loading"></div>
    <div id="reportTable" style="background: white;">
      <table width="100%" style="margin-top: 10px">
        <thead>
          <tr>
            <td>
              <div class="container-fluid" style="margin-top:10px;">
                <div class="row">
                  <div class="col-md-12">
                    <div class="text-center">
                      <h5 style>Business Intelligence</h5>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="text-center">
                      <h6>{{title}}</h6>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div>Año: 2020</div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(month, key) in months" :key="key">
            <td>
              <div>
                <table id="tabledata" width="100%" style="margin-top: 5px">
                  <thead id="theaderdata">
                    <tr>
                      <td colspan="3" style="text-align:center;font-size:20px;">{{month}}</td>
                    </tr>
                    <tr style="border-top: 1px solid black;">
                      <th
                        v-for="(val, index) in headers"
                        :key="index"
                        :style="hidecolumn(val) ? 'display:none;' : ''"
                      >
                        <b :style="constains(val) ? 'float:right;' : ''">{{val}}</b>
                      </th>
                    </tr>
                  </thead>
                  <tbody id="tbodydata">
                    <tr v-for="(item, index) in table_data[key]" :key="index">
                      <td
                        class="hide"
                        v-for="(value,llave) in item"
                        :key="llave"
                        :style="hidecolumn(llave) ? 'display:none;' : ''"
                      >
                        <span
                          :style="constains(llave) ? 'float:right;' : ''"
                        >{{moneyFormat(llave, value)}}</span>
                      </td>
                    </tr>
                    <tr
                      style="border-top: 1px solid black;color: black;font-weight: bold;text-align: left;"
                    >
                      <td
                        class="hide"
                        v-for="(valTotal, indexTotal) in totales[key]"
                        :key="indexTotal"
                      >
                        <b
                          :style="constains(indexTotal) ? 'float:right;' : ''"
                        >{{moneyFormatTotal(indexTotal, valTotal)}}</b>
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
                    <h6 style="float:right;">Fecha: {{dateCurrent()}}</h6>
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
  data() {
    return {
      table_data: [],
      headers: [],
      filterHeaders: ["id", "mes", "description"],
      title: "",
      date: [],
      months: [],
      filterMoneyFormat: ["monto", "cantidadTotales"],
      totales: [],
      loading: false
    };
  },
  methods: {
    dateCurrent() {
      return moment().format("D MMMM YYYY, h:mm:ss a");
    },
    constains(str) {
      if (typeof str == "string" && str.indexOf(".") > -1) {
        return true;
      } else if (
        str == "Monto" ||
        str == "Cantidad" ||
        str == "monto" ||
        str == "cantidad"
      ) {
        return true;
      } else if (Number.isInteger(str)) {
        return true;
      }

      return false;
    },
    DateFormat(date) {
      return moment(date).format("D MMMM  YYYY");
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
    moneyFormat(key, val) {
      var found = this.filterMoneyFormat.find(
        e => e.toLowerCase() == key.toLowerCase()
      );

      if (found) {
        return parseFloat(val).formatMoney(2);
      }
      return val;
    },
    moneyFormatTotal(key, val) {
      var found = this.filterMoneyFormat.find(
        e => e.toLowerCase() == Object.keys(val)[0].toLowerCase()
      );

      if (found) {
        return parseFloat(val[Object.keys(val)[0]]).formatMoney(2);
      }
      return val[Object.keys(val)[0]];
    },
    getTotales() {
      let totales = [];
      this.table_data.forEach(arr => {
        var cantidad = 0;
        var monto = 0;
        for (var item in arr) {
          cantidad = cantidad + parseInt(arr[item]["cantidad"]);
          monto += parseFloat(arr[item]["monto"]);
        }
        totales.push([
          { empty: "" },
          { cantidadTotales: cantidad },
          { monto: monto }
        ]);
      });

      this.totales = totales;
    }
  },
  mounted() {
    this.title = "Reporte de productos por meses";
    this.loading = true;
    axios
      .post("/reportv2/product/meses")
      .then(response => {
        this.table_data = response.data["data"];
        this.headers = response.data["header"];
        this.months = response.data["months"];
        this.loading = false;
      })
      .catch(error => {
        console.log(error);
      })
      .finally(() => {
        this.getTotales();
        setTimeout(window.print(), 5000);
      });
  },
  created() {}
};
</script>

<style>
.loader {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url("../../../../../public/loading2.gif") 50% 50% no-repeat
    rgb(249, 249, 249);
  opacity: 0.8;
}
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