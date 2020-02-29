<template>
  <div class="col-md-6">
    <div class="card" @click="seleccionado" style="cursor: pointer">
      <div class="card-body" style="height:250px;background: #2196f3;">
        <div class="text-center front" style>{{report.tittle}}</div>
      </div>
    </div>
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
<style scoped>
.card-container {
  font-family: "Open Sans", sans serif;
  font-size: 120px;
  font-weight: bold;

  width: 317px;
  height: 184px;
  margin: 11px auto;

  border-radius: 10px;

  perspective: 1400px;
}
.card-mio {
  position: relative;
  height: 100%;
  border-radius: 10px;
  widht: 100%;
  transform-style: preserve-3d;
}
.front {
  font-size: 32px;
  color: #fff;
}
.front,
.back {
  display: flex;

  width: 100%;
  height: 100%;

  border-radius: 10px;

  justify-content: center;
  align-items: center;
  backface-visibility: hidden;
}
.back {
  position: absolute;
  top: 0;
  left: 0;
  transform: rotateY(180deg);
  color: #2196f3;
  background: #fff;
}
</style>