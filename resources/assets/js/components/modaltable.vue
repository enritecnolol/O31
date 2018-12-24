<template>
    <div>
        <modal name="coroto" :draggable="true" :resizable="true" :height="400" :width="800">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center" style="background: #4272d7">
                        <h2 style="color: white">Opciones</h2>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 20px">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div style="margin-left: 30px; height: 300px;background: black;margin-right: 5px">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="text-center">
                                                <h3>Información</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-12">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="margin-right: 30px; height: 300px;background: blue;margin-left: 5px">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>
<script>
    import vmodal from 'vue-js-modal';
    Vue.use(vmodal);
    export default {
        name:'modaltable',
        components:{vmodal},
        props
    }
</script>
<style>

</style>