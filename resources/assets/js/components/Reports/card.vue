<template>
  <div class="col-md-12">
    <p class="phover" @click="seleccionado" style="cursor: pointer;font-size: 22px">
      {{report.titulo}}
    </p>
<!--    <div class="card" style="cursor: pointer">-->
<!--      <div class="card-body" style="height:250px;background: #2196f3;">-->
<!--        <div class="text-center front" style></div>-->
<!--      </div>-->
<!--    </div>-->
  </div>
</template>
<script>
export default {
  name: "card",
  components: {},
  props: ["report", "index"],
  data() {
    return {};
  },
  methods: {
    seleccionado() {
      this.$emit("seleccionado", {
        index: this.index
      });
    }
  },
  computed: {}
};
</script>
<style >
.phover:hover{
  color: #0e3bbb;
  text-decoration:underline;
}
</style>
