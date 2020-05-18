<template>
  <div class="container-fluid" style="margin-top:0;">
    <div class="card" v-if="!seleccionado">
      <div class="card-body">
        <div class="row" >
          <div class="col-md-12" style="margin-bottom: 20px">
            <h2>Reportes Disponibles</h2>
          </div>
          <div class="col-md-12">
            <hr>
          </div>
          <template v-for="(item, index) in typereports">
            <card :report="item" :key="index" :index="index" @seleccionado="cardseleccionado"/>
          </template>
        </div>
      </div>
    </div>
    <div v-if="seleccionado">
      <panel :seleccionado="seleccionado" @regresar="regresar" />
    </div>
  </div>
</template>
<script>
import card from "./card";
import panel from "./panel";
export default {
  name: "reportpanel",
  components: { card, panel },
  data() {
    return {
      typereports: [
        {
          tittle: "Ventas",
          titulo:"Reportes de ventas"
        },
        {
          tittle: "Productos",
          titulo:"Reportes de ventas por productos"
        },
        {
          tittle: "Comprobantes",
          titulo: "Reportes de comprobantes fiscales"
        },
        {
          tittle: "Caja",
          titulo: "Reporte de registros de caja"
        },
        {
          tittle: "Reporte 607",
          titulo: "Reporte 607"
        },
        {
          tittle: "Reporte 608",
          titulo: "Reporte 608"
        },
        {
          tittle: "Productos por meses",
          titulo: "Reportes de productos vendidos por meses del año en curso"
        }
      ],
      seleccionado: ""
    };
  },
  methods: {
    regresar() {
      this.seleccionado = "";
    },
    cardseleccionado(i) {
      if (this.typereports[i.index].tittle === "Reporte 607") {
        window.location.href = "/reporte607";
        return;
      }
      if (this.typereports[i.index].tittle === "Reporte 608") {
        window.location.href = "/reporte608";
        return;
      }
      if (this.typereports[i.index].tittle === "Productos por meses") {
        window.location.href = "/reportv2/product/meses";
        return;
      }
      this.seleccionado = this.typereports[i.index].tittle;
    }
  },
  computed: {}
};
</script>
<style>
</style>
